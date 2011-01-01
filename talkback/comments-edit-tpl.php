<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Prints comment edit page
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

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Print the formatted comment
//	+++++++++++++++++++++++++++++++++++++++++++++++w
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php
// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

print "
	<title>{$lang['edit_title']}</title> 	
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='Content-Style-Type' content='text/css' />";
	
$path = TB_PATH;
require 'head-inc.php'; 

print "
</head> 
<body id='tb-panel'> 
<div id='tb-panel-wrapper'>

<div id='tb-panel-header'>{$lang['edit_title']}</div>";

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Print the comment being edited
//	+++++++++++++++++++++++++++++++++++++++++++++++

$separator = ($location[0] != '') ? '&ndash;' : '';
print "

<div id='tb-wrapper'>
	<div id='ID-$tbid[0]' $comment_type_class[0]>
		<div class='tb-reply-legend'>$reply_legend[0] $original_author[0]</div>
		<div class='$header_class[0]'> 
			<div class='$author_loc_class[0]'>
				<span class='$author_class[0]'>$author[0]</span> 
				$separator 
				<span class='$location_class[0]'>$location[0]</span>
			</div>
			<!-- <div class='$tbid_class[0]'> &nbsp;| #$tbid[0]</div>  -->
			<div class='$date_class[0]'>$comment_time[0]</div> 
		</div>";
		
		if ($config['comment_subject'])
			// Show subject line
			print "
		<div class='tb-comment-subject'><span class='tb-subject-title'>{$lang['subject']}</span> $subject[0]</div>";
			
		print "
		<div class='tb-comment-text'>$text[0]</div>
	</div>
	<br /><br />
";

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Print the comments entry form
//	+++++++++++++++++++++++++++++++++++++++++++++++

require 'comments-edit-form-tpl.php';

print "

</div> <!--end of tb-wrapper -->
<br />
<div id='tb-panel-footer'>&nbsp;</div>
</div>
</body>
</html>
";
?>