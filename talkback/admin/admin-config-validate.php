<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Configuration settings validation - used by admin-config.php and install.php
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
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');
$display_message = '';

// check required fields
$test['site_name'] = 1;
$test['site_url'] = 1;
$test['admin_login'] = 1;
$test['admin_password'] = 1;
$test['email_from'] = 1;
$test['admin_date'] = 1;
$test['comments_date'] = 1;
$test['num_of_days'] = 1;
$test['page_limit'] = 1;
$test['admin_date'] = 1;
$test['comments_date'] = 1;
$test['comments_driver'] = 1;
$test['comments_display_tpl'] = 1;
$test['comments_form_tpl'] = 1;
$test['preview_panel_tpl'] = 1;
$test['reply_panel_tpl'] = 1;
$test['help_panel_tpl'] = 1;
$test['user_agent_days'] = 1;
$test['gravatar_size'] = 1;
foreach ($test as $key => $value) {
	if (!$_POST[$key]) 
		$display_message .= "{$lang['required_field_1']}'{$key}'{$lang['required_field_2']}<br />\n";
}

unset($test);
// check numeric fields
$test['time_offset'] = 1;
$test['num_of_days'] = 1;
$test['page_limit'] = 1;
$test['comment_size'] = 1;
$test['user_agent_days'] = 1;
$test['wait_time'] = 1;
$test['max_links'] = 1;
foreach ($test as $key => $value) {
	if ($_POST[$key] && !is_numeric($_POST[$key]))
		$display_message .= "{$lang['required_field_1']} '$key' {$lang['invalid_field']}<br />\n";
}

unset($test);
// check radio button and checkbox fields
$test['admin_cookie'] = 1;
$test['admin_notices'] = 1;
$test['comments_link_target'] = 1;
$test['comment_search'] = 1;
$test['bad_words'] = 1;
$test['allow_replies'] = 1;
$test['comments_emoticons'] = 1;
$test['lightbox'] = 1;
$test['author_website_link'] = 1;
$test['comment_subject'] = 1;
$test['comments_subscribe'] = 1;
$test['comments_legend'] = 1;
$test['use_pages'] = 1;
$test['maintenance'] = 1;
$test['moderation'] = 1;
$test['captcha'] = 1;
$test['spamwords'] = 1;
$test['discard_spam'] = 1;
$test['regen_seed'] = 1;
$test['log_errors'] = 1;
$test['gravatar'] = 1;
foreach ($test as $key => $value) {
	if ($_POST[$key] && !is_numeric($_POST[$key]))
		$display_message .= "{$lang['required_field_1']} '$key' {$lang['invalid_field']}<br />\n";
}

if (!preg_match('#(G|PG|R|X)#', $_POST['gravatar_rating'])) 
	$display_message .= "'gravatar_rating' {$lang['invalid_field']}<br />\n";
	
if (preg_match('#(\s|,|;|\'|")#', $_POST['admin_login'])) 
	$display_message .= "{$lang['required_field_1']} 'admin_login' {$lang['invalid_field']}<br />\n";

if (preg_match('#(\s|,|;|\'|")#', $_POST['admin_password']))
	$display_message .= "{$lang['required_field_1']} 'admin_login' {$lang['invalid_field']}<br />\n";

if ($_POST['site_url'] && (substr($_POST['site_url'], 0,7) != 'http://'))
	$display_message .= "{$lang['required_field_1']} 'site_url' {$lang['invalid_field']}<br />\n";

if ($_POST['test_ip'] && !preg_match("#\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b#", $_POST['test_ip']))
	$display_message .= "Invalid data, test IP address: '{$_POST['test_ip']}'";

if ($_POST['files_directory'] ) {
	if (!is_dir($_POST['files_directory']) || !is_writable($_POST['files_directory']))
		$display_message .= "{$lang['files_directory_err1']}<br />\n";
} elseif ($_POST['log_errors']) {
	if (!is_dir($_POST['files_directory']) || !is_writable($_POST['files_directory']))
		$display_message .= "{$lang['logfile_err2']}<br />\n";
}
		
