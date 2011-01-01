<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Do spam check and add comment to the database
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. 

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/

// Kill the script if it is accessed directly
defined('VALIDATED') or exit('This page cannot be accessed directly');

$spam = spam_check();
if ($spam == 1) {
	// Akismet test failed
	if ($config['discard_spam']) {
		$display_message = $lang['spam_discarded'];
		$mc_link = "{$lang['browser_back']}";
		require MESSAGE_PANEL_TPL;
		exit();
	} // else the comment will go into the 'spam' table
} else {
	// the comment will go into the 'data' table so set the moderation flag
	$moderate = 0;
	if ($config['moderation']) {
		// Admin wants to moderate all comments
		$moderate = 1;
	} elseif ($spam > 1) {
		// Could not contact Akisment server so let the admin deside
		$moderate = $spam;  // Will be either 3 (invalid key) or 4 (no connect)
	} else {
		$num_links = substr_count($_REQUEST['form_textarea'], '<a');
		if ($_REQUEST['form_website']) $num_links++;
		if ($num_links > $config['max_links']) {
			// Exceeded max number of links in comment
			$moderate = 2;
		} elseif ($config['spamwords']) {
			// Check comment for spam words/phrases
			$moderate = filter_spamwords(); // $moderate = 5 if spam word found
		}
	}
}

// Add new comment to the db
$time             = time() + ($config['time_offset'] * 3600);
$form_replyto     = mysql_real_escape_string($_REQUEST['form_replyto']);
$form_author      = mysql_real_escape_string($_REQUEST['form_author']);
$form_email       = mysql_real_escape_string($_REQUEST['form_email']);
$form_website     = mysql_real_escape_string($_REQUEST['form_website']);
$ip               = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
$form_location    = mysql_real_escape_string($_REQUEST['form_location']);
$form_subject     = mysql_real_escape_string($_REQUEST['form_subject']);
$article_title    = mysql_real_escape_string($_REQUEST['article_title']);
$article_url      = mysql_real_escape_string($_REQUEST['article_url']);
$user_agent       = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
$email_reply      = 0;
$form_textarea    = mysql_real_escape_string($_REQUEST['form_textarea']);

// Insert the comment
if ($spam != 1) {
	$query = "INSERT INTO " . DBPREFIX . "data VALUES (NULL, '$form_replyto', '$time', '$article_url', '$form_textarea', '$form_author', '$form_email', '$form_website', '$ip', '$moderate', $email_reply, '$user_agent', '$form_location', '$form_subject')";
	$table    = 'data';
	if (!$moderate) update_comment_count($article_url, 'add');
} else {
	$query = "INSERT INTO " . DBPREFIX . "spam VALUES (NULL, '$form_replyto', '$time', '$article_url', '$form_textarea', '$form_author', '$form_email', '$form_website', '$ip', '$user_agent', '$tb_article_title')";
	$table = 'spam';
}

$result = mysql_query($query, $dblink);
if (!$result) fatal_error(0, 0, 'DB query error, comments-add 2<br /> mysql error:<br />' . mysql_error());
$comment_id = mysql_insert_id();

// If the comment is not a reply to another comment, update the record we just added
if (!$_REQUEST['form_replyto']) {
	// Set repy_to = table id meaning it is an original comment, not a reply
	$update = mysql_query("UPDATE " . DBPREFIX . "$table SET replyto='$comment_id' WHERE id='$comment_id' LIMIT 1", $dblink);
	if (!$update) fatal_error(0, 0, 'DB query error, comments-add 3<br /> mysql error:<br />' . mysql_error());
}

notify_admin();  // Send email notice to admin
notify_subscribers($comment_id);	// Notify subscribers of new comment
if ($_REQUEST['form_replyto']) notify_original_author($_REQUEST['form_replyto']);	// Notify original author of a reply

if (($_REQUEST['form_subscribe']) && !$spam && !$moderate) {
	confirm_subscription('');
	exit();
}

if ($moderate || $spam) {
	// Print holding for approval message
	$display_message  = $lang['moderation_on'] . '<br /><br />';
	$mc_link          = "<a href='".SITE_URL."{$_REQUEST['page']}'>{$lang['moderation_return_link']}</a>";

	if ($_REQUEST['form_subscribe']) {
		confirm_subscription($display_message);
		exit();
	}
	require MESSAGE_PANEL_TPL;
	exit();
}

