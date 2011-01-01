<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin panels page heading and menu bar
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

$subscribers_page  = "<a href='".URL_PATH."admin?action=subscriberlist&amp;order=href'>{$lang['nav_subscribers_page']}</a>";
$subscribers_email = "<a href='".URL_PATH."admin?action=subscriberlist&amp;order=email'>{$lang['nav_email_link']}</a>";

print "
<div class='nav'>
	<div class='logo'> 
		<a href='admin-help.php' target='_blank'>Admin Help</a> &ndash; 
		<a href='../doc'>User Guide</a><br />
		Version {$config['version']}
	</div>
	<div class='version'>
		<a href='http://www.scripts.oldguy.us/talkback'>TalkBack Website</a> &ndash; 
		<a href='http://www.scripts.oldguy.us/forums/' target='_blank'>Support Forum</a><br />
		<a href='http://www.scripts.oldguy.us/forums/index.php?action=register' target='_blank'>Register for bugfix/upgrade notices</a><br />
		<div>
			<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
			<input type='hidden' name='cmd' value='_s-xclick' />
			<input type='hidden' name='encrypted' value='-----BEGIN PKCS7-----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-----END PKCS7-----' />
			<input type='submit' value='Donate' style='font-size: .9em' />

							</form>
						</div>
	</div>
	
	<div class='panel-title'><span class='panel-sitename'>{$config['site_name']}</span><br />{$lang['panel_title']}</div>
	<div class='report-title'>$report_title</div>
	<div class='report-page'><span>$report_page</span></div>
	<div class='stats-line'> 
		$spam_count_msg
		$counts_msg
	</div>
	
	<div class='navbar'>
	<table cellspacing='0' cellpadding='0'>
		<tr valign='bottom'>";

if ($menu == "select") {
	print "<td class='first'><span class='active'>{$lang['nav_home_link']}</a></span></td>";
} else {
	print "<td class='first'><a href='" .TB_PATH. "admin?action=select'>{$lang['nav_home_link']}</a></td>";
}
if ($menu == 'page') {
	print "<td><span class='active'>{$lang['nav_page_link']}</span></td>";
} 
if ($menu == "recent") {
	print "<td><span class='active'>{$lang['nav_recent_link']}</span></td>";
} else {
	print "<td><a href='" .TB_PATH. "admin?action=recentlist'>{$lang['nav_recent_link']}</a></td>";
}
if ($menu == "moderation") {
	print "<td><span class='active'>{$lang['nav_moderation_link']}</span></td>";
} else {
	print "<td><a href='" .TB_PATH. "admin?action=unapprovedlist'>{$lang['nav_moderation_link']}</a></td>";
}
if ($menu == "spam") {
	print "<td><span class='active'>{$lang['nav_spam_link']}</span></td>";
} else {
	print "<td><a href='" .TB_PATH. "admin?action=spamlist'>{$lang['nav_spam_link']}</a></td>";
}
if ($menu == "banned") {
	print "<td><span class='active'>{$lang['nav_banned_link']}</span></td>";
} else {
	print "<td><a href='" .TB_PATH. "admin?action=bannedlist'>{$lang['nav_banned_link']}</a></td>";
}
if ($menu == "subscribers") {
	print "<td>{$lang['nav_subscribersby']}<br />";
	if ($menu2 == "page") {
		print "<span class='active'>{$lang['nav_subscribers_page']}</span>&nbsp;&nbsp;$subscribers_email";
	} else {
		print "$subscribers_page&nbsp;&nbsp;<span class='active'>{$lang['nav_email_link']}</span>";
	}
	print "</td>";
} else {
	print "<td><span style='color: #FFC76F'>{$lang['nav_subscribersby']}</span><br />$subscribers_page&nbsp;&nbsp;$subscribers_email</td>";
}
if ($menu == "maint") {
	print "<td><span class='active'>{$lang['nav_maint_link']}</span></td>";
} else {
	print "<td><a href='" .TB_PATH."admin?action=maintenance'>{$lang['nav_maint_link']}</a></td>";
}
print "<td><a href='" .TB_PATH."admin?action=logout'>{$lang['nav_logout']}</a></td>";
		
print<<<EOF
		</tr>
	</table>
	</div>
</div>
EOF;
?>