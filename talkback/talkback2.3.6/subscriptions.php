<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	This script handles user subscribing/unsubscribing & admin deletions
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
defined('IS_VALID_INCLUDE') or define('IS_VALID_INCLUDE', TRUE);

require 'config.php';
setup_language();
require LANGUAGE_FILE;

$config = get_config();
stripAllSlashes();

if ($_REQUEST['action'] == 'subscribe1'){ 
	// Subscribe to all comments (via link in confirmation email)
	subscribe1();
} elseif ($_REQUEST['action'] == 'subscribe2'){  
	// Subscribe to replies only (via link in confirmation email)
	subscribe2();
} elseif ($_REQUEST['action'] == 'unsubscribe'){
	// Uubscribe from all comments via link in confirmation email
	unsubscribe();
} elseif ($_REQUEST['action'] == 'delete'){  
	// Admin deletion via admin panel subcribers list
	delete();
} elseif ($_REQUEST['action'] == 'noreplies'){  
	// Unsubscribe from replies to a comment
	unsubscribe2();
} else {
	print "<b>subscriptions.php:</b> Invalid subscription action.";
}
	
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Subscription functions
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// invoked when user clicks on unsubscribe link in an email new comment notice
function unsubscribe() {
	global $dblink, $config, $lang;
	
	$tbid = mysql_real_escape_string($_REQUEST['tbid']);

	$result = mysql_query("delete from " . DBPREFIX . "subscribers WHERE ID='$tbid' ", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, subscriptions 1<br /> mysql error:<br />');
	
	$display_message = (mysql_affected_rows() > 0) 
		? "{$lang['unsubscribe_true']} ".SITE_URL."{$_REQUEST['href']}"
		: "{$lang['unsubscribe_false']}";
		
	$mc_link = "<a href='".SITE_URL."{$_REQUEST['href']}'>{$config['site_name']}</a>";
	require MESSAGE_PANEL_TPL;
}

// invoked when user clicks on unsubscribe link in an email notice of a reply to his comment
function unsubscribe2() {
	global $dblink, $config, $lang;
	
	$tbid = mysql_real_escape_string($_REQUEST['tbid']);
	$result = mysql_query("UPDATE " . DBPREFIX . "data SET email_reply='0' WHERE id='$tbid' ", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, subscriptions 2<br /> mysql error:<br />' . mysql_error());
	
	$display_message = (mysql_affected_rows() > 0)
		? "{$lang['unsubscribe_true']} ".SITE_URL."{$_REQUEST['page']}"
		: "{$lang['unsubscribe_false']}";

	$mc_link = "<a href='".SITE_URL."{$_REQUEST['page']}'>{$config['site_name']}</a>";
	require MESSAGE_PANEL_TPL;
}

// Subscribe to all followup comments on the page
function subscribe1() {
	global $dblink, $config, $lang;
	
	$page   = mysql_real_escape_string($_REQUEST['page']);
	$email  = mysql_real_escape_string($_REQUEST['email']);
	$name   = mysql_real_escape_string($_REQUEST['name']);
	
	if ($page != '' && $email != '') {		
		$result = mysql_query("SELECT COUNT(*) from " . DBPREFIX . "subscribers WHERE href='$page' AND email='$email' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, subscriptions 3<br /> mysql error:<br />' . mysql_error());
		
		list ($count) = mysql_fetch_row($result);
		if ($count == 0) {
			$hash    = md5($email . $config['random_seed']);
			$time    = time();
			
			$result = mysql_query("INSERT INTO " . DBPREFIX . "subscribers VALUES (NULL, '$email', '$page', '$hash', '$time', '$name')", $dblink);
			if (!$result) fatal_error(0, 0, 'DB query error, subscriptions 4<br /> mysql error:<br />' . mysql_error());
			
			$display_message = "{$lang['subscribed']}";
		} else {
			$display_message = "{$lang['subscribed']}";
		}
	} else {
		$display_message = $lang['invalid_confirmation'];
	}
	
	$mc_link = "<a href='".SITE_URL.$page."'>{$config['site_name']}</a>";
	require MESSAGE_PANEL_TPL;
}

// Subscribe to replies to the subscriber's original comment
function subscribe2() {
	global $dblink, $config, $lang;
	
	if (!$_REQUEST['tbid']) {
		$display_message = $lang['invalid_confirmation'];
	} else {
		$tbid      = mysql_real_escape_string($_REQUEST['tbid']);
		
		$result  = mysql_query("UPDATE " . DBPREFIX . "data SET email_reply='1' WHERE id='$tbid' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, subscriptions 5<br /> mysql error:<br />' . mysql_error());
		
		$display_message = "{$lang['subscribed']}";
	}
	$mc_link = "<a href='".SITE_URL."{$_REQUEST['page']}'>{$config['site_name']}</a>";
	require MESSAGE_PANEL_TPL;
}

// invoked when admin clicks on delete link in admin subscribers list
function delete() {
	global $dblink, $config, $lang;
	
	$tbid = mysql_real_escape_string($_REQUEST['id']);
	$result = mysql_query("delete from " . DBPREFIX . "subscribers WHERE id='$tbid'", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, subscriptions 6<br /> mysql error:<br />' . mysql_error());
	
	return_to_page();
}
?>
