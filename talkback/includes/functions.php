<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	These functions are called from more than one script
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
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

// Database open
function open_db($return=0) {
	global $lang, $config, $dblink;
	
	$start_time = time();
	$difference = 0;
	// If we can't connect to the db we'll try again for 5 seconds
	while(!($dblink = @mysql_connect(DBHOST,DBUSER,DBPASS, true)) && $difference < 5) {
		$difference = time() - $start_time;
	}
	if (!$dblink) {
		if ($return) {
			return '';
		} else {
			fatal_error(0, 0, 'DB query error, functions.php open_db() - trying to connect to the server<br />Mysql error is: <br /><br />'.mysql_error());
		}
	} else {
		$result = @mysql_select_db(DBNAME, $dblink);
		if (!$result) {
			if ($return) {
				return '';
			} else {
				fatal_error(0, 0, 'DB query error, functions.php open_db() - trying to select the database<br />Mysql error is: <br /><br />'.mysql_error());
			}
		}
	return $dblink;
	}
}

// Get configuration entries from db and add them to the config array
function get_config() {
	global $dblink, $config, $lang;
	
	$result = mysql_query("SELECT option_name, option_data FROM " . DBPREFIX . "config", $dblink);
	if (!$result) fatal_error(0, 0, "DB query error, functions.php, get_config()<br />mysql error:<br />" . mysql_error());
	$name=$data=array();
	while (list($name, $data)=mysql_fetch_array($result)) {
		$config[$name] = $data;
	}
	return $config;
}

