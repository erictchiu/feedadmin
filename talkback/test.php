<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>TalkBack Test Page</title> 	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	
<?php 
	/*
	// there are some optional parameters you can use
	// insert them only if, for this page, you want to override the defaults
	
	$tb_closed = '';            // 'Y' means no more comments can be entered for this page
	$tb_language = '';          // overrides default language, e.g. 'french'
	
	// these override the templates specified in the config settings
	$tb_comments_display_tpl    = '';  // e.g. 'my-comments-display-tpl.php'
	$tb_comments_form_tpl       = '';
	$tb_comments_preview_tpl    = '';
	$tb_comments_reply_tpl      = '';
	
	// this is used if captcha is enabled, otherwise it is ignored
	// if not entered, theme defaults to 'custom'
	$tb_captcha_theme = 'white';  // choices are: custom, white, red, clean, blackglass 
	
	include 'head-inc.php'; 
	*/
?>

<?php include 'talkback/head-inc.php'; ?>

	<style type="text/css">
		body {
			font-family: verdana, arial, helvetica, sans-serif;
			font-size: 80%;
			}
		#wrapper {
			width: 450px;
			margin: auto;
			border: 1px solid #ccc;
			padding: 0 20px 10px 20px;
			}
		a, a:visited {
			color: #00F;
			text-decoration: none;
			}
	</style>
</head> 
<body> 
<div id="wrapper"> 
	
	<h4 class='tb-center'>TalkBack Test Page</h4>
	
	<p class='tb-center' style='line-height: 125%;'><a href="admin">Admin Panels</a><br />
		<a href="doc" target="blank">User Guide</a>
	</p>

	<hr width='50%' />

	<?php
		include 'talkback/comments.php'; 
	?>

</div>
</body>
</html>