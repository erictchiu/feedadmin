<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />

	<title>Alternate style 2 test page</title> 	
	<?php include "head-inc.php"; ?>
	<style type='text/css'>
		body {font-size: 80%}
	</style>
</head> 

<body onunload="unsetWaitGif();"> 
<div style='width: 480px; margin: auto;'>

	<p style='text-align: center'><b>Alternate Style 2 Demo Page.</b></p>

	<?php 
		$captcha_theme = 'custom'; // choices are: custom, white, red, clean, blackglass
		require 'comments.php' 
	?>
		
</div>
</body>
</html>