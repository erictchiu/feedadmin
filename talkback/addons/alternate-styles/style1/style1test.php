<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	
	<title>Alternate style 1 test page</title> 
	
	<?php require 'head-inc.php' ?>
	
	<style type='text/css'>
	body {font-size: 80%}
	h3 {
		font-size: 1.2em;
		color: #08c;
		margin: 0 0 1em 0;
		padding: 0;
		line-height: 1em;
		text-align: center;
		font-family: "lucida sans unicode", "lucida grande", "trebuchet ms", trebuchet, arial, helvetica, sans-serif;
		}
		</style>
</head> 

<body onunload="unsetWaitGif();"> 

	<p style='text-align: center'><b>Alternate Style 1 Test Page.</b></p>
				
	<?php 
		$captcha_theme = 'custom'; // choices are: custom, white, red, clean, blackglass
		require 'comments.php' 
	?>
	
</body>
</html>