<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Comments by page panel template
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
$report_title = $lang['panel_page_title'] . " ($ccount)";

$report_page = "<a href='$request_uri'>$request_uri</a> <span style='color: #000;'>$title</span>";
print<<<EOF
<title>{$lang['panel_page_title']}</title>
<style type="text/css">
	.nav .report-page {
		margin: .5em 0 .5em 0;
	}
	.nav .report-page span {
		padding: 2px;
		background: #FFD38F;
	}
</style>
</head>
<body>
<div id="wrapper">
EOF;

$menu = 'page';
$help = "<a href='admin-help.php'>Help</a>";
require 'admin-nav-tpl.php';

// Key to this array is $moderate[$i], values can be 0 - 5
$message =  array(
	'',
	$lang['moderation_msg'],
	$lang['max_links_msg'],
	$lang['invalid_akismet_key'],
	$lang['akismet_no_response'],
	$lang['spamword'],
	);

if ($ccount) {
	print<<<EOF
	<table cellspacing="0" cellpadding="0"> 
	<tr>
		<th class='date'>Date/Time</th>
		<th class='id'>ID</th>
		<th class='author'>Author</th>
		<th class='website'>Website</th>
		<th class='ip'>IP</th>
		<th class="action">Action</th>
	</tr>
EOF;
	for($i=0; $i<$ccount; $i++) {
		$date = ucwords(strftime($config['admin_date'], $time[$i]));
		$mi = $moderate[$i];	// message index
		
		if ($banned_msg[$i] == '') {
			$ban_link = "<a href=" .TB_PATH. "admin?action=banip&amp;ip={$ip[$i]}&amp;from={$_REQUEST['href']}&amp;return=pagelist>[{$lang['banip_link']}]</a>";
		} else {
			$ban_link = "<a href=" .TB_PATH. "admin?action=unbanip&amp;ip={$ip[$i]}&amp;from={$_REQUEST['href']}&amp;return=pagelist>[{$lang['unbanip_link']}]</a>";
		}
		
		if ($moderate[$i]) {
			$approve_link = "<a href=" .TB_PATH. "admin?action=approve&amp;id={$id[$i]}&amp;from={$_REQUEST['href']}&amp;return=pagelist>[{$lang['approve_link']}]</a>";
		} else {
			$approve_link = '';
		}
		if ($config['akismet_key']) {
			$is_spam_link = "<a href=" .TB_PATH. "admin?action=delete&amp;id={$id[$i]}&amp;from={$_REQUEST['href']}&amp;spam=spam&amp;return=pagelist>[{$lang['spam_link']}]</a>";	
		} else {
			$is_spam_link = '';
		}
		$delete_link = "<a href=" .TB_PATH. "admin?action=delete&amp;id={$id[$i]}&amp;page=$request_uri&amp;from={$_REQUEST['href']}&amp;return=pagelist>[{$lang['delete_link']}]</a>";
		$edit_link = "<a href=" .TB_PATH. "comments.php?edit=1&amp;edit_id={$id[$i]}&amp;page={$href[$i]}&amp;article_url={$href[$i]} target='_blank'>[{$lang['edit_link']}]</a>";
		$reply_link = "<a href=" .TB_PATH. "comments.php?reply=1&amp;form_replyto={$id[$i]}&amp;page={$href[$i]}&amp;article_url={$href[$i]} target='_blank'>[{$lang['reply_link']}]</a>";
		
		print<<<EOF
	<tr class='comment-header'>
		<td class='date'>$date</td>
		<td class='id'>$id[$i]</td>
		<td class='author'><a href="mailto:$email[$i]?subject={$lang['your_comment']} {$config['site_name']}">$author[$i]</a> <span class='subscribed'>$subscribed_label[$i]</span></td>
		<td class='website'>$website[$i]</td>
		<td class='ip'>$ip[$i] <i>$banned_msg[$i]</i></td>
		<td class="action">
			<span class='moderation-msg $reply_class[$i]'>$message[$mi]</span> $edit_link $reply_link $approve_link $ban_link $is_spam_link $delete_link 
		</td> 
	</tr>
	<tr>
		<td class="comment-text $reply_class[$i]" colspan="6">$reply_label[$i] <div>{$text[$i]}</div></td>
	</tr>
EOF;
	}
print<<<EOF
	</table>
EOF;
} else {
	print<<<EOF
		<p class="text">{$lang['no_comments']}</p>
EOF;
}
require 'admin-footer-tpl.php';
?>