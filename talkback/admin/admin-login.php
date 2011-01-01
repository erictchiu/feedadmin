<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Administrator Login template
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
require 'admin-head-tpl.php';

print "
<title>{$lang['login_title']}</title>
<style type='text/css'>
#wrapper {
	width: 300px;
	border: 1px solid #FEAB2B;
	margin-top: 100px;
	}
.nav {
	color: #000;
	font-weight: bold;
	font-size: 1em;
	}
</style>
</head>
<body>
<div id='wrapper'>
	<div class='nav'>{$config['site_name']}<br />{$lang['login_title']}</div>
	<p class='small center'>{$lang['login-message']}</p>
	<form action='{$_SERVER['PHP_SELF']}' method='get'>
		<input type='hidden' name='query_string' value='{$_REQUEST['query_string']}' />
		<table cellpadding='5'>
			<tr>
				<td align='right' valign='top'>{$lang['userid']}</td>
				<td><input type='text' name='login' value='' /></td>
			</tr>
			<tr>
				<td align='right' valign='top'>{$lang['password']}</td>
				<td><input type='password' name='password' value='' /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' name='submit' value='{$lang['login']}' /></td>
			</tr>
		</table>
	</form>
	<div class='nav'>&nbsp;</div>
</div>
</body>
</html>";
?>