if ($_REQUEST['reply']) $start_page = redisplay_same_page(); // force redisplay of the same page

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Functions
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	
// Initiate Akisment & reCaptcha spam checks
function spam_check() {
	global $dblink, $config, $lang, $raw;
	$status = 0;
	
	// Akismet check
	if ($config['akismet_key'] && !TESTING) {
		require_once 'includes/classAkismet.php';
		
		$data['type']       = 'comment';
		$data['author']     = $raw['form_author'];
		$data['email']      = $raw['form_email'];
		$data['website']    = $raw['form_website'];
		$data['website']    = $raw['form_website'];
		$data['body']       = $raw['form_textarea'];
		$data['permalink']  = SITE_URL . $_REQUEST['page'];
		$data['user_ip']    = ($config['test_ip']) ? $config['test_ip'] : $_SERVER['REMOTE_ADDR'];
		
		$akismet = new Akismet(SITE_URL, $config['akismet_key'], $data);
		if ($akismet->isError('AKISMET_INVALID_KEY')) {
			return 3;
		} elseif ($akismet->isError('AKISMET_RESPONSE_FAILED') || $akismet->isError('AKISMET_SERVER_NOT_FOUND')) {
			return 4;
		} elseif ($akismet->isSpam()) {
			// update spam count
			$result = mysql_query("UPDATE " . DBPREFIX . "config SET option_data = option_data +1  WHERE option_name = 'spam_count' LIMIT 1", $dblink);
			if (!$result) fatal_error(0, 0, 'DB query error, comments-add 5<br /> mysql error:<br />' . mysql_error());
			return 1;
		}
	}
	
	// Captcha check
	if ( ($config['captcha'] && !TESTING && !$config['is_demo_system']) || ($config['is_demo_system'] &&  $_REQUEST['show_captcha']) ) {
		require 'includes/classRecaptcha.php';
		$privatekey = $config['captcha_private'];
		$response = recaptcha_check_answer(
			$privatekey,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
			
		if (!$response->is_valid) {
			// set the error code so it will be displayed
			$error = $response->error;
			$error_lookup = 'recaptcha-result:' . $error;
			$display_message = "{$lang[$error_lookup]}";
			if (!$display_message) {
				$error_lookup = 'recaptcha-result:unknown';
				$display_message = "{$lang[$error_lookup]} $error";
			}
			
			$mc_link = "{$lang['browser_back']}";
			require MESSAGE_PANEL_TPL;
			exit();
		}
	}
	return $status;
}

// Send new comment email notice to admin
function notify_admin() {
	global $dblink, $config, $lang, $spam, $moderate, $raw, $user_lang;

	// admin notices are created using the default language
	set_default_language();
	
	// Do we send a spam comments notice - never if we discard spam, otherwise if more than 24 hours since last notice?
	if ($spam == 1 && !$config['discard_spam']) {
		$now = time();
		if ($config['last_spam_notice'] + 86400 <= $now) {
			// it's been more than 24 hours so we'll send a new spam notice
			$result = mysql_query("UPDATE " . DBPREFIX . "config SET option_data='$now' WHERE  option_name='last_spam_notice' LIMIT 1", $dblink);
			if (!$result) fatal_error(0, 0, 'DB query error, comments-add 6<br /> mysql error:<br />' . mysql_error());
			$to       = 'admin';
			$subject  = "{$lang['email_nc_subject2']} {$config['site_name']}";
			$headers  = "From: {$config['email_from']}\r\n";
			send_email($to, $subject, $body, '', '');
		}
		return;
	}
	
	// else skip email notice if 1) admin doesn't want them, or 2) we're testing, or 3) comment entered by admin, or 4) they are suppressed
	if ($config['admin_notices'] == 3 
		|| TESTING 
		|| (ADMIN_EMAIL == $_REQUEST['form_email'] && $config['admin_name'] == $_REQUEST['form_author'])
		|| ($config['admin_notices'] == 1 && $config['admin_notices_suppressed'])) {
		reset_language($user_lang);
		return;
	}
	
	// else we'll send a notice
	$subject      = "{$lang['email_nc_subject1']} {$config['site_name']}";
	$first_line   = ($moderate) ? " {$lang['email_nc_moderate']}" .LF.LF : '';
	$author       = "{$lang['email_nc_author']} {$raw['form_author']} <{$raw['form_email']}>" .LF;
	$website      = ($_REQUEST['form_website']) ? "{$lang['email_nc_website']} {$_REQUEST['form_website']}" .LF : '';
	$comment_subj = "Subject: {$raw['form_subject']}" .LF.LF;
	$comment      = $raw['form_textarea'] .LF.LF;
	$page_url     = "{$lang['email_nc_the_page']}: ".SITE_URL."{$_REQUEST['page']}" .LF;	
	$links        = "{$lang['email_nc_panel_title']}:" .URL_PATH. "admin" .LF 
                 . $page_url .LF;
	$body         = $first_line . $author . $website . $comment_subj . $comment . $links;
	$to           = 'admin';
	
	send_email($to, $subject, $body, '', '');
	
	// Suppress additional new comment notices until after the admin panel is visited
	if ($config['admin_notices'] == 1 && !$config['admin_notices_suppressed']) {
		$config['admin_notices_suppressed'] = 1;
		$result = mysql_query("UPDATE " . DBPREFIX . "config SET option_data='1' WHERE  option_name='admin_notices_suppressed' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, comments-add 8<br /> mysql error:<br />' . mysql_error());
	}
	
	reset_language($user_lang);
}

// Send email notice of new reply to orignal author
function notify_original_author($tbid) {
	global $config, $lang, $user_lang, $raw;
	
	// these are created using the default language
	set_default_language();
	
	// Get the comment data
	$comment = tbget_comment($tbid, 'data');
	
	// Decide which type, if any, email to send
	if ($comment['email_reply']) {
		// User has subscribed to replies for this comment only
		$body = LF
		. "{$lang['email_an_1stline']}" .LF.LF
		. "{$raw['form_textarea']}" .LF.LF
		. "{$lang['email_an_lastline']} ".SITE_URL."{$comment['href']}" .LF.LF
		. "{$lang['email_sn_unsubscribe']}" .URL_PATH. "subscriptions.php?action=noreplies&tbid=$tbid&page={$comment['href']}" 
				.LF;
	} elseif ($_REQUEST['adminreply'] == 'email' || $_REQUEST['adminreply'] == 'both') {
		if (TESTING) {
			reset_language($user_lang);
			return;
		}
		// Admin wants to send a copy of the comment reply via email
		$body = LF
		. "{$lang['email_admin_reply1']} ".SITE_URL."{$comment['href']}" .LF.LF
		. "{$raw['form_textarea']}" .LF;
	} else {
		reset_language($user_lang);
		return;
	}
	send_email($comment['email'], "{$lang['email_an_subject']} {$config['site_name']}", $body, '', '');
	reset_language($user_lang);
	
}

// Send email notice of new comment to subscribers
function notify_subscribers($tbid) {
	global $dblink, $config, $lang, $user_lang;
	
	// these are created using the default language
	set_default_language();
	
	$result = mysql_query("SELECT id, email, name FROM " . DBPREFIX . "subscribers WHERE href='{$_REQUEST['page']}'", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, comments-add 9<br /> mysql error:<br />' . mysql_error());
	while (list($tbid, $subscriber_email, $subscriber_name) = mysql_fetch_row($result)) {
		if ($subscriber_email != $_REQUEST['form_email']) {
			$body     = LF
						 . "{$lang['email_sn_1stline']} ".SITE_URL."{$_REQUEST['page']}" .LF.LF 
						 . "{$lang['email_sn_unsubscribe']}" .URL_PATH. "subscriptions.php?action=unsubscribe&tbid=$tbid&page={$_REQUEST['page']}" 
						 .LF;
			
			send_email($subscriber_email, "{$lang['email_nc_subject1']} {$config['site_name']}", $body, '', '');
		}
	}
	reset_language($user_lang);
}

function filter_spamwords() {
	global $config, $raw;

	$field = " {$raw['form_email']} {$raw['form_author']} {$raw['form_location']} {$raw['form_website']} {$raw['form_textarea']}";
	
	require 'my-spamwords.php';
	$times = count($spamword);
	for ($i=0;$i<$times;$i++) {
		if (stripos($field, $spamword[$i]))
			return 5;
	}
	return 0;
}
?>