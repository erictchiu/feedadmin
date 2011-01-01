<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Configuration settings display and edit template
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

if ($config['is_demo_system']) {
	$request = "<br />Updates have been disabled on this demo system. If you submit any changes the page will be redisplayed with the original values.";
	$dbhost   = '**********';
	$dbuser   = '**********';
	$dbpass   = '**********';
	$dbname   = '**********';
	$dbprefix = '**********';
	$email    =  '**********';
} else {
	$dbhost   = DBHOST;
	$dbuser   = DBUSER;
	$dbpass   = DBPASS;
	$dbname   = DBNAME;
	$dbprefix = DBPREFIX;
	$email    = ADMIN_EMAIL;
}

$h1 = "<a href='admin-cph.php?height=250&amp;width=400";
$h2 = "&amp;keepThis=true&amp;TB_iframe=true' title='' class='thickbox  help'>&nbsp;&nbsp;&nbsp;</a>";

print "
	$request
	<noscript>You must enable Javascript to use the help buttons.</noscript>
	<form action='{$_SERVER['REQUEST_URI']}' method='post'>
		<input type='hidden' name='action' value='updateconfig' />
		
		<table cellspacing='0' cellpadding='0'>

<!-- Administration settings -->
		<tr><td colspan='2'><div class='section'>{$lang['header_admin']}</div></td></tr>
		<tr><td class='option'><input name='site_name' type='text' value='{$config['site_name']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['site_name']} 
			{$h1}&amp;name=ach_site_name{$h2}</td></tr>
			
		<tr><td class='option'><input name='site_url' type='text' value='{$config['site_url']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['site_url']} 
			{$h1}&amp;name=ach_site_url{$h2}</td></tr>
			
		<tr><td class='option'><input name='admin_login' type='text' value='{$config['admin_login']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['admin_login']} 
			{$h1}&amp;name=ach_admin_login{$h2}</td></tr>
			
		<tr><td class='option'><input name='admin_password' type='text' value='{$config['admin_password']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['admin_password']} 
			{$h1}&amp;name=ach_admin_password{$h2}</td></tr>
			
		<tr><td class='option'><input name='admin_name' type='text' value='{$config['admin_name']}' size='20' /></td>
			<td>{$lang['admin_name']} 
			{$h1}&amp;name=ach_admin_name{$h2}</td></tr>
			
		<tr><td class='option'><input name='email_from' type='text' value='$email_from' size='20' /></td>
			<td><span class='required'>*</span> {$lang['email_from']} 
			{$h1}&amp;name=ach_email_from{$h2}</td></tr>
			
		<tr><td class='option'><input name='time_offset' type='text' value='{$config['time_offset']}' size='20' /></td>
			<td>{$lang['time_offset']} {$h1}&amp;name=ach_time_offset$h2
			<br /> $server_time {$lang['server_time']}<br /> $local_time {$lang['corrected_time']}</td></tr>
		
		<tr><td class='option'><input name='date_locale' type='text' value='{$config['date_locale']}' size='20' /></td>
			<td>{$lang['date_locale']} 
			{$h1}&amp;name=ach_date_locale{$h2}<br /> </td></tr>
			
		<tr><td class='option'><input name='admin_date' type='text' value='{$config['admin_date']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['admin_date']} ($admin_time) 
			{$h1}&amp;name=ach_admin_date{$h2}</td></tr>
			
		<tr><td class='option'><input name='num_of_days' type='text' value='{$config['num_of_days']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['num_of_days']} 
			{$h1}&amp;name=ach_num_of_days{$h2}</td></tr>
			
		<tr><td class='option'><input name='files_directory' type='text' value='{$config['files_directory']}' size='20' /></td>
			<td>{$lang['files_directory']} 
			{$h1}&amp;name=ach_files_directory{$h2}</td></tr>
			
		<tr><td class='option'><input name='mysqldump_path' type='text' value='{$config['mysqldump_path']}' size='20' /></td>
			<td>{$lang['mysqldump_path']} 
			{$h1}&amp;name=ach_mysqldump_path{$h2}</td></tr>
			
		<tr><td class='right'>{$lang['admin_cookie']}</td>
			<td><input type='radio' name='admin_cookie' value='0' $admin_cookie_N />{$lang['admin_cookie_N']}
			<input type='radio' name='admin_cookie' value='1' $admin_cookie_Y />{$lang['admin_cookie_Y']}
			{$h1}&amp;name=ach_admin_cookie{$h2}</td></tr>
			
		<tr><td colspan='2'><div class='radio'>{$lang['admin_notices']} {$h1}&amp;name=ach_admin_notices$h2
			<br /><input type='radio' name='admin_notices' value='0' $admin_notices_0 />{$lang['admin_notices_0']}
			<br /><input type='radio' name='admin_notices' value='1'  $admin_notices_1 />{$lang['admin_notices_1']}
			<br /><input type='radio' name='admin_notices' value='3'  $admin_notices_2 />{$lang['admin_notices_2']}</div></td></tr>
			
