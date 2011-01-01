<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The driver script for displaying the edit comment template
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
$admin = get_admin_cookie();
if (!$admin) exit('You are not logged in as administrator');

$edit_id = mysql_real_escape_string($_REQUEST['edit_id']);

if ($_REQUEST['delete']) {
	delete_row('data', $edit_id, $_REQUEST['page']);
	$start_page = redisplay_same_page();
	return;
}

$result = mysql_query("SELECT ID, time, href, text, author, email, website, replyto, location, subject FROM " . DBPREFIX . "data WHERE ID ='$edit_id' LIMIT 1", $dblink);
if (!$result) fatal_error(0, 0, "DB query error, comments-edit-prep 1 <br /> mysql error:<br />" . mysql_error());

$tbid=$time=$href=$text=$author=$email=$website=$replyto=$location=$subject=array();
list($tbid[0], $time[0], $href[0], $text[0], $author[0], $email[0], $website[0], $replyto[0], $location[0], $subject[0])=mysql_fetch_array($result);

// +++++ Format the comment +++++
$comment_type_class[0]  = "class='tb-comment' ";
$header_class[0]        = 'tb-comment-header';
$author_loc_class[0]    = 'tb-author-loc';
$author_class[0]        = 'tb-author';
$location_class[0]      = 'tb-location';
$date_class[0]          = 'tb-date';
$tbid_class[0]            = 'tb-id';
$comment_class[0]       = 'tb-comment-text';
$comment_time[0]        = ucwords(strftime($config['comments_date'], $time[0]));
 
if ($replyto[0] == $tbid[0]) {
	$_REQUEST['form_replyto'] = '';
} else {
	$_REQUEST['form_replyto'] = $replyto[0];
}

// Comment entry form fields
$_REQUEST['form_textarea']  = str_replace("<p>","", $text[0]);
$_REQUEST['form_textarea']  = str_replace("</p>","\n", $_REQUEST['form_textarea']);
$_REQUEST['form_id']        = $tbid[0];
$_REQUEST['form_page']      = $href[0];
$_REQUEST['form_author']    = $author[0];
$_REQUEST['form_email']     = $email[0];
$_REQUEST['form_website']   = $website[0];
$_REQUEST['form_location']  = $location[0];
$_REQUEST['form_subject']   = $subject[0];
$_REQUEST['form_date']      = date('m.d.Y', $time[0]);
$_REQUEST['form_time']      = date('H:i:s', $time[0]);
if (!$_REQUEST['form_website']) $_REQUEST['form_website'] = 'http://';

if ($config['comment_size']) {
	$size          = strlen($_REQUEST['form_textarea']);
	$comment_size  = "{$lang['comform13']} $size - {$lang['comform14']} {$config['comment_size']}";
} else {
	$comment_size  = '';
}
?>