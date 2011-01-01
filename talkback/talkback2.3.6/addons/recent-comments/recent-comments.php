<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	recent comments mod - Separate comments mod comment form
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
	<title>Recent comments test page</title> 	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
<?php require 'head-inc.php'; ?>
	<style type="text/css">
		body {
			font-family: verdana, arial, helvetica, sans-serif;
			font-size: 80%;
			}
		h4 {text-align: center;}
		
		/* two new styles */
		.tb-page-legend {
			font-weight: bold;
			color: #666;
			font-size: .95em;
			}
		.tb-page-url {
			}
		/* override styles in stylesheet */
		#wrapper {
			width: 500px;
			margin: auto;
			}
		.tb-comment {
			margin: 1em 0 1em 20px;
			width: 430px;
			}
	</style>
</head> 
<body> 

	<div id='wrapper'>
		<br /><br />
		<h4 class='tb-center'>15 most recent comments</h4>
		
		<?php require 'recent.php'; ?>
	</div>
	
</body>
</html>