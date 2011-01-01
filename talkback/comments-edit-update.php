<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Updates the database with the results of comments-edit
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

$_REQUEST = mysql_escape_array($_REQUEST);

if ($_REQUEST['form_replyto'] == 0 || $_REQUEST['form_replyto'] == '') 
	$_REQUEST['form_replyto'] = $_REQUEST['form_id'];

$month    = substr($_REQUEST['form_date'],0,2);
$day      = substr($_REQUEST['form_date'],3,2);
$year     = substr($_REQUEST['form_date'],6,4);
$hour     = substr($_REQUEST['form_time'],0,2);
$minutes  = substr($_REQUEST['form_time'],3,2);
$seconds  = substr($_REQUEST['form_time'],6,2);
$time     = mktime($hour, $minutes, $seconds, $month, $day, $year);

$result = mysql_query("UPDATE " . DBPREFIX . "data SET time='$time', href='{$_REQUEST['form_page']}', text='{$_REQUEST['form_textarea']}', author='{$_REQUEST['form_author']}', email='{$_REQUEST['form_email']}', website='{$_REQUEST['form_website']}',  replyto='{$_REQUEST['form_replyto']}', location='{$_REQUEST['form_location']}', subject='{$_REQUEST['form_subject']}' WHERE id='{$_REQUEST['form_id']}' LIMIT 1", $dblink);
if (!$result) fatal_error(0, 0, "DB query error, comments-edit-update <br /> mysql error:<br />" . mysql_error());

// Force redisplay of the same page
$start_page = redisplay_same_page();
?>