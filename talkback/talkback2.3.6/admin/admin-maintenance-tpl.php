<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin maintenance menu
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
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

$h1 = "<a href='admin-cph.php?";
$h2 = "&height=250&width=400&keepThis=true&TB_iframe=true' title='{$lang['ach_panel_title']}' class='thickbox  help'>&nbsp;&nbsp;&nbsp;</a>";

require 'admin-head-tpl.php';

print<<<EOF
<title>{$lang['panel_maint_title']}</title>
<style type="text/css">
	.nav .report-page {
		margin: .5em 0 .5em 0;
		}
	strong {font-size: .9em;}
		}
</style>
</head>
<body>
<div id="wrapper">
EOF;

$report_title = "{$lang['panel_maint_title']}";
$menu = 'maint';
require 'admin-nav-tpl.php';

if ($config['is_demo_system']) {
	$disabled = " <span style='color: #f00;'>Disabled</span>";
}else {
	$disabled = '';
}

print"

<div id='maint-wrapper'>
	<ul class='flush extra-height' style= 'margin-top: 10px; margin-bottom: 10px;'>
		<li><a href='" .TB_PATH . "admin/?action=displayconfig'>{$lang['nav_config_link']}</a></li>
		<li><a href='" .TB_PATH. "admin/?action=optimizedb'>{$lang['nav_optimize_link']}</a> 
         $h1&name=admin_help_optimizedb&TB_iframe=true&height=250&width=400' title='{$lang['admin_help_optimizedb_title']}' class='thickbox  help'>&nbsp;&nbsp;&nbsp;</a> $disabled</li>
		<li><a href='" .TB_PATH. "admin/?action=backupdb'>{$lang['nav_backup_link']}</a> 
			$h1&name=admin_help_backupdb&TB_iframe=true&height=250&width=400' title='{$lang['admin_help_backupdb_title']}' class='thickbox  help'>&nbsp;&nbsp;&nbsp;</a> $disabled</li>
		<li>
			<form action='{$_SERVER['PHP_SELF']}' method='post'>
				<input type='hidden' name='action' value='purge' onclick='return confirmPurge()' />
				<input type='submit' value='{$lang['purge_submit']}' onclick='return confirmPurge()' /> {$lang['purge_days']} $disabled
			</form> 
		</li>
	</ul>
	$display_message
</div>";
require 'admin-footer-tpl.php';
?>