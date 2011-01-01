<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Prints comment preview form
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

// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Setup comment entry form
//	+++++++++++++++++++++++++++++++++++++++++++++++
if ($config['comment_size']) {
	$size = strlen($raw['form_textarea']);
	$comment_size = "{$lang['comform13']} $size - {$lang['comform14']} {$config['comment_size']}";
}

$comment_form_hidden_fields = "<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
		<input type='hidden' name='article_url' value='{$_REQUEST['article_url']}' /> 
		<input type='hidden' name='reply' value='{$_REQUEST['reply']}' /> 
		<input type='hidden' name='edit' value='{$_REQUEST['edit']}' /> 
		<input type='hidden' name='sortorder' value='{$_REQUEST['sortorder']}' />
		<input type='hidden' name='rowstart' value='{$_REQUEST['rowstart']}' />
		<input type='hidden' name='rowend' value='{$_REQUEST['rowend']}' />
		<input type='hidden' name='numrows' value='{$_REQUEST['numrows']}'  /> 
		<input type='hidden' name='language' value='{$_REQUEST['language']}' />
		<input type='hidden' name='article_title' value='{$_REQUEST['article_title']}' />";

if ($_REQUEST['form_replyto'] == 0) $_REQUEST['form_replyto'] = '';

$display['form_author']    = $_REQUEST['form_author'];
$display['form_email']     = $_REQUEST['form_email'];
$display['form_website']   = $_REQUEST['form_website'];
$display['form_location']  = $_REQUEST['form_location'];
$display['form_subject']   = $_REQUEST['form_subject'];
$display['form_textarea']  = format_comment_text($_REQUEST['form_textarea']);

$_REQUEST['form_author']    = $raw['form_author'];
$_REQUEST['form_email']     = $raw['form_email'];
$_REQUEST['form_website']   = ($raw['form_website']) ? $raw['form_website'] : 'http://';
$_REQUEST['form_location']  = $raw['form_location'];
$_REQUEST['form_subject']   = $raw['form_subject'];
$_REQUEST['form_textarea']  = $raw['form_textarea'];

$subscribed1_check          = ($_REQUEST['form_subscribe'] == 1)  ? "checked='checked'" : '';
$subscribed2_check          = ($_REQUEST['form_subscribe'] == 2)  ? "checked='checked'" : '';
$rememberme_check           = ($cookie['rememberme'])             ? "checked='checked'" : '';
	
if (get_admin_cookie() && $_REQUEST['reply']) {
	$pageischecked  = "''";
	$emailischecked = "''";
	$bothischecked  = "''";
	if ($_REQUEST['adminreply'] == 'page') $pageischecked = "checked='checked'";
	if ($_REQUEST['adminreply'] == 'email') $emailischecked = "checked='checked'";
	if ($_REQUEST['adminreply'] == 'both') $bothischecked = "checked='checked'";
		
	$admin_reply_options = "<div id='admin-reply_options'>
						{$lang['form_admin_reply1']} 
						<input name='adminreply' type='radio' value='page'  $pageischecked /> {$lang['form_admin_reply2']}
						<input name='adminreply' type='radio' value='email' $emailischecked /> {$lang['form_admin_reply4']}
						<input name='adminreply' type='radio' value='both'  $bothischecked/>  {$lang['form_admin_reply3']}
					</div>";
}
?>