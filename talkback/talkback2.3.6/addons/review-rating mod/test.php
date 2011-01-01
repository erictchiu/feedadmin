<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Review/rating mod - test.php
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
	<title>TalkBack Test Page</title> 	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
<?php include "head-inc.php"; ?>
	<style type="text/css">
		body {
			font-family: verdana, arial, helvetica, sans-serif;
			font-size: 80%;
			}
		#wrapper {
			width: 500px;
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

	<?php require 'comments.php'; ?>

</div>
</body>
</html>