if ($_POST['log_errors']) {
	if (!$_POST['errorlog_filename'])
		$display_message .= "{$lang['logfile_err1']}<br />\n";
}

if ($_POST['mysqldump_path'] && !@file_exists($_POST['mysqldump_path']))
	$display_message .= "{$lang['mysqldump_directory_err']}<br />\n";

if ($_POST['captcha']) {
	if (!$_POST['captcha_public'])  $display_message .= "{$lang['captcha_public_err']}<br />\n";
	if (!$_POST['captcha_private']) $display_message .= "{$lang['captcha_private_err']}<br />\n";
}

$_POST['allowed_tags'] = strtolower($_POST['allowed_tags']);
if ($_POST['allowed_tags'] && !preg_match("#[-a-z,-<>]#", $_POST['allowed_tags'])) // allow letters , < > -
	$display_message .= "Invalid data, allowed tags: {$_POST['allowed_tags']}";
	
if (!is_file(ABS_PATH. $_POST['comments_display_tpl'])) 
	$display_message .= "Comments display template not found, path to file:<br />\n"
		. ABS_PATH. $_POST['comments_display_tpl']."<br />\n";

if (!is_file(ABS_PATH.  $_POST['comments_form_tpl'])) 
	$display_message .= "Comments display template not found, path to file:<br />\n"
		. ABS_PATH. $_POST['comments_form_tpl']."<br />\n";

if (!is_file(ABS_PATH.  $_POST['preview_panel_tpl'])) 
	$display_message .= "Comments display template not found, path to file:<br />\n"
		. ABS_PATH. $_POST['preview_panel_tpl']."<br />\n";

if (!is_file(ABS_PATH.  $_POST['reply_panel_tpl'])) 
	$display_message .= "Comments display template not found, path to file:<br />\n"
		. ABS_PATH. $_POST['reply_panel_tpl']."<br />\n";

if (!is_file(ABS_PATH.  $_POST['help_panel_tpl'])) 
	$display_message .= "Comments display template not found, path to file:<br />\n"
		. ABS_PATH. $_POST['help_panel_tpl']."<br />\n";

if (!is_file(ABS_PATH.   $_POST['comments_driver'])) 
	$display_message .= "Comments display template not found, path to file:<br />\n"
		. ABS_PATH. $_POST['comments_driver']."<br />\n";
		
if ($_POST['spamwords'] && !is_file(ABS_PATH."my-spamwords.php")) 
	$display_message .= "You have enabled spamwords checking but my-spamwords.php does not exist in the TalkBack directory (copy spamwords.php to my-spamwords.php)<br />\n";
	
if ($_POST['bad_words'] && !is_file(ABS_PATH."my-badwords.php")) 
	$display_message .= "You have enabled badwords checking but my-badwords.php does not exist in the TalkBack directory (copy badwords.php to my-badwords.php)<br />\n";
	
/*
Have not created edits for:
site_name
admin_name
email_from
cookie_name
captcha_public
captcha_private
akismet_key
admin_date
comments_date
date_locale
*/

if ($display_message) {
	if (!isset($installing)) {
		// We were called by the admin Edit Configuration panel
		require 'admin-config-head-tpl.php';
		print "$display_message<br /><br />{$lang['error_footer']}\n";
		require 'admin-footer-tpl.php';
	} else {
		// We were called by the installer script
		print "$display_message<br /><br />{$lang['error_footer']}<br /><br />\n";
		require 'admin-footer-tpl.php';
	}
	exit();
}

// Need to set checkbox values otherwise database will not be updated if they are ''
if (!$_POST['discard_spam'])	$_POST['discard_spam'] = 0;
if (!$_POST['captcha'])			$_POST['captcha'] = 0;
if (!$_POST['spamwords'])		$_POST['spamwords'] = 0;
if (!$_POST['log_errors'])		$_POST['log_errors'] = 0;
?>