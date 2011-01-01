<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Separate comments mod comment form
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<!-- insert your head section entries -->
	
<?php include "head-inc.php"; ?>
</head> 
<body> 

	<!-- insert your page heading/content wrapper/sidebar html -->
	
	<div id='tb-wrapper'>
	
<?php 
define('IS_VALID_INCLUDE', TRUE);

$cookie = get_author_cookie();
$comment_form_hidden_fields   = "<input type='hidden' name='action' value='add' /> 
		<input type='hidden' name='form_replyto' value='' />
		<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
		<input type='hidden' name='article_url' value='{$_REQUEST['page']}' /> 
		<input type='hidden' name='reply' value='' /> 
		<input type='hidden' name='edit' value='' /> 
		<input type='hidden' name='sortorder' value='DESC' />
		<input type='hidden' name='rowstart' value='0' />
		<input type='hidden' name='rowend' value='{$cookie['num_rows']}' />
		<input type='hidden' name='numrows' value='{$cookie['num_rows']}'  /> 
		<input type='hidden' name='language' value='' />
		<input type='hidden' name='article_title' value='' />";	
if ($cookie['rememberme']) {
	$_REQUEST['form_author']      = stripslashes($cookie['author_name']);
	$_REQUEST['form_email']       = stripslashes($cookie['author_email']);
	$_REQUEST['form_website']     = stripslashes($cookie['author_website']);
	$_REQUEST['form_location']    = stripslashes($cookie['author_location']);
}
$_REQUEST['form_subscribe']   = '';
$_REQUEST['form_replyto']     = '';
$_REQUEST['form_subject']     = '';
$_REQUEST['form_textarea']    = '';
$comment_size                 = '';
$subscribed1_check            = '';
$subscribed2_check            = '';
$rememberme_check             = ($cookie['rememberme']) ? "checked='checked'" : '';
require 'comments-form-tpl.php'; 
?>
	</div>

	<!-- insert your page footing html -->

</body>
</html>