<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Recent comments panel template
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
<title>{$lang['panel_recent_title']}</title>
</head>
<body>
<div id="wrapper">
EOF;

require LANGUAGE_FILE;

$menu = 'recent';
$report_title = "{$lang['panel_recent_title']}" . " ($ccount)";
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
		<th>Page</th>
		<th class='id'>ID</th>
		<th class='author'>Author</th>
		<th class='website'>Website</th>
		<th class='ip'>IP</th>
		<th class="action">Action</th>
	</tr>
EOF;

	for($i=0; $i<$ccount; $i++) {
		$mi = $moderate[$i];	// message index
		$date = ucwords(strftime($config['admin_date'], $time[$i]));
		
		if ($banned_msg[$i] == '') {
			$ban_link = "<a href=" .TB_PATH. "admin?action=banip&amp;ip={$ip[$i]}&amp;return=recentlist>[{$lang['banip_link']}]</a>";
		} else {
			$ban_link = "<a href=" .TB_PATH. "admin?action=unbanip&amp;ip={$ip[$i]}&amp;return=recentlist>[{$lang['unbanip_link']}]</a>";
		}
		
		if ($moderate[$i]) {
			$approve_link = "<a href=" .TB_PATH. "admin?action=approve&amp;id={$id[$i]}&amp;return=recentlist>[{$lang['approve_link']}]</a>";
		} else {
			$approve_link = '';
		}
		if ($config['akismet_key']) {
			$is_spam_link = "<a href=" .TB_PATH. "admin?action=delete&amp;id={$id[$i]}&amp;spam=spam&amp;return=recentlist>[{$lang['spam_link']}]</a>";
		} else {
			$is_spam_link = '';
		}
		$delete_link = "<a href=" .TB_PATH. "admin?action=delete&amp;id={$id[$i]}&page={$href[$i]}&amp;return=recentlist>[{$lang['delete_link']}]</a>";
		$edit_link = "<a href=" .TB_PATH. "comments.php?edit=1&amp;edit_id={$id[$i]}&amp;page={$href[$i]}&article_url={$href[$i]} target='_blank'>[{$lang['edit_link']}]</a>";
		$reply_link = "<a href=" .TB_PATH. "comments.php?reply=1&amp;form_replyto={$id[$i]}&amp;page={$href[$i]}&article_url={$href[$i]} target='_blank'>[{$lang['reply_link']}]</a>";
		
		print<<<EOF
	<tr class='comment-header'>
		<td class='date'>$date</td>
		<td class='page'><a href='$href[$i]'>$href[$i]</a></td>
		<td class='id'>$id[$i]</td>
		<td class='author'><a href="mailto:$email[$i]?subject={$lang['your_comment']} {$config['site_name']}">$author[$i]</a> <span class='subscribed'>$subscribed_label[$i]</span></td>
		<td class='website'>$website[$i]</td>
		<td class='ip'>$ip[$i] <i>$banned_msg[$i]</i></td>
		<td class="action">
			<span class='moderation-msg'>$message[$mi] $edit_link $reply_link $approve_link $ban_link $is_spam_link $delete_link</span>
		</td> 
	</tr>
	<tr>
		<td class="comment-text $reply_class[$i]" colspan="7">$reply_label[$i] <div>{$text[$i]}</div></td>
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