<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The list of subscribers panel template
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
<title>{$lang['panel_subscribers_title']}</title>
<style type="text/css">
	td {
		padding: 2px 5px 2px 5px;
		}
	.nav .report-page {
		margin: .5em 0 .5em 0;
	}
</style>
</head>
<body>
<div id="wrapper">
EOF;
if ($order == 'email') {
	$by = 'Email Address';
	$menu2 = 'email';
} else {
	$by = 'Page';
	$menu2 = 'page';
}
$report_title = "{$lang['panel_subscribers_title']} {$by} ({$subscriber_count})";
$report_page='';
$menu = 'subscribers';
require 'admin-nav-tpl.php';

if ($subscriber_count) {
	print '
	<table cellspacing="0" cellpadding="0"> 
	<tr>
		<th>ID</th>
		<th>Date</th>
		<th>Name</th>
		<th>Email</th>
		<th>Page</th>
		<th class="action">Action</th>
	</tr>';

	for($i=0; $i<$subscriber_count; $i++) {
		$date = ucwords(strftime($config['admin_date'], $time[$i]));
		print "
	<tr class='comment-header'>
		<td>{$id[$i]}</td>
		<td>$date</td>
		<td>{$name[$i]}</td>
		<td><a href='mailto:$email[$i]?subject={$lang['your_comment']} {$config['site_name']}' title='Send email'>$email[$i]</a></td>
		<td>
			<a href='{$href[$i]}'>{$href[$i]}</a>
		</td>
		<td class='action'>
			<a href='" .TB_PATH. "subscriptions.php?action=unsubscribe&amp;tbid={$id[$i]}&amp;return=subscriberlist&amp;order=$order&amp;href={$href[$i]}'>[Delete]</a>
		</td>
	</tr>
	<tr>
		<td colspan='6'>&nbsp;</td>
	</tr>";
	}
	print<<<EOF
	</table>
EOF;
} else {
print<<<EOF
		<p class="text">{$lang['no_subscribers']}</p>
EOF;
}
require 'admin-footer-tpl.php';
EOF;
?>