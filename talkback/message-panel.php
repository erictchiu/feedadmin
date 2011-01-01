<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	This is the message page that is displayed when a fatal error occurs or an action (eg user 
	subscribe/unsubscribe) that originated outside comments.php or admin.php is completed.
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
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
<?php
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');
require 'head-inc.php';

print "
	<title>{$lang['msg_center_title']}</title>
	<style type='text/css'>
		body {
			font-size: 80%;
			background: #6F6F6F
			}
		#tb-wrapper {
			font-family: 'lucida sans unicode', 'lucida grande', verdana, helvetica, arial, sans-serif;
			width: 500px;
			margin: auto;
			background: #fff;
			}
		#tb-panel-header {font-size: .85em;}
	</style>
</head> 

<body> 
<div id='tb-wrapper'>
	<div id='tb-panel-header'>
		<strong>{$config['site_name']}<br />
		{$lang['msg_center_title']}</strong><br />
	</div>
	<div id='tb-panel-content'>
		<div id='tb-panel-message'>
			<p>$display_message</p>
			<p>$dberror</p>
			<p>$footnote</p>
		</div>
		<div class='tb-panel-link'>$mc_link</div>
	</div>
	
	<div id='tb-panel-footer'>Powered by <a href='http://www.scripts.oldguy.us'>TalkBack</a></div>

</div>
</body>
</html>";
exit();
?>