<!-- Comments settings -->
		<tr><td colspan='2'><div class='section'>{$lang['header_general']}</div></td></tr>
		<tr><td class='right'>{$lang['maintenance']}</td>
			<td><input type='radio' name='maintenance' value='0' $maintenance_N />{$lang['maintenance_N']} 
			<input type='radio' name='maintenance' value='1' $maintenance_Y /> {$lang['maintenance_Y']} 
			{$h1}&amp;name=ach_maintenance{$h2}</td></tr>
		
		<tr><td class='option'><input name='comments_date' type='text' value='{$config['comments_date']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['comments_date']} ($comments_time)
			{$h1}&amp;name=ach_comments_date{$h2}</td></tr>
		
		<tr><td class='option'><input name='wait_time' type='text' value='{$config['wait_time']}' size='20' /></td>
			<td>{$lang['wait_time']} {$h1}&amp;name=ach_wait_time{$h2}</td></tr>
		
		<tr><td class='option'><input name='page_limit' type='text' value='{$config['page_limit']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['page_limit']} {$h1}&amp;name=ach_page_limit{$h2}</td></tr>
		
		<tr><td class='option'><input name='comment_size' type='text' value='{$config['comment_size']}' size='20' /></td>
			<td>{$lang['comment_size']} {$h1}&amp;name=ach_comment_size{$h2}</td></tr>
		
		<tr><td class='option'><input name='user_agent_days' type='text' value='{$config['user_agent_days']}' size='20' /></td>
			<td>{$lang['user_agent_days']} {$h1}&amp;name=ach_user_agent_days{$h2}</td></tr>
			
		<tr class='radio'><td colspan='2' class='option' style='width: 590px' >
			{$lang['allowed_tags']} {$h1}&amp;name=ach_allowed_tags{$h2}<br />
			<input style='width: 590px' name='allowed_tags' type='text' value='{$config['allowed_tags']}' size='20' />
		</td></tr>
		
	<!-- Enable/disable section -->
		<tr><td class='right'>{$lang['comments_link_target']}</td>
			<td><input type='radio' name='comments_link_target' value='0' $comments_link_target_N />{$lang['comments_link_target_N']}
			<input type='radio' name='comments_link_target' value='1' $comments_link_target_Y />{$lang['comments_link_target_Y']}
			{$h1}&amp;name=ach_comments_link_target{$h2}</td></tr>
		
			<tr><td class='right'>{$lang['comment_search']}</td>
			<td><input type='radio' name='comment_search' value='1' $comment_search_Y />{$lang['comment_search_Y']}
			<input type='radio' name='comment_search' value='0' $comment_search_N />{$lang['comment_search_N']}
			{$h1}&amp;name=ach_comment_search{$h2}</td></tr>
			
			<tr><td class='right'>{$lang['bad_words']}</td>
			<td><input type='radio' name='bad_words' value='1' $bad_words_Y />{$lang['bad_words_Y']}
			<input type='radio' name='bad_words' value='0' $bad_words_N />{$lang['bad_words_N']}
			{$h1}&amp;name=ach_bad_words{$h2}</td></tr>

		<tr><td class='right'>{$lang['allow_replies']}</td>
			<td><input type='radio' name='allow_replies' value='1' $allow_replies_Y />{$lang['allow_replies_Y']}
			<input type='radio' name='allow_replies' value='0' $allow_replies_N />{$lang['allow_replies_N']}
			{$h1}&amp;name=ach_allow_replies{$h2}</td></tr>

		<tr><td class='right'>{$lang['comments_emoticons']}</td>
			<td><input type='radio' name='comments_emoticons' value='1' $comments_emoticons_Y />{$lang['comments_emoticons_Y']}
			<input type='radio' name='comments_emoticons' value='0' $comments_emoticons_N />{$lang['comments_emoticons_N']}
			{$h1}&amp;name=ach_comments_emoticons{$h2}</td></tr>
			
		<tr><td class='right'>{$lang['gravatar']}</td>
			<td><input type='radio' name='gravatar' value='1' $gravatar_Y />{$lang['gravatar_Y']}
			<input type='radio' name='gravatar' value='0' $gravatar_N />{$lang['gravatar_N']}
			{$h1}&amp;name=ach_gravatar{$h2}</td></tr>
			
		<tr><td></td>
			<td>&nbsp;&nbsp;<input name='gravatar_size' type='text' value='{$config['gravatar_size']}' size='1' /> {$lang['gravatar_size']} {$h1}&amp;name=ach_gravatar_size{$h2}</td></tr>

		<tr><td></td>
			<td>&nbsp;&nbsp;<select name='gravatar_rating'> 
				<option value='G'  $select_g>G</option>
				<option value='PG' $select_pg>PG</option>
				<option value='R'  $select_r>R</option>
				<option value='X'  $select_x>X</option>
			</select> {$lang['gravatar_rating']} {$h1}&amp;name=ach_gravatar_rating{$h2}</td></tr>
			
		<tr><td class='right'>{$lang['lightbox']}</td>
			<td><input type='radio' name='lightbox' value='1' $lightbox_Y />{$lang['lightbox_Y']}
			<input type='radio' name='lightbox' value='0' $lightbox_N />{$lang['lightbox_N']}
			{<a href='../images/itytsu.jpg' title='' class='thickbox'>example</a>}
			{$h1}&amp;name=ach_lightbox{$h2}</td></tr>
			
	<!-- Show/don&rsquo;t show  settings -->		
		<tr><td class='right'>{$lang['sort_order_line']}</td>
			<td><input type='radio' name='sort_order_line' value='never' $sort_order_line_NEVER />{$lang['sort_order_line_NEVER']}
			<input type='radio' name='sort_order_line' value='always' $sort_order_line_ALWAYS />{$lang['sort_order_line_ALWAYS']} 
			<input type='radio' name='sort_order_line' value='depends' $sort_order_line_DEPENDS />{$lang['sort_order_line_DEPENDS']} 
			{$h1}&amp;name=ach_sort_order_line{$h2}</td></tr>
		
		<tr><td class='right'>{$lang['author_location']}</td>
			<td><input type='radio' name='author_location' value='1' $author_location_Y />{$lang['author_location_Y']}
			<input type='radio' name='author_location' value='0' $author_location_N />{$lang['author_location_N']}
			{$h1}&amp;name=ach_author_location{$h2}</td></tr>
			
		<tr><td class='right'>{$lang['author_website']}</td>
			<td><input type='radio' name='author_website' value='1' $author_website_Y />{$lang['author_website_Y']}
			<input type='radio' name='author_website' value='0' $author_website_N />{$lang['author_website_N']}
			{$h1}&amp;name=ach_author_website$h2&nbsp;
			<input type='radio' name='author_website_link' value='1' $author_website_link1 />{$lang['author_website_link1']}
			<input type='radio' name='author_website_link' value='2' $author_website_link2 />{$lang['author_website_link2']}
			<input type='radio' name='author_website_link' value='3' $author_website_link3 />{$lang['author_website_link3']}
			<input type='radio' name='author_website_link' value='4' $author_website_link4 />{$lang['author_website_link4']}
		</td></tr>
			
		<tr><td class='right'>{$lang['comment_subject']}</td>
			<td><input type='radio' name='comment_subject' value='1' $comment_subject_Y />{$lang['comment_subject_Y']}
			<input type='radio' name='comment_subject' value='0' $comment_subject_N />{$lang['comment_subject_N']}
			{$h1}&amp;name=ach_comment_subject{$h2}</td></tr>
			
		<tr><td class='right'>{$lang['comments_subscribe']}</td>
			<td><input type='radio' name='comments_subscribe' value='1' $comments_subscribe_Y />{$lang['comments_subscribe_Y']}
			<input type='radio' name='comments_subscribe' value='0' $comments_subscribe_N />{$lang['comments_subscribe_N']}
			{$h1}&amp;name=ach_comments_subscribe{$h2}</td></tr>
			
		<tr><td class='right'>{$lang['comments_legend']}</td>
			<td style='background: #eeeeee'><input type='radio' name='comments_legend' value='1' $comments_legend_Y />{$lang['comments_legend_Y']}
			<input type='radio' name='comments_legend' value='0' $comments_legend_N />{$lang['comments_legend_N']}
			{$h1}&amp;name=ach_comments_legend{$h2}<br />
			<input type='radio' name='use_pages' value='0' $use_pages_N />{$lang['use_pages_N']}
			<input type='radio' name='use_pages' value='1' $use_pages_Y />{$lang['use_pages_Y']}</td></tr>
		
