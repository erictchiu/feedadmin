<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Heading template for the admin help panels
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. This script may contain copyrighted code from another source that was
	released under the GPL. See credits-copyrights.txt for more information.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

print<<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>{$lang['admin_help_title']} - $title</title>
<style type="text/css">
	body {
		margin: 20px 0 0 0;
		padding: 0;	
		font-family: verdana, helvetica, arial, sans-serif;
		font-size: 80%;
		background: #6F6F6F;
		}
	#wrapper {
		width: 500px;
		margin: auto;
		border: 2px solid #FEAB2B;
		background: #fff;
		}
	#header, #footer {
		background: #FEAB2B;
		text-align: center;
		padding: 5px 10px 5px 10px;
		}
	#footer {
		margin-top: 10px;
		font-size: .75em;
		color: #fff;
		}
	#index-link {
		text-align: center;
		font-size: .85em;
		margin-top: 5px;
		}
	#display-message {
		margin: 10px 0 10px 0;
		padding: 0 10px 0 10px;
		line-height: 1.1em;
		color: #4F4F4F;
		}
	.tb-stress {
		color: #800;
		text-align: center;
		}
	a, a:visited {
		color: #00f;
		text-decoration: none;
		}
	ul {
		margin-left: 26px;
		padding: 0;
		list-style-image: url(../images/bullet-square-o.gif);
		}
	ul .second-level {
		margin-left: 13px;
		list-style-image: url(../images/bullet-arrow-o.gif);
		}
	ul.config_help {
		font-size: .85em;
		list-style-type: none;
		list-style-image: none;
		margin-left: 0;
		}
	li {
		padding-top: 3px;
		padding-bottom: 3px;
		}
	li p {
		margin-top: 5px;
		margin-bottom: 0;
		}
	h2.topic {
		font-size: 1em;
		text-align: center;
		background: #FFCD7F;
		padding: 2px 0 2px 0;
		}
	.red {color: red;}
	.blue {color: blue;}
	.link {color: blue;}
	ul {margin-top: 0;}
	.center {text-align: center;}
	.small {font-size: .85em;}
	.blue {color: blue;}
	.stress {color: #800;}
	.extra-height {
		line-height: 1.5em;
		}
	code {
	font-family: "courier new", courier, monospace;
	font-size: .85em;
	background: #eee;
	}
</style>
</head> 

<body> 
<div id="wrapper">
END;
?>