// Create admin cookie
function set_admin_cookie() {
	global $config, $admin_cookie, $dblink;
	
	$string = random_string(32,0);
	$data = mysql_real_escape_string('data=' . $string);
	$result = mysql_query("UPDATE " . DBPREFIX . "config SET option_data = '$string' WHERE option_name = 'admin_hash' ", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, functions.php, set_admin_cookie()<br /> mysql error:<br />' . mysql_error());
	
	$cookie_name = $config['cookie_name'] . 'Admin';
	$cookie['expires'] = ($config['admin_cookie']) ? time()+(60*60*24*365) : $cookie['expires'] = 0;
	setcookie($cookie_name, $data, $cookie['expires'], "/", false, 0);
}

// Get admin cookie
function get_admin_cookie() {
	global $config, $data;
	
	$cookie_name = $config['cookie_name'] . 'Admin';
	if (isset($_COOKIE[$cookie_name])) {
		parse_str($_COOKIE[$cookie_name]);
		if ($data == ADMIN_HASH) {
			return 1;
		} elseif ($_REQUEST['login'] == $config['admin_login'] && $_REQUEST['password'] == $config['admin_password'] ) {
			set_admin_cookie();
			header("HTTP/1.1 302");
			header("Location:" .URL_PATH. "admin");
		}
	}
	return 0;
}

// Create author cookie or update its expiration date
function set_author_cookie() {
	global $config, $cookie;
	
	// Author data may or may not have changed
	$cookie['author_name']		= $_REQUEST['form_author'];
	$cookie['author_email']		= $_REQUEST['form_email'];
	$cookie['author_website']	= $_REQUEST['form_website'];
	$cookie['author_location']	= $_REQUEST['form_location'];
	$cookie['sort_order']		= $_REQUEST['sortorder'];
	$cookie['num_rows']			= $_REQUEST['numrows'];
	if ($_REQUEST['form_rememberme']) {
		$cookie['expires']		= time()+(60*60*24*365);	
		$cookie['rememberme']	= 1;
	} else {
		$cookie['expires']		= 0;
		$cookie['rememberme']	= 0;
	}	
	
	// regex patterns needed for cookie elements, need to validate them here
	
	$data  = "author_name={$cookie['author_name']}";
	$data .= "&author_email={$cookie['author_email']}";
	$data .= "&author_website={$cookie['author_website']}";
	$data .= "&author_location={$cookie['author_location']}";
	$data .= "&num_rows={$cookie['num_rows']}";
	$data .= "&sort_order={$cookie['sort_order']}";
	$data .= "&rememberme={$cookie['rememberme']}";
	setcookie($config['cookie_name'], $data, $cookie['expires'], "/", false, 0);
}

// Get author cookie data and place in $cookie array
function get_author_cookie() {
	global $config;
	
	$cookie_name = $config['cookie_name'];
	if (isset($_COOKIE[$cookie_name])) {
		parse_str($_COOKIE[$cookie_name], $cookie);			
	} else {
		// Visitor hasn't checked "Remember me"
		$cookie['author_name']		= '';
		$cookie['author_email']		= '';
		$cookie['author_website']	= 'http://';
		$cookie['author_location']	= '';
		$cookie['sort_order']		= 'DESC';
		$cookie['num_rows'] 			= $config['page_limit'];
		$cookie['rememberme']		= 0;
		$cookie['expires']			= 0;
	}
	
	// regex patterns needed for cookie elements, need to validate them here
	
	if (!$cookie['author_website']) $cookie['author_website'] = 'http://';
	
	// Note that after returning, at first opportunity we will set a cookie using 
	// $cookie data whether or not the visitor checked Remember me. 
	return $cookie;
}

// Retrieves all comment data for a single comment
function tbget_comment($id, $table) {
	global $dblink, $config, $lang;
	$comment=array();
	
	if ($table = 'data') {
		$result = mysql_query("SELECT replyto, time, href, text, author, email, website, ip, moderate, email_reply, user_agent, location, subject FROM " . DBPREFIX . "data WHERE id='$id' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, functions.php, tbget_comment() 1<br /> mysql error:<br />' . mysql_error());
		list($comment['replyto'], $comment['time'], $comment['href'], $comment['text'], $comment['author'], $comment['email'], $comment['website'], $comment['ip'], $comment['moderate'], $comment['email_reply'], $comment['user_agent'], $comment['location'], $comment['subject']) = mysql_fetch_row($result);
	
	} else {
		$result = mysql_query("SELECT replyto, time, href, text, author, email, website, ip, user_agent FROM " . DBPREFIX . "spam WHERE id='$id' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, functions.php, tbget_comment() 2<br /> mysql error:<br />' . mysql_error());
		list($comment['time'], $comment['replyto'], $comment['href'], $comment['text'], $comment['author'], $comment['email'], $comment['website'], $comment['ip'], $comment['user_agent'])= mysql_fetch_row($result);
		$comment['moderate'] = 0;
	}
	
	return $comment;
}

// Some functions can be invoked from different sources. This functions keeps the 
// header definition in one place and ensures the correct header string is used.
function return_to_page() {
	global $config;
	
	header("HTTP/1.1 302");
	if ($_REQUEST['return'] == 'unapprovedlist') {
		header("Location:".URL_PATH."admin?action=unapprovedlist");
	} elseif ($_REQUEST['return'] == 'pagelist') {
		header("Location:".URL_PATH."admin?action=pagelist&href={$_REQUEST['from']}");
	} elseif ($_REQUEST['return'] == 'recentlist') {
		header("Location:".URL_PATH."admin?action=recentlist");
	} elseif ($_REQUEST['return'] == 'spamlist') {
		header("Location:".URL_PATH."admin?action=spamlist");
	} elseif ($_REQUEST['return'] == 'bannedlist') {
		header("Location:".URL_PATH."admin?action=bannedlist");
	} elseif ($_REQUEST['return'] == 'subscriberlist') {
		header("Location:".URL_PATH."admin?action=subscriberlist&order={$_REQUEST['order']}");
	} elseif ($_REQUEST['return'] == 'comments') {
		$start_page = redisplay_same_page();
		header("Location: ".SITE_URL."{$_REQUEST['page']}?language=$lang$separator&$start_page");
	} else {
		header("Location:".URL_PATH."admin");
	}
}

// Unrecoverable error routine
function fatal_error($return, $type, $display_message) {
	global $dblink, $config, $lang, $user_lang;
	
		// $return: 0 don't return, 1 return
		// $type:   9 don't send admin email
	if (!$testing && $type != 9) {
		// Send email notice to admin
		set_default_language();
		$subject        = "{$lang['dberror_subject']} {$config['site_name']}";
		$bounces        = 1;
		
		$admin_message  = str_replace("<br />", LF, $display_message);
		if (mysql_error())  $admin_message .= LF. 'mySQL error = ' .LF. mysql_error() .LF;
		send_email('admin', $subject, $admin_message, $bounces, '');
		reset_language($user_lang);
		if ($return) return;
	}
	if (!TESTING) $display_message = ''; // We don't want visitor to see the cause of the problem
	
	// Print display message
	$footnote = $lang['fatal_error1'];
	$mc_link  = $lang['browser_back'];
	require MESSAGE_PANEL_TPL;
	exit();
}

// Print formatted spam count
function spam_count() {
	global $config;
	print number_format($config['spam_count']);
}

// Create random string
function random_string($length=8, $spec_chars=0) {
	$string = "";
	$possible = "0123456789abcdfghjkmnpqrstvwxyzABCDFGHJKMNPQRSTVWXYZ"; 
	if ($spec_chars) $possible .= "~!@#$%^&*_+?~";
	while ($i < $length) { 
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($string, $char)) { 
			$string .= $char;
			$i++;
		}
	}
	return $string;
}

// Send email to confirm subscription
function confirm_subscription($display_message) {
	global $dblink, $config, $comment_id, $lang, $user_lang;
	
	// these emails are sent using the user's chosen language which is the currently set language
	if (!TESTING) {
		$result = mysql_query("SELECT COUNT(*) from " . DBPREFIX . "subscribers WHERE href='{$_REQUEST['page']}' AND email='{$_REQUEST['form_email']}'", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, functions.php, confirm_subscription()<br /> mysql error:<br />' . mysql_error());
		list ($count)        = mysql_fetch_row($result);
		$return_lang         = ($user_lang) ? "?language=$user_language" : '';
		$mc_link             = "<a href='{$_REQUEST['page']}$return_lang'>{$lang['return_link_text']}</a>";
		$subject             = $lang['email_cs_subject'];
		if ($count == 0) {
			$display_message  .= "{$lang['confirm_subscription']}";
			$link             = URL_PATH."subscriptions.php?email={$_REQUEST['form_email']}&action=";
			$link            .= ($_REQUEST['form_subscribe'] == 1) ? "subscribe1&page={$_REQUEST['page']}" : "subscribe2&tbid=$comment_id&page={$_REQUEST['page']}";
			$body             = $lang['email_cs_text'] .LF.LF. $link .LF;
			$bounces          = 0;
			send_email($_REQUEST['form_email'], $subject, $body, $bounces, '');
		} else {
			$display_message  = "{$lang['already_subscribed']}";
		}
		require MESSAGE_PANEL_TPL;
	}
	if ($display_message) require MESSAGE_PANEL_TPL;
}

// Set user_agent in data table to empty
function clear_user_agent($return) {
	global $dblink, $config, $lang;
	
	$date = (time() - ($config['user_agent_days'] * 86400));
	$result = mysql_query("UPDATE " . DBPREFIX . "data SET user_agent = '' WHERE user_agent != '' AND time <= '$date' ");
	if (!$result) {
		if ($return) {
			return 'DB query error, functions.php, clear_user_agent';
		} else {
			fatal_error(0, 0, 'DB query error, functions.php, clear_user_agent()<br /> mysql error:<br />' . mysql_error());
		}
	}
}

// Send email
function send_email($to, $subject, $body, $bounces, $cc) {
	global $config;
	
	if (!TESTING) {
		$cc         = ($cc) ? "Cc: $cc" : '';
		$to			= ($to == 'admin') ? ADMIN_EMAIL : $to;
		$headers		= "From: {$config['email_from']}" .LF
						. "Content-Type: text/plain; charset=utf-8" .LF 
						. "Content-Transfer-Encoding: 8bit" .LF
						. $cc .LF;
		
		ini_set('sendmail_from', $config['email_from']);
		mail($to, $subject, $body, $headers);
	}
}

// Send a file to the browser
function send_file($path, $filename) {
	ob_end_clean();
  
	if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
		// workaround for IE filename bug with multiple periods / multiple dots in filename
		// that adds square brackets to filename - eg. setup.abc.exe becomes setup[1].abc.exe
		$filename = preg_replace('/\./', '%2e', $filename, substr_count($filename, '.') - 1);
	}
	
	$path .= $filename;
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	
	if ($file = fopen($path, 'r')) {
		while(!feof($file) and (connection_status()==0)) {
			print(fread($file, 1024*8));
			flush();
		}
		fclose($filename);
	} else {
		return 'Invalid file name/path';
	}
	return 'File transfer completed';
}

// Force redisplay of the same comments page
function redisplay_same_page() {
	global $start_page2, $separator;
	
	if ($_REQUEST['rowcount'] != 1) {
		$_REQUEST['rowstart'] = $_REQUEST['rowstart'] + $_REQUEST['numrows'];
		$_REQUEST['rowend']	 = $_REQUEST['rowend'] + $_REQUEST['numrows'];
	}
	if ($_REQUEST['language']) $separator = '&';
	$start_page  = $separator."rowstart={$_REQUEST['rowstart']}&numrows={$_REQUEST['numrows']}&page={$_REQUEST['page']}&article_url={$_REQUEST['article_url']}";
	$start_page2 = $separator."rowstart={$_REQUEST['rowstart']}&numrows={$_REQUEST['numrows']}";
	return $start_page;
}

// Are we using the default language or user's choice?
function setup_language() {
	global $user_lang, $tb_language;

	if ($_REQUEST['language'] && $_REQUEST['language'] != DEFAULT_LANGUAGE) {
		if (!is_file(ABS_PATH . 'language/' . $_REQUEST['language'] . '.php'))  {
			// Hacking/spam attempt with garbage in language field
			exit;
		}
		// visitor has selected a language
		define('LANGUAGE_FILE', ABS_PATH . 'language/' . $_REQUEST['language'] . '.php');
	} elseif ($tb_language) {
		// it was set in the page that invoked comments.php
		define('LANGUAGE_FILE', ABS_PATH . 'language/' . $tb_language . '.php');
		$_REQUEST['language'] = $tb_language;
	} else {
		// use the default language
		define('LANGUAGE_FILE', ABS_PATH . 'language/' . DEFAULT_LANGUAGE . '.php');
		$_REQUEST['language']   = '';
	}
	
	$user_lang = $_REQUEST['language'];
	if (!is_file(LANGUAGE_FILE)) 
		fatal_error(0, 0, "File '" .LANGUAGE_FILE. "' not found, functions.php setup_language()<br /> mysql error:<br />" . mysql_error()); 
	require LANGUAGE_FILE;
}

// Set language file to default
function set_default_language() {
	global $lang, $config, $user_lang;
	
	if ($_REQUEST['language']) {
		$_REQUEST['language']  = '';
		setup_language();
		$save_user_lang        = $user_lang;
		$user_lang             = $save_user_lang;
		require LANGUAGE_FILE;
	}
	return;
}

// Reset language file to user's choice
function reset_language($user_lang) {
	global $lang;
	
	if ($user_lang) {
		setup_language();
		$_REQUEST['language'] = $user_lang;
		require LANGUAGE_FILE;
	}
}

// Get allowed tags
function get_allowed_tags() {
	global $config, $tagbuttons, $allowedtags, $allowable_tags;
	
	require_once (dirname(__FILE__)) . '/allowable-tags-inc.php'; // Array of all allowable tags
	$tagbuttons   = array();
	$allowedtags  = array();
	
	$tags = explode(',', $config['allowed_tags']); // Tags the user wants to allow
	foreach($tags as $value) {
		$button  = 0;  // 0 no quick tag button, 1 we'll create a button
		if ($value) {
			$value = trim($value);
			if (!preg_match('/-/', $value)) {
				$button = 1;
			} else {
				$value = preg_replace('/-/', '', $value);
			}
			
			if (isset($allowable_tags[$value])) {
				$allowedtags[$value] = $value;
				$tagbuttons[$value]  = $button;
			}
		}
	}

	return;
}

// Update comments count
function update_comment_count($page, $type) {
	global $dblink, $lang, $config, $article_title;
	if ($type == 'add') {
		$result  = mysql_query("UPDATE " . DBPREFIX . "articles SET com_count=com_count+1 WHERE href='$page' ", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, functions.php, update_comment_count() 1<br /> mysql error:<br />' . mysql_error());
		if (!mysql_affected_rows($dblink)) {
			$page          = mysql_real_escape_string($page);
			$article_title = mysql_real_escape_string($article_title);
			$result = mysql_query("INSERT INTO " . DBPREFIX . "articles SET com_count='1', href='$page', title='$article_title' ", $dblink);
			if (!$result) fatal_error(0, 0, 'DB query error, functions.php, update_comment_count() 2<br /> mysql error:<br />' . mysql_error());
		}
	} else {
		$result  = mysql_query("UPDATE " . DBPREFIX . "articles SET com_count=com_count-1 WHERE href='$page' ", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, functions.php, update_comment_count() 3<br /> mysql error:<br />' . mysql_error());
		if (mysql_affected_rows($dblink)) {
			$result = mysql_query("SELECT com_count FROM " . DBPREFIX . "articles WHERE href='$page' LIMIT 1", $dblink);
			if (!$result) fatal_error(0, 0, 'DB query error, functions.php, update_comment_count() 4<br /> mysql error:<br />' . mysql_error());
			$row = mysql_fetch_row($result);
			if ($row[0] < 1) {
				$result = mysql_query("DELETE FROM " . DBPREFIX . "articles WHERE href='$page' LIMIT 1", $dblink);
				if (!$result) fatal_error(0, 0, 'DB query error, functions.php, update_comment_count() 5<br /> mysql error:<br />' . mysql_error());
			}
		}
	}
}

// Delete table row
function delete_row($table, $id, $page) {
	global $config, $dblink;
	
	$result = mysql_query("DELETE FROM " . DBPREFIX . "$table WHERE id='$id'", $dblink);
	if (!$result) fatal_error(0, 0, "DB query error, functions.php, delete_row(), table = $table, id = $id">'<br /> mysql error:<br />' . mysql_error());
	
	if ($table == 'data') {
		$page = mysql_real_escape_string($page);
		update_comment_count($page, 'delete');
	}
}
?>