<!-- Moderation and spam settings -->
		<tr><td colspan='2'><div class='section'>{$lang['header_moderation']}</div></td></tr>
		
		<tr><td class='right'>{$lang['moderation_form']}</td>
			<td><input type='radio' name='moderation' value='0' $moderate_all_N />{$lang['moderate_all_N']} 
			<input type='radio' name='moderation' value='1' $moderate_all_Y /> {$lang['moderate_all_Y']}
			{$h1}&amp;name=ach_moderation{$h2}</td></tr>
			
		<tr><td class='option'><input name='akismet_key' type='text' value='$akismet_key' size='20' /></td>
			<td>{$lang['akismet_key']}
			{$h1}&amp;name=ach_akismet_key{$h2}</td></tr>
			
		<tr><td class='option'><input name='max_links' type='text' value='{$config['max_links']}' size='20' /> </td>
			<td>{$lang['max_links']}
			{$h1}&amp;name=ach_max_links{$h2}</td></tr>
			
		<tr><td class='right'><input type='checkbox' name='captcha' value='1' $captcha  /></td>
			<td>{$lang['captcha']}
			{$h1}&amp;name=ach_captcha{$h2}</td></tr>
			
		<tr><td class='option'><input name='captcha_public' type='text' value='$captcha_public' size='20' /></td>
			<td>{$lang['captcha_public']}
			{$h1}&amp;name=ach_captcha_keys{$h2}</td></tr>
			
		<tr><td class='option'><input name='captcha_private' type='text' value='$captcha_private' size='20' /></td>
			<td>{$lang['captcha_private']}</td></tr>
			
		<tr><td class='right'><input type='checkbox' name='spamwords' value='1' $spamwords  /></td>
			<td>{$lang['spamwords']}
			{$h1}&amp;name=ach_spamwords{$h2}</td></tr>
			
		<tr><td class='right'><input type='checkbox' name='discard_spam' value='1' $discard_spam  /></td>
			<td>{$lang['discard_spam']}
			{$h1}&amp;name=ach_discard_spam{$h2}</td></tr>
			
