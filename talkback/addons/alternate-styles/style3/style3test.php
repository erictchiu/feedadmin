<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="shortcut icon" type="image/ico" href="/favicon.ico" />
	<meta name="description" content="Scripts for websites including a PHP comments script that features: moderation options, spam checking, user subscriptions, 'quick tags', email notices, admin panels and cutomizable styles, " /> 
	<meta name="keywords" content="scripts, PHP, javascript, comments script, guestbook script" /> 
	<title>TalkBack Comments and Guestbook Demo Page</title> 	
	<?php 
		$tb_comments_display_tpl = '/talkback/my-comments-display-tpl.php';
		require 'head-inc.php'; 
	?>
	<style type='text/css'>
		body {font-size: 80%}
	</style>
</head> 

<body onunload="unsetWaitGif();"> 
<div id="inner">
	<div id="content">
		
		<?php require 'comments.php'; ?>
	</div> <!--content -->
</div>
</body>
</html>