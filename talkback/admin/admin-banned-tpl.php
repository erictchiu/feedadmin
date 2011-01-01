<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Banned IP addresses panel template
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

print<<<EOF
<title>{$lang['panel_banned_title']}</title>
<style type="text/css">
	.nav .report-page {
		margin: .5em 0 .5em 0;
	}
</style>
</head>
<body>
<div id="wrapper">
EOF;
$report_title = "{$lang['panel_banned_title']}";
$report_page = '';
$menu = 'banned';
require 'admin-nav-tpl.php';

if ($ip_count) {
	$date = ucwords(strftime($config['admin_date'], $time[$i]));
	for($i=0; $i<$ip_count; $i++) {
		print "
	<p class='text'>{$ip[$i]} &nbsp;&nbsp;&nbsp;<a href=" .TB_PATH. "admin?action=unbanip&amp;ip={$ip[$i]}&amp;return=bannedlist>[{$lang['unbanip_link']}]</a></p>";
	}
} else {
print "
	<p class='text'>{$lang['no_bannedip']}</p>";
}
require 'admin-footer-tpl.php';
?>