<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<?php
print "
	<title>$title</title>
	<script type='text/javascript' src='../includes/jquery-c.js'></script>
	<script type='text/javascript' src='../includes/thickbox.js'></script>
	<link rel='stylesheet' type='text/css' href='../styleThickbox.css' />
	<script type='text/javascript' src='../includes/talkback.js'></script>
	<link rel='stylesheet' type='text/css' href='../admin/admin.css' />
	<style type='text/css'>
		#TB_closeAjaxWindow a:hover {background: none;}
		#TB_closeWindow a:hover {background: none;}
		#TB_prev a:hover {background: none;}
		#TB_next a:hover {background: none;}
		body {
			margin: 10px;
			padding: 0;	
			font-family: 'lucida sans unicode', 'lucida grande', verdana, helvetica, arial, sans-serif;
			background: #6F6F6F;
			}
		#wrapper {
			font-family: 'lucida sans unicode', 'lucida grande', verdana, helvetica, arial, sans-serif;
			border: 4px solid #FEAB2B;
			background: #fff;
			}
		#header {
			background: #FEAB2B;
			text-align: center;
			padding: 10px;
			font-size: 1.2em;
			}
		#contents {
			width: 575px;
			margin: 20px auto 0 auto;
			}
		.required {
			color: red;
			font-size: 1.2em;
			float: left;
			}
		.section {
			margin-top: 20px;
			font-weight: bold;
			color: #000; 
			background: #FFC76F; 
			padding: 3px;
			text-align: center;
			}	
		td {
			padding: 5px 0 5px 3px;
			}
		td.option {
			width: 160px;
			}
		.option input, .option div {
			font-family: 'courier new', courier, monospace;
			width: 155px;
			border: 1px solid #bbb;
			background: #F7EBD8;
			padding-left: 2px;
			font-size: 1em;
			}
		.option div {
			background: none;
			height: 20px;
			}
		.center {
			text-align: center;
			}
		.code {
			font-size: .85em;
			background: #ddd;
			margin-left: 20px;
			overflow: auto;
			}
		.radio {
			 background: #eee;
			 border: 1px solid #ddd;
			 padding: 2px;
			 }
		strong {font-size: .9em;
			}
	</style>
</head> 

<body> 
<div id='wrapper'>
	<div id='header'>
		<strong>$title</strong><br />
	</div>
	<div id='contents'>";
?>