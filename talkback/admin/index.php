<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The driver script for the administrator panels
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. This script may contain copyrighted code from another source that was
	released under the GPL. See credits-copyrights.txt for more information.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
ini_set('error_reporting', E_ALL ^ E_NOTICE);
define('IS_VALID_INCLUDE', TRUE);
define ('PROCESSING_ADMIN', TRUE);

require '../config.php';
require '../includes/classAkismet.php';

$data = '';
stripAllSlashes();
$admin = get_admin_cookie();
setlocale(LC_TIME, $config['date_locale']);

if ($admin) {
	// We have no way of knowing when a config edit may have changed admin_cookie (permanent/temporary), so we just recreate the cookie each time
	set_admin_cookie();
	
	// Reset admin notice suppression
	if ($config['admin_notices'] && $config['admin_notices_suppressed']) {
		$result = mysql_query("UPDATE " . DBPREFIX . "config SET option_data=0 WHERE  option_name='admin_notices_suppressed' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 1 <br /> mysql error:<br />' . mysql_error());
	}
	
	if ($_REQUEST['action']         == 'delete'){
		delete_comment();
	} elseif ($_REQUEST['action']   == 'deletespam'){
		delete_spam();
	} elseif ($_REQUEST['action']   == 'deleteunapproved'){
		delete_unapproved();
	} elseif ($_REQUEST['action']   == 'pagelist'){
		page_list();
	} elseif ($_REQUEST['action']   == 'recentlist'){
		recent_list();
	} elseif ($_REQUEST['action']   == 'banip'){
		banip();
//	} elseif ($_REQUEST['action']   == 'search'){
//		select_page();
	} elseif ($_REQUEST['action']   == 'bannedlist'){
		banned_list();
	} elseif ($_REQUEST['action']   == 'unapprovedlist'){
		unapproved_list();
	} elseif ($_REQUEST['action']   == 'spamlist'){
		spam_list();
	} elseif ($_REQUEST['action']   == 'subscriberlist'){
		subscriber_list();
	}  elseif ($_REQUEST['action']  == 'unbanip'){
		unbanip();
	} elseif ($_REQUEST['action']   == 'approve'){
		approve_comment();
	} elseif ($_REQUEST['action']   == 'maintenance'){
		require 'admin-maintenance-tpl.php';
	} elseif ($_REQUEST['action']   == 'displayconfig'){
		require 'admin-config.php';
	} elseif ($_REQUEST['action']   == 'updateconfig'){
		require 'admin-config.php';
	} elseif ($_REQUEST['action']   == 'optimizedb'){
		optimizedb();
	} elseif ($_REQUEST['action']   == 'backupdb'){
		backupdb();
	} elseif ($_REQUEST['action']   == 'purge'){
		purge_comments();
	} elseif ($_REQUEST['action']   == 'logout'){
		logout();
	} elseif ($_REQUEST['action']   == 'select'){
		select_page();
	} else {
		recent_list();
	}
} elseif (isset($_REQUEST['login'])){
	if ($_REQUEST['login'] == $config['admin_login'] && $_REQUEST['password'] == $config['admin_password']) {
		set_admin_cookie();
	}
	$query_string = urldecode($_REQUEST['query_string']);
	header("HTTP/1.1 302");
	header("Location:  ".URL_PATH."admin/$query_string");
} else {
	if ($_REQUEST['action']) $_REQUEST['query_string'] = "?action={$_REQUEST['action']}";
	require 'admin-login.php';
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin functions
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

function logout() {
	global $config;
	setcookie($cookie_name, $data, $cookie['expires'], "/", false, 0);
	setcookie ($config['cookie_name'].'Admin', "", 1, '/', false, 0);
	header("HTTP/1.1 302");
	header("Location: ".URL_PATH."admin");
}

function page_list() {
	global $dblink, $config, $lang;
	
	$request_uri = mysql_real_escape_string(urldecode($_REQUEST['href']));
	$result = mysql_query("SELECT id, replyto, time, href, text, author, email, website, ip, moderate, email_reply, location FROM " . DBPREFIX . "data WHERE href='$request_uri' ORDER BY time desc", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 2 <br /> mysql error:<br />' . mysql_error());
	
	$ccount = 0;
	while (list($id[$ccount], $replyto[$ccount], $time[$ccount], $href[$ccount], $text[$ccount], $author[$ccount], $email[$ccount], $website[$ccount], $ip[$ccount], $moderate[$ccount], $email_reply[$ccount], $location[$ccount])=mysql_fetch_array($result)) {
		$banned_msg[$ccount] = get_banned($ip, $ccount);
		$author[$ccount]       = $author[$ccount] . '/' . $location[$ccount];
		if ($website[$ccount]) 
			$website[$ccount] = "<a href='{$website[$ccount]}'>" . preg_replace('#http://#', '', $website[$ccount]) . "</a>";
		
		if ($config['is_demo_system']) 
			// Don't want to show any real addresses
			$email[$ccount]         = 'nobody@nowhere.com';
		
		if ($id[$ccount] != $replyto[$ccount]) {
			$reply_class[$ccount]   = 'reply';
			$reply_label[$ccount]   = "<span class='reply'>{$lang['reply_label']} {$replyto[$ccount]}</span>";
		} else {
			$reply_class[$ccount]   = '';
			$reply_label[$ccount]   = '';
			
			// Check if author is subscribed
			$subresult = mysql_query("SELECT id FROM " . DBPREFIX . "subscribers WHERE href='$href[$ccount]' AND email='$email[$ccount]' LIMIT 1", $dblink);
			if (!$subresult) fatal_error(0, 0, 'DB query error, admin index 3 <br /> mysql error:<br />' . mysql_error());
			
			$is_subscribed   = mysql_num_rows($subresult);
			$is_subscribed   = $is_subscribed + $email_reply[$ccount];
			if ($is_subscribed) $subscribed_label[$ccount] = $lang['subscribed_label'];
		}
		
		$ccount++;
	}
	
	$tresult = mysql_query("SELECT title  from " . DBPREFIX . "articles WHERE href='$request_uri' LIMIT 1", $dblink);
	list($title) = mysql_fetch_row($tresult);
	
	$spam_count_msg  = get_spam_count();
	$counts_msg      = get_counts();
	require 'admin-comments-page-tpl.php';
}

function recent_list() {
	global $dblink, $config, $lang;
	
	$temp         = getdate(time()-(86400 * $config['num_of_days']));
	$begin_date   = mktime(0,0,0,$temp["mon"],$temp["mday"],$temp["year"]);
	
	$result = mysql_query("SELECT id, replyto, time, href, text, author, email, website, ip, moderate, email_reply, location FROM " . DBPREFIX . "data WHERE time >= '$begin_date' ORDER BY time desc", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 4 <br /> mysql error:<br />' . mysql_error());
	
	$ccount = 0;
	while (list($id[$ccount], $replyto[$ccount], $time[$ccount], $href[$ccount], $text[$ccount], $author[$ccount], $email[$ccount], $website[$ccount], $ip[$ccount], $moderate[$ccount], $email_reply[$ccount], $location[$ccount])=mysql_fetch_array($result)) {
		$banned_msg[$ccount]   = get_banned($ip, $ccount);
		$author[$ccount]       = $author[$ccount] . '/' . $location[$ccount];
		if ($website[$ccount]) 
			$website[$ccount]   = "<a href='{$website[$ccount]}'>" . preg_replace('#http://#', '', $website[$ccount]) . "</a>";
		
		if ($config['is_demo_system']) 
			// Don't want to show any real addresses
			$email[$ccount]     = 'nobody@nowhere.com';
			
		if ($id[$ccount] != $replyto[$ccount]) {
			$reply_class[$ccount]   = 'reply';
			$reply_label[$ccount]   = "<span class='reply'>{$lang['reply_label']} {$replyto[$ccount]}</span>";
		} else {
			$reply_class[$ccount]   = '';
			$reply_label[$ccount]   = '';
			
			// Check if author is subscribed
			$subresult = mysql_query("SELECT id FROM " . DBPREFIX . "subscribers WHERE href='$href[$ccount]' AND email='$email[$ccount]' LIMIT 1", $dblink);
			if (!$subresult) fatal_error(0, 0, 'DB query error, admin index 5 <br /> mysql error:<br />' . mysql_error());
			
			$is_subscribed   = mysql_num_rows($subresult);
			$is_subscribed   = $is_subscribed + $email_reply[$ccount];
			if ($is_subscribed) $subscribed_label[$ccount]  = $lang['subscribed_label'];
		}
		
		$tresult = mysql_query("SELECT title  from " . DBPREFIX . "articles WHERE href='{$href[$ccount]}' LIMIT 1", $dblink);
		list($title[$ccount]) = mysql_fetch_row($tresult);
		
		$ccount++;
	}
	
	$spam_count_msg = get_spam_count();
	$counts_msg = get_counts();
	require  'admin-comments-recent-tpl.php';
}

function unapproved_list() {
	global $dblink, $config, $lang;
	
	$result = mysql_query("SELECT id, replyto, time, href, text, author, email, website, ip, moderate, email_reply, location FROM " . DBPREFIX . "data WHERE moderate>0 ORDER BY time DESC", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 6 <br /> mysql error:<br />' . mysql_error());
	
	$ccount = 0;
	$id=$replyto=$time=$href=$text=$author=$email=$website=$ip=$moderate=$email_reply=array();
	while (list($id[$ccount], $replyto[$ccount], $time[$ccount], $href[$ccount], $text[$ccount], $author[$ccount], $email[$ccount], $website[$ccount], $ip[$ccount], $moderate[$ccount], $email_reply[$ccount], $location[$ccount])=mysql_fetch_array($result)) {
		$banned_msg[$ccount]   = get_banned($ip, $ccount);
		$author[$ccount]       = $author[$ccount] . '/' . $location[$ccount];
		if ($website[$ccount]) 
			$website[$ccount]   = "<a href='{$website[$ccount]}'>" . preg_replace('#http://#', '', $website[$ccount]) . "</a>";
		
		if ($config['is_demo_system']) 
			// Don't want to show any real addresses
			$email[$ccount]        = 'nobody@nowhere.com';
		
		if ($id[$ccount] != $replyto[$ccount]) {
			$reply_class[$ccount]  = 'reply';
			$reply_label[$ccount]  = "<span class='reply'>{$lang['reply_label']} {$replyto[$ccount]}</span>";
		} else {
			$reply_class[$ccount]  = '';
			$reply_label[$ccount]  = '';
			
			// Check if author is subscribed
			$subresult = mysql_query("SELECT id FROM " . DBPREFIX . "subscribers WHERE href='$href[$ccount]' AND email='$email[$ccount]' LIMIT 1", $dblink);
			if (!$subresult) fatal_error(0, 0, 'DB query error, admin index 7 <br /> mysql error:<br />' . mysql_error());
			
			$is_subscribed   = mysql_num_rows($subresult);
			$is_subscribed   = $is_subscribed + $email_reply[$ccount];
			if ($is_subscribed) $subscribed_label[$ccount] = $lang['subscribed_label'];
		}
		
		$tresult = mysql_query("SELECT title  from " . DBPREFIX . "articles WHERE href='{$href[$ccount]}' LIMIT 1", $dblink);
		list($title[$ccount]) = mysql_fetch_row($tresult);
		
		$ccount++;
	}
	
	$spam_count_msg = get_spam_count();
	$counts_msg = get_counts();
	require 'admin-comments-unapproved-tpl.php';
}

function spam_list() {
	global $dblink, $config, $lang;
	
	$result = mysql_query("SELECT id, time, href, text, author, email, website, ip FROM " . DBPREFIX . "spam ORDER BY time DESC", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 8 <br /> mysql error:<br />' . mysql_error());
	
	$ccount = 0;
	$id=$time=$href=$text=$author=$email=$website=$ip=$banned_msg=array();
	while (list($id[$ccount], $time[$ccount], $href[$ccount], $text[$ccount], $author[$ccount], $email[$ccount], $website[$ccount], $ip[$ccount])=mysql_fetch_array($result)) {
		$banned_msg[$ccount]  = get_banned($ip, $ccount);
		if ($website[$ccount]) 
			$website[$ccount]  = "<a href='{$website[$ccount]}'>" . preg_replace('#http://#', '', $website[$ccount]) . "</a>";
		if ($config['is_demo_system']) 
			// Don't want to show any real addresses
			$email[$ccount]    = 'nobody@nowhere.com';
			
		$tresult = mysql_query("SELECT title  from " . DBPREFIX . "articles WHERE href='{$href[$ccount]}' LIMIT 1", $dblink);
		list($title[$ccount]) = mysql_fetch_row($tresult);
		
		$ccount++;
	}
	
	$spam_count_msg  = get_spam_count();
	$counts_msg      = get_counts();
	require 'admin-comments-spam-tpl.php';
}

function subscriber_list() {
	global $dblink, $config, $lang;
	
	$order = ($_REQUEST['order']) ? mysql_real_escape_string($_REQUEST['order']) : 'href';
	
	$result = mysql_query("SELECT id, email, href, time, name FROM " . DBPREFIX . "subscribers ORDER BY $order", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 9 <br /> mysql error:<br />' . mysql_error());
	
	$subscriber_count  = 0;
	$id=$email=$href=$time=array();
	while (list($id[$subscriber_count],$email[$subscriber_count], $href[$subscriber_count], $time[$subscriber_count], $name[$subscriber_count]) = mysql_fetch_array($result)) {
		
		if ($config['is_demo_system']) 
			// Don't want to show any real addresses
			$email[$subscriber_count] = 'nobody@nowhere.com';
		
		$subscriber_count++;
	}
	require 'admin-subscribers-tpl.php';
}

function banned_list() {
	global $dblink, $config, $lang;
	
	$result = mysql_query("SELECT ip, time FROM " . DBPREFIX . "banned", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 10 <br /> mysql error:<br />' . mysql_error());
	
	$ip_count = 0;
	$ip=$time=array();
	while (list($ip[$ip_count], $time[$ip_count]) = mysql_fetch_row($result)) {
		$ip_count++;
	}
	require 'admin-banned-tpl.php';
}

// Approve a comment
function approve_comment() {
	global $dblink, $config, $lang, $article_title;
	
	$id = mysql_real_escape_string($_REQUEST['id']);

	if ($_REQUEST['return'] != 'spamlist') {
		// Just update the moderation flag and article count
		$result = mysql_query("UPDATE " . DBPREFIX . "data SET moderate=0 WHERE id='$id' ", $dblink);
		$result = mysql_query("SELECT href FROM " . DBPREFIX . "data WHERE id='$id' ", $dblink);
		$row    = mysql_fetch_array($result);
		update_comment_count($row[0], 'add');
		
	} else {
		// copy the comment to table 'data', delete the comment in table 'spam', notify akismet, notify subscribers
		$result = mysql_query("SELECT ID, replyto, time, href, text, author, email, website, ip, article_title FROM " . DBPREFIX . "spam WHERE ID='$id' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 11 <br /> mysql error:<br />' . mysql_error());
		
		$row   = mysql_fetch_array($result);
		$row   = mysql_escape_array($row);
		$time  = time(); // Change comment time to now to maintain the time/id equivalence
		
		$result = mysql_query("INSERT INTO " . DBPREFIX . "data SET time='$time', href='{$row[3]}', text='{$row[4]}', author='{$row[5]}', email='{$row[6]}', website='{$row[7]}', ip='{$row[8]}' ", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 12 <br /> mysql error:<br />' . mysql_error());
		
		$new_id    = mysql_insert_id();
		
		$result = mysql_query("UPDATE " . DBPREFIX . "data SET replyto='$new_id' WHERE id='$new_id' ", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 13 <br /> mysql error:<br />' . mysql_error());
		
		$article_title = $row[9];		
		update_comment_count($row[3], 'add');
		
		$result = mysql_query("DELETE FROM " . DBPREFIX . "spam WHERE id='$id' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 14 <br /> mysql error:<br />' . mysql_error());
		
		// Notify Akisment of mis-diagnosis
		if ($config['akismet_key'] && !TESTING) {
			$comment = tbget_comment($id, 'data');
			$data = array(
			'type'			=> 'comment',
			'author'			=> $comment['author'],
			'email'			=> $comment['email'],
			'website'		=> $comment['website'],
			'body'			=> $comment['text'],
			'permalink'		=> SITE_URL . $comment['href'],
			'user_ip'		=> $comment['ip'],
			'user_agent'	=>	$comment['user_agent']
			);
			$akismet = new Akismet(SITE_URL, $config['akismet_key'], $data);
			if (!$akismet->errorsExist()) $akismet->submitHam();
		}
	}
	return_to_page();
}

// Delete a comment
function delete_comment() {
	global $dblink, $config, $lang;
	$id = mysql_real_escape_string($_REQUEST['id']);
	$comment = tbget_comment($id, 'data');
	
	// Notify Akisment of mis-diagnosis
	if ($_REQUEST['spam'] == 'spam' && $config['akismet_key'] && !TESTING) {
		$data = array(
			'type'			=> 'comment',
			'author'		=> $comment['author'],
			'email'			=> $comment['email'],
			'website'		=> $comment['website'],
			'body'			=> $comment['text'],
			'permalink'		=> SITE_URL . $comment['href'],
			'user_ip'		=> $comment['ip'],
			'user_agent'	=>	$comment['user_agent']
			);
		$akismet = new Akismet(SITE_URL, $config['akismet_key'], $data);
		if (!$akismet->errorsExist()) $akismet->submitSpam();
	}
	
	if ($_REQUEST['return'] != 'spamlist') {
		$table = 'data';
	} else {
		$table = 'spam';
	}
	delete_row($table, $id, $_REQUEST['page']);
	return_to_page();
}

// Deletes all unapproved comments
function delete_unapproved() {
	global $dblink, $config, $lang;
	$result = mysql_query("DELETE FROM " . DBPREFIX . "data WHERE moderate>0", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 16 <br /> mysql error:<br />' . mysql_error());
	
	return_to_page();
}

// Deletes all rows in the spam table
function delete_spam() {
	global $dblink, $config, $lang;
	$result = mysql_query("TRUNCATE " . DBPREFIX . "spam", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 15 <br /> mysql error:<br />' . mysql_error());
	
	return_to_page();
}

function banip() {
	global $dblink, $config, $lang;
	
	$ip     = mysql_real_escape_string($_REQUEST['ip']);
	$time   = time();
	$result = mysql_query("INSERT INTO " . DBPREFIX . "banned VALUES ('$ip', '$time')", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 16 <br /> mysql error:<br />' . mysql_error());
	
	return_to_page();
}

function unbanip() {
	global $dblink, $config, $lang;
	
	$ip      = mysql_real_escape_string($_REQUEST['ip']);
	$result  = mysql_query("DELETE FROM " . DBPREFIX . "banned WHERE ip='$ip'", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 17 <br /> mysql error:<br />' . mysql_error());
	
	return_to_page();
}

function get_banned($ip, $ccount) {
	global $dblink, $config, $lang;
	
	$result      = mysql_query("SELECT ip FROM " . DBPREFIX . "banned WHERE ip='$ip[$ccount]'", $dblink);
	$banned_msg  = (mysql_num_rows($result)) ? $lang['banned'] : '';

	return $banned_msg;
}

function get_counts() {
	global $dblink, $config, $lang;
	
	$result = mysql_query("SELECT COUNT(id) FROM " . DBPREFIX . "data WHERE moderate != 0", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 18 <br /> mysql error:<br />' . mysql_error());
	list($unapproved_count) = mysql_fetch_row($result);
	
	$result = mysql_query("SELECT COUNT(id) FROM " . DBPREFIX . "spam", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 19 <br /> mysql error:<br />' . mysql_error());
	list($spam_count) = mysql_fetch_row($result);
	
	$temp = getdate(time()-(86400 * $config['num_of_days']));
	$begin_date  = mktime(0,0,0,$temp["mon"],$temp["mday"],$temp["year"]);
	$result = mysql_query("SELECT COUNT(id) FROM " . DBPREFIX . "data WHERE time >= '$begin_date'", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 20 <br /> mysql error:<br />' . mysql_error());
	list($recent_count) = mysql_fetch_row($result);
	
	$result = mysql_query("SELECT COUNT(ip) FROM " . DBPREFIX . "banned", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 21 <br /> mysql error:<br />' . mysql_error());
	list($banned_count) = mysql_fetch_row($result);
	
	$result = mysql_query("SELECT COUNT(id) FROM " . DBPREFIX . "subscribers", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 22 <br /> mysql error:<br />' . mysql_error());
	list($subscribers_count) = mysql_fetch_row($result);
	
	return("<div class='unapproved-count'>
	{$lang['recent']} $recent_count <img src='../images/bullet-square-w.gif' alt='' width='5' height='9' /> 
	{$lang['unapproved']} $unapproved_count <img src='../images/bullet-square-w.gif' alt='' width='5' height='9' /> 
	{$lang['spam']} $spam_count <img src='../images/bullet-square-w.gif' alt='' width='5' height='9' /> 
	{$lang['banned1']} $banned_count <img src='../images/bullet-square-w.gif' alt='' width='5' height='9' /> 
	{$lang['subscribers']} $subscribers_count 
	</div>");
}

function get_spam_count() {
	global $dblink, $config, $lang;
	
	$result = mysql_query("SELECT option_data from " . DBPREFIX . "config WHERE option_name='spam_count' LIMIT 1", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 23 <br /> mysql error:<br />' . mysql_error());
	
	list($spam_count) = mysql_fetch_array($result);
	$spam_count = number_format($spam_count);
	return("<div class='spam-count'>{$lang['spam_count']} $spam_count</div>");
}

function select_page() {
	global $dblink, $config, $lang;
	$query = mysql_real_escape_string($_REQUEST['query']);
	$result = mysql_query("SELECT href from " . DBPREFIX . "data WHERE href like '%{$query}%' GROUP BY href");
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 24 <br /> mysql error:<br />' . mysql_error());
	$all_count = mysql_num_rows($result);
	$limit_string = '';
	$pages = 0;
	$records_per_page = 999999;
	if ($all_count > $records_per_page) { 
		$page = $_REQUEST['page'];
		if ($page > 0) { $page=$page-1; }
		$first_record = ($page) * $records_per_page;
		$limit_string = "LIMIT $first_record, $records_per_page";
		$pages=$all_count/$records_per_page;
		if ($pages > (int) $pages) { $pages=(int)$pages+1; }
	}
	if ($pages>1) {
		$pages_string.=$lang['page'];
		if ($page>10 && $pages>20) { $first_page=$page-9; }
		else { $first_page=1; }
		if ($pages>20 && ($page+10)<$pages) { $last_page=$first_page+19; } 
		else { $last_page=$pages; }
		if ($page+1>1) {
			$prev=$page;
			$pages_string.="<a href=" .TB_PATH. "admin?action=search&query=$query&page=$prev'>&laquo;</a>&nbsp;&nbsp;";
		}
		for ($i=$first_page; $i<=$last_page; $i++){
			if ($i != $page+1) {
				$pages_string.="<a href=" .TB_PATH. "admin?action=search&query=$query&page=$i'>$i</a>&nbsp; ";
			}
			else {
				$pages_string.="<b>$i</b>&nbsp; ";
			}
		}
		if ($page+1<$pages) {
			$next=$page+2;
				$pages_string.="<a href=" .TB_PATH. "admin?action=search&query=$query&page=$next'>&raquo;</a>&nbsp&nbsp";
			}
	}
	$result = mysql_query("SELECT href, COUNT(*) as count, MAX(time) as maxtime from " . DBPREFIX . "data WHERE href like '%{$query}%' GROUP BY href ORDER BY maxtime DESC {$limit_string}", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, admin index 25 <br /> mysql error:<br />' . mysql_error());
	$href=$count=array();
	$hrefs_count=0;
	while (list($href[$hrefs_count], $count[$hrefs_count], $title[$hrefs_count]) = mysql_fetch_row($result)){
		$tresult = mysql_query("SELECT title  from " . DBPREFIX . "articles WHERE href='{$href[$hrefs_count]}' LIMIT 1", $dblink);
		list($title[$hrefs_count]) = mysql_fetch_row($tresult);
		$hrefs_count++;
	}
	unset($href[$hrefs_count]);
	rnatsort($href); // natural order sort, descending
	
	$spam_count_msg = get_spam_count();
	$counts_msg = get_counts();
	require  'admin-select-page-tpl.php';
}

function rnatsort(&$a){
    natsort($a);
    $a = array_reverse($a, true);
}

// Purge comments
function purge_comments() {
	global $dblink, $config, $lang;
	
	if ($config['is_demo_system']) {
		require 'admin-maintenance-tpl.php';
		exit();
	}
	
	$days = intval($_REQUEST['purge_days']);
	if (!$days) {
		$display_message .= "<div class='display-message'>{$lang['purge_days_zero']}</div>\n";
	} else {
		$purge_date = time()-($days*86400);
		
		// Update comments count
		$result = mysql_query("SELECT href FROM " . DBPREFIX . "data WHERE time<='$purge_date' ", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 26 <br /> mysql error:<br />' . mysql_error());
		while (list($page) = mysql_fetch_array($result)) {
			update_comment_count($page, 'delete');
		}
		
		// Delete the comments
		$result = mysql_query("DELETE FROM " . DBPREFIX . "data WHERE time<='$purge_date'", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, admin index 27 <br /> mysql error:<br />' . mysql_error());
		$rows = mysql_affected_rows($dblink);
		
		$purge_date = strftime($config['admin_date'], $purge_date);
		require LANGUAGE_FILE;
		$display_message .= "<div class='display-message'>{$lang['comments_purged']}</div>\n";
	}
	require 'admin-maintenance-tpl.php';
}

function optimizedb() {
	global $dblink, $config, $lang;
	
	if ($config['is_demo_system']) {
		require 'admin-maintenance-tpl.php';
		exit();
	}
	
	$result           = clear_user_agent(0);
	$display_message  = "<div class='display-message'>\nStarting optimization<br />\n";
	
	$result = mysql_query("OPTIMIZE TABLE " . DBPREFIX . "banned, " . DBPREFIX . "data, " . DBPREFIX . "spam, " . DBPREFIX . "config, " . DBPREFIX . "subscribers", $dblink);
	$display_message .= (!$result) ? mysql_error() : "Completed optimization<br />\n</div>\n";
	
	require 'admin-maintenance-tpl.php';
}

function backupdb() {
	global $dblink, $config, $lang, $backup_error;
	
	if ($config['is_demo_system']) {
		require 'admin-maintenance-tpl.php';
		exit();
	}
	
	$result = clear_user_agent(0);
	if (!@is_writable(FILES_PATH)) {
		$display_message .= "<div class='display-message'>{$lang['files_directory_err1']}</div>\n";
		require 'admin-maintenance-tpl.php';
		exit();
	}

	// dump the database
	$time		= date('Ymd-Hi');
	$filename	= DBNAME . '_' . $time . '.sql.gz';
	$path		= FILES_PATH . $filename;
	$cmd		= "{$config['mysqldump_path']} --host ".DBHOST." --user ".DBUSER." --password=".DBPASS." ".DBNAME. " "
				.DBPREFIX."banned ".DBPREFIX."config ".DBPREFIX."data ".DBPREFIX."spam "
				.DBPREFIX."subscribers "
				." | gzip > $path";
				
	$last_line	= system($cmd, $result);

	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=$filename");
	
	if ($handle = fopen($path, 'rb')) {
		while(!feof($handle) and (connection_status()==0)) {
			print(fread($handle, 1024*8));
			flush();
		}
		fclose($handle);
		$result = unlink($path);
	}
}
?>