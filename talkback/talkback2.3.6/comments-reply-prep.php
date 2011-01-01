<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The driver script for displaying the "reply to" template
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

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Get and format the comment that is being replied to
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$replyto_id = mysql_real_escape_string($_REQUEST['form_replyto']);

$result = mysql_query("SELECT ID, time, text, author, email, website, replyto, location, subject FROM " . DBPREFIX . "data WHERE ID ='$replyto_id' LIMIT 1", $dblink);
if (!$result) fatal_error(0, 0, 'DB query error, comments-reply-prep 1<br /> mysql error:<br />' . mysql_error());

$tbid=$time=$text=$author=$email=$website=$replyto=$location=$subject=array();
list($tbid[0], $time[0], $text[0], $author[0], $email[0], $website[0], $replyto[0], $location[0], $subject[0])=mysql_fetch_array($result);

// +++++ Format the comment +++++
$reply_legend[0]        = '';
$original_author[0]     = '';
$comment_type_class[0]  = "class='tb-comment'";
$header_class[0]        = 'tb-comment-header';
$author_loc_class[0]    = 'tb-author-loc';
$author_class[0]        = 'tb-author';
$location_class[0]      = 'tb-location';
$date_class[0]          = 'tb-date';
$tbid_class[0]            = 'tb-id';
$comment_class[0]       = 'tb-comment-text';
$time[0]                = ucwords(strftime($config['comments_date'], $time[0])); 

if ($replyto[0] != $tbid[0]) $_REQUEST['form_replyto'] = $replyto[0];

// Setup the comment entry form
$comment_form_hidden_fields = "<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
			<input type='hidden' name='article_url' value='{$_REQUEST['article_url']}' /> 
			<input type='hidden' name='reply' value='{$_REQUEST['reply']}' /> 
			<input type='hidden' name='edit' value='{$_REQUEST['edit']}' /> 
			<input type='hidden' name='sortorder' value='{$_REQUEST['sortorder']}' />
			<input type='hidden' name='rowstart' value='{$_REQUEST['rowstart']}' />
			<input type='hidden' name='rowend' value='{$_REQUEST['rowend']}' />
			<input type='hidden' name='numrows' value='{$_REQUEST['numrows']}'  /> 
			<input type='hidden' name='language' value='{$_REQUEST['language']}' />";
			
$_REQUEST['form_author']    = $cookie['author_name'];
$_REQUEST['form_email']     = $cookie['author_email'];
$_REQUEST['form_website']   = $cookie['author_website'];
$_REQUEST['form_location']  = $cookie['author_location'];
$_REQUEST['form_subject']   = ($subject[0]) ? 'Re: '.$subject[0] : '';
$_REQUEST['form_textarea']  = '';
$comment_size               = '';

$subscribed1_check          = ($_REQUEST['form_subscribe'] == 1)  ? "checked='checked'" : '';
$subscribed2_check          = ($_REQUEST['form_subscribe'] == 2)  ? "checked='checked'" : '';
$rememberme_check           = ($cookie['rememberme'])             ? "checked='checked'" : '';

if (get_admin_cookie() && $_REQUEST['reply']) {
	$h1 = "<a href" .TB_PATH. "comments-help.php?";
	$h2 = "&amp;language={$_REQUEST['language']}&amp;keepThis=true&amp;TB_iframe=true' title='' class='thickbox  help'>?</a>";
	$help = "{$h1}height=500&amp;width=520&amp;name=cfh_admin_reply{$h2}";
	$admin_reply_options = "
						{$lang['form_admin_reply1']} 
						<input name='adminreply' type='radio' value='page' checked='checked' /> {$lang['form_admin_reply2']}
						<input name='adminreply' type='radio' value='email' /> {$lang['form_admin_reply4']}
						<input name='adminreply' type='radio' value='both' />  {$lang['form_admin_reply3']} $help";
}
$query = ($user_lang) ? "?language=$user_lang" : '';
?>