<!-- Template file names -->
		<tr><td colspan='2'><div class='section'>{$lang['header_templates']}</div></td></tr>	
		<tr><td class='option'><input name='comments_driver' type='text' value='{$config['comments_driver']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['comments_driver']}
			{$h1}&amp;name=ach_comments_driver{$h2}</td></tr>
		<tr><td class='option'><input name='comments_display_tpl' type='text' value='{$config['comments_display_tpl']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['comments_display_tpl']}</td></tr>
		<tr><td class='option'><input name='comments_form_tpl' type='text' value='{$config['comments_form_tpl']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['comments_form_tpl']}</td></tr>
		<tr><td class='option'><input name='preview_panel_tpl' type='text' value='{$config['preview_panel_tpl']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['preview_panel_tpl']}</td></tr>
		<tr><td class='option'><input name='reply_panel_tpl' type='text' value='{$config['reply_panel_tpl']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['reply_panel_tpl']}</td></tr>
		<tr><td class='option'><input name='help_panel_tpl' type='text' value='{$config['help_panel_tpl']}' size='20' /></td>
			<td><span class='required'>*</span> 
			{$lang['help_panel_tpl']}</td></tr>
			
<!-- Advanced and testing settings -->
		<tr><td colspan='2'><div class='section'>{$lang['header_advanced']}</div></td></tr>
		<tr><td class='right'><input type='checkbox' name='log_errors' value='1' $log_errors  /></td>
			<td>{$lang['log_errors']}
			{$h1}&amp;name=ach_log_errors{$h2}</td></tr>
		<tr><td class='option'><input name='errorlog_filename' type='text' value='{$config['errorlog_filename']}' size='20' /></td>
			<td>{$lang['logfile_name']}
			{$h1}&amp;name=ach_logfile_name{$h2}</td></tr>
		<tr><td class='option'><input name='test_ip' type='text' value='{$config['test_ip']}' size='20' /></td>
			<td>{$lang['test_ip']}
			{$h1}&amp;name=ach_test_ip{$h2}</td></tr>
		<tr><td class='option'><input name='cookie_name' type='text' value='{$config['cookie_name']}' size='20' /></td>
			<td>{$lang['cookie_name']}
			{$h1}&amp;name=ach_cookie_name{$h2}</td></tr>
		<tr><td class='option'><div>$random_seed</div></td>
			<td>{$lang['random_seed']}
				{$h1}&amp;name=ach_random_seed$h2
				<input type='checkbox' name='regen_seed' value='1' /> 
				{$lang['regen_seed']}</td></tr>
			
