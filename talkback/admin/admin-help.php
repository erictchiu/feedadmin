<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin panels help table of contents
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
define('IS_VALID_INCLUDE', TRUE);
require '../config.php';
require LANGUAGE_FILE;

$title = $lang['admin_help_index_title'];
require 'admin-help-header.php';

if ($_REQUEST['p'] == 'pageselect') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_pageselect_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_pagelist']}</div>";
	
} elseif ($_REQUEST['p'] == 'config') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_config_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_config1']}{$lang['admin_help_config2']}</div>";

} elseif ($_REQUEST['p'] == 'pagelist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_pagelist_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_pagelist']}</div>";
	
} elseif ($_REQUEST['p'] == 'spamlist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_spamlist_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_spamlist']}</div>";
	
} elseif ($_REQUEST['p'] == 'unapprovedlist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_unapprovedlist_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_unapprovedlist']}</div>";
	
} elseif ($_REQUEST['p'] == 'recentlist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_recentlist_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_recentlist']}</div>";
	
} elseif ($_REQUEST['p'] == 'actionslist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_actions_list_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_actions_list']}</div>";
	
} elseif ($_REQUEST['p'] == 'subscriberlist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_subscriberlist_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_subscriberlist']}</div>";
	
} elseif ($_REQUEST['p'] == 'actions') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_actions_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_actions']}</div>";
	
} elseif ($_REQUEST['p'] == 'backup') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_backupdb_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_backupdb']}</div>";
	
} elseif ($_REQUEST['p'] == 'bannedlist') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_bannedlist_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_bannedlist']}</div>";
	
} elseif ($_REQUEST['p'] == 'optimize') {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_optimizedb_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_optimizedb']}</div>";
	
} else {
	$head = "<strong>{$lang['admin_help_title']}<br />{$lang['admin_help_index_title']}</strong><br />";
	$body = "<div id='display-message'>{$lang['admin_help_index']}</div>";
}

print"
	<div id='header'>
		$head
	</div>
	<div id='index-link'><a href='admin-help.php'>{$lang['admin_help_title']} {$lang['admin_help_index_title']}</a></div>
	$body
	<div id='footer'>Powered by <a href='http://www.scripts.oldguy.us'>TalkBack</a></div>
</div>
</body>
</html>";
?>