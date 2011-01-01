<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin panel configuration settings help
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. 

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
ini_set('error_reporting', E_ALL ^ E_NOTICE);
define('IS_VALID_INCLUDE', TRUE);
require 'head-inc.php';

print "
<style type='text/css'>
	body {
		font-size: 80%;
		}
	#tb-wrapper {
		font-family: 'lucida sans unicode', 'lucida grande', verdana, helvetica, arial, sans-serif;
		width: 500px;
		margin: auto;
		border: 1px solid #FEAB2B;
		background: #fff;
		}
	.title {
		font-weight: bold;
		font-size: .9em;
		text-align: center;
		}
	.small {
		font-size: .85em;
		}
	td {
		font-size: .9em;
		padding: 2px 5px 2px 5px;
		vertical-align: top;
		}
	code {font-size: 1.2em; background: #ddd;}
</style>
</head> 
<body>";

print "
	<div id='tb-wrapper'>
		<div id='tb-panel-header'>
			<strong>{$config['site_name']}</strong><br />
			{$lang['comments_help_title']}<br />
		</div>
		<div id='tb-panel-message'>{$lang[$_REQUEST['name']]}</div>
		<div id='tb-panel-footer'>Powered by <a href='http://www.scripts.oldguy.us'>TalkBack</a></div>
	</div>
</body>
</html>";
?>