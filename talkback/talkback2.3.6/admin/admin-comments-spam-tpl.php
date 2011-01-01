<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Spam comments panel template
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
<title>{$lang['panel_spam_title']}</title>
</head>
<body>
<div id="wrapper">
EOF;
$report_title = "{$lang['panel_spam_title']} ({$ccount})";
$menu = 'spam';
require 'admin-nav-tpl.php';

if ($ccount) {
	print "
	<table cellspacing='0' cellpadding='0'> 
	<tr>
		<th class='page'>Page</th>
		<th class='id'>ID</th>
		<th class='author'>Author</th>
		<th class='website'>Website</th>
		<th class='ip'>IP</th>
		<th class='date'>Date/Time</th>
		<th class='action'>Action</th>
	</tr>
	
	<tr>
			<td colspan='7' class='delete_spam'>
				<a href='" .TB_PATH. "admin?action=deletespam&amp;return=spamlist'>[{$lang['deletespam_link']}]</a>
			</td> 
	</tr>";
	for($i=0; $i<$ccount; $i++) {
		$date = ucwords(strftime($config['admin_date'], $time[$i]));
		$author[$i]   = chunk_split($author[$i], 30);
		$website[$i]  = chunk_split($website[$i], 30);
		
		if ($banned_msg[$i] == '') {
			// Ban ip link
			$ban_link = "<a href='" .TB_PATH. "admin?action=banip&amp;ip={$ip[$i]}&amp;return=spamlist'>[{$lang['banip_link']}]</a>";
		} else {
			// Unban ip link
			$ban_link = "<a href='" .TB_PATH. "admin?action=unbanip&amp;ip={$ip[$i]}&amp;return=spamlist'>[{$lang['unbanip_link']}]</a>";
		}

		$delete_link = "<a href='" .TB_PATH. "admin?action=delete&amp;id={$id[$i]}&amp;return=spamlist'>[{$lang['delete_link']}]</a>";
		$approve_link = "<a href='" .TB_PATH. "admin?action=approve&amp;id={$id[$i]}&amp;return=spamlist'>[{$lang['approve_link']}]</a>";

print<<<EOF
	<tr class="comment-header">
			<td class='page'><a href='$href[$i]'>$href[$i]</a></td>
			<td class='id'>$id[$i]</td>
			<td class='author'><a href="mailto:$email[$i]?subject={$lang['your_comment']} {$config['site_name']}">$author[$i]</a></td>
			<td class='website'>$website[$i]</td>
			<td class='ip'>$ip[$i] <i>$banned_msg[$i]</i></td>
			<td class='date'>$date</td>
			<td class="action">
				<span class='moderation-msg'>{$lang['spam_msg']}</span> $approve_link $ban_link $delete_link 
			</td> 
	</tr>
	<tr>
		<td class="comment-text" colspan="7"><div>{$text[$i]}</div></td>
	</tr>
EOF;
	}
print "
	<tr>
		<td colspan='7' class='delete_spam'>
				<a href='" .TB_PATH. "admin?action=deletespam&amp;return=spamlist'>[{$lang['deletespam_link']}]</a>
		</td> 
	</tr>
	</table>";
} else {
	print<<<EOF
		<p class="text">{$lang['no_comments']}</p>
EOF;
}
require 'admin-footer-tpl.php';
?>