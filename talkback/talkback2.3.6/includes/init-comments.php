<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Comments processing initialization
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

// http_ok is list of fields that may contain "HTTP://"
$http_ok['form_website'] = 1;
$http_ok['form_textarea'] = 1;
check_for_evil ($_GET, $http_ok);
check_for_evil ($_POST, $http_ok);

// These variables set prior to the include allows user to have any number of different
// comment and form templates on the website
// var name originally was $tb_template
if ($tb_comments_display_tpl) {
	$tb_template = $tb_comments_display_tpl;
}
if ($tb_template) {
	define('COMMENTS_DISPLAY_TPL',ABS_PATH . $tb_template);
}else {
	define('COMMENTS_DISPLAY_TPL',ABS_PATH . $config['comments_display_tpl']);
}
if (!is_file(COMMENTS_DISPLAY_TPL)) 
	exit("<br />Comments display template not found, init-comments.php, path to file: <br>" . COMMENTS_DISPLAY_TPL . "<br />");


if ($tb_comments_form_template) {
	define('COMMENTS_FORM_TPL',ABS_PATH . $tb_comments_form_template);
}else {
	define('COMMENTS_FORM_TPL',ABS_PATH . $config['comments_form_tpl']);
}
if (!is_file(COMMENTS_FORM_TPL)) 
	exit("<br />init-comments.php, comments form template not found, path to file: <br>" . COMMENTS_FORM_TPL . "<br />");


if ($tb_preview_panel_template) {
	define('PREVIEW_PANEL_TPL',ABS_PATH . $tb_message_panel_template);
}else {
	define('PREVIEW_PANEL_TPL',ABS_PATH . $config['preview_panel_tpl']);
}
if (!is_file(PREVIEW_PANEL_TPL)) 
	exit("<br />init-comments.php, preview panel template not found, path to file: <br>" . PREVIEW_PANEL_TPL . "<br />");


if ($tb_reply_panel_template) {
	define('REPLY_PANEL_TPL',ABS_PATH . $tb_reply_panel_template);
}else {
	define('REPLY_PANEL_TPL',ABS_PATH . $config['reply_panel_tpl']);
}
if (!is_file(REPLY_PANEL_TPL)) 
	exit("<br />init-comments.php, reply panel template not found, path to file: <br>" . REPLY_PANEL_TPL . "<br />");


define ('HELP_PANEL_TPL',        ABS_PATH . $config['help_panel_tpl']);
if (!is_file(HELP_PANEL_TPL)) 
	exit("<br />init-comments.php, help panel template not found, path to file: <br>" . HELP_PANEL_TPL . "<br />");
	
define ('COMMENTS_DRIVER',       TB_PATH  . $config['comments_driver']);
if (!is_file(DOC_ROOT . COMMENTS_DRIVER)) 
	exit("<br />init-comments.php, comments driver script not found, path to file: <br>" . COMMENTS_DRIVER . "<br />");
	
// +++++++++++++++ Vars that may be set in calling script/page +++++++++++++++ 
if ($tb_language) {
	if (!is_file(ABS_PATH . 'language/' . $tb_language . '.php'))
		fatal_error(0, 0, 'init-comments.php, missing language file or invalid path/file name: ' . ABS_PATH . 'language/' . $tb_language . '.php');
}

if ($tb_captcha_theme) {
	if (!preg_match('#(red|white|clean|blackglass|custom)#', $tb_captcha_theme)) 
		fatal_error(0, 0, "init-comments.php, invalid data in &#36;tb_captcha_theme: '$tb_captcha_theme'");
}

$path_length = strlen(TB_PATH);

/*// path from webroot to comments page, must start with tb_path
if ($tb_article_url) {
	if (!is_file(DOC_ROOT . $tb_article_url))
		fatal_error(0, 0, "init-comments.php, invalid path in &#36;tb_article_url: '$tb_article_url'");
}

// path from webroot to comments page
if ($tb_permalink) {
	if (substr($tb_permalink, 0, $path_length) != TB_PATH)
		fatal_error(0, 0, "init-comments.php, invalid  path in &#36;tb_permalink: $tb_permalink'");
}*/

// +++++++++++++++ interally set, not user entered +++++++++++++++ 
// fatal_error() not used because it's likely these are malformed requests by hacker
if ($_REQUEST['numrows']      && !is_numeric($_REQUEST['numrows'])) {
	write_error_log("init-comments.php, numrows contents '{$_REQUEST['numrows']}' is invalid");
     exit("Unable to process the request ic1");
}

if ($_REQUEST['edit_id']      && !is_numeric($_REQUEST['edit_id'])) {
	write_error_log("init-comments.php, edit_id contents '{$_REQUEST['edit_id']}' is invalid");
	exit("Unable to process the request ic3");
}
if ($_REQUEST['rowcount']     && !is_numeric($_REQUEST['rowcount'])) {
	write_error_log("init-comments.php, rowcount contents '{$_REQUEST['rowcount']}' is invalid");
	exit("Unable to process the request ic4");
}
if ($_REQUEST['tbid']           && !is_numeric($_REQUEST['tbid'])) {
	write_error_log("init-comments.php, tbid contents '{$_REQUEST['tbid']}' is invalid");
	exit("Unable to process the request ic5");
}
if ($_REQUEST['form_id']      && !is_numeric($_REQUEST['form_id'])) {
	write_error_log("init-comments.php, form_id contents '{$_REQUEST['form_id']}' is invalid");
	exit("Unable to process the request ic6");
}
?>