<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The admin home page template
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
<title>{$lang['panel_home_title']}</title>
<style type='text/css'>
	.nav .report-page {
		margin: .5em 0 .5em 0;
	}
</style>
</head>
<body>
<div id='wrapper'>
EOF;

$report_title = "{$lang['panel_home_title']}";
$menu = 'select';
require 'admin-nav-tpl.php';

print "
<!-- <div id='searchbox'>
	<form method='post' action='" .TB_PATH. "admin'>
		<input type='text' name='query' size='30' value='{$lang['url_search_label']}' /> 
		<input type='hidden' name='action' value='search' /> 
		<input type='submit' value='{$lang['search_submit']}' />&nbsp;&nbsp;&nbsp;
	</form>
</div> -->
<div class='text'>";

if ($hrefs_count) {
	if ($query != '') {
		print "<br /><strong>{$lang['search_results']} &ldquo;{$query}&rdquo;</strong>";
	} else {
		print "<br /><strong>{$lang['panel_page_title']}</strong>";
	}
	foreach($href as $key =>$value) {
		$link = urlencode($value);
		print "<p>&nbsp;&nbsp;&nbsp;<a href='" .TB_PATH. "admin?action=pagelist&amp;href={$link}'>{$value}</a> {$title[$key]} ({$count[$key]})</p>";
	}
} else {
	if ($query == '') {
		print "<br />{$lang['no_comments']}";
	} else {
		print "<br />{$lang['no_search_results']} &ldquo;{$query}&rdquo;";
	}
}
print"
    <p>$pages_string</p><br />
</div>";
require 'admin-footer-tpl.php';
?>