<!-- config.php settings -->
		<tr><td colspan='2'><div class='section'>{$lang['header_configphp']}</div></td></tr>
		<tr><td colspan='2'>{$lang['note_configphp']} {$h1}&amp;name=ach_configphp{$h2}</td></tr>
		<tr><td class='option'><div>$dbhost</div></td>
			<td>{$lang['dbhost']}
			{$h1}&amp;name=ach_dbhost{$h2}</td></tr>
		<tr><td class='option'><div>$dbuser</div></td>
			<td>{$lang['dbuser']}
			{$h1}&amp;name=ach_dbuser{$h2}</td></tr>
		<tr><td class='option'><div>$dbpass</div></td>
			<td>{$lang['dbpassword']}
			{$h1}&amp;name=ach_dbpassword{$h2}</td></tr>
		<tr><td class='option'><div>$dbname</div></td>
			<td>{$lang['dbname']}
			{$h1}&amp;name=ach_dbname{$h2}</td></tr>
		<tr><td class='option'><div>$dbprefix</div></td>
			<td>{$lang['dbprefix']}
			{$h1}&amp;name=ach_dbprefix{$h2}</td></tr>
		<tr><td class='option'><div>".DEFAULT_LANGUAGE."</div></td>
			<td>{$lang['default_language']}
			{$h1}&amp;name=ach_default_language{$h2}</td></tr>
		<tr><td class='option'><div>$email</div></td>
			<td>{$lang['admin_email']}
			{$h1}&amp;name=ach_admin_email{$h2}</td></tr>
		<tr><td class='option'><div>{$config['message_panel_tpl']}</div></td>
			<td>{$lang['message_panel_tpl']}
			{$h1}&amp;name=ach_message_panel_tpl{$h2}</td></tr>
		<tr><td class='option'><div>{$config['testing']}</div></td>
			<td>{$lang['testing']}
			{$h1}&amp;name=ach_testing{$h2}</td></tr>";
		
		if ($config['document_root_path']) {
			print "
		<tr><td class='option'><div>{$config['document_root_path']}</div></td>
			<td>{$lang['doc_root_path']}
			{$h1}&amp;name=ach_doc_root_path{$h2}</td></tr>";
		}
		print "
		<tr><td class='option'><div>".TB_PATH."</div></td>
			<td>{$lang['talkback_path']}
			{$h1}&amp;name=ach_talkback_path{$h2}</td></tr>
		<tr><td colspan='2'><input type='submit' value='{$lang['update_button']}' /></td></tr>
		</table>
	</form>
	
	</div>"
?>