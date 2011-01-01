<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Review/rating mod - Prints comment reply form
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/

// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

print "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" 
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title>{$lang['reply_title']}</title>";
	
$path = TB_PATH;
require 'head-inc.php'; 
	
$separator = ($location[0]) ? '&ndash;' : ''; // if location is not 0 put a dash between author name and location
$subject_line = ($config['comment_subject']) ? "<span class='tb-subject-title'>Rating: </span>" : '';

print "
</head> 
<body id='tb-panel'> 
<div id='tb-panel-wrapper'>

<div id='tb-panel-header'>{$lang['reply_title']}</div>";

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Print the comment being replied to
//	+++++++++++++++++++++++++++++++++++++++++++++++

print "

<div id='tb-wrapper'>
	<div id='ID-$tbid[0]' $comment_type_class[0]>
		<div class='$header_class[0]'> 
			<div class='$author_loc_class[0]'>
				<span class='$author_class[0]'>$author[0]</span> 
				$separator 
				<span class='$location_class[0]'>$location[0]</span>
			</div>
			<!-- <div class='$tbid_class[0]'> &nbsp;| #$tbid[0]</div>  -->
			<div class='$date_class[0]'>$time[0]</div> 
		</div>
		$subject_line 
		<script type='text/javascript'>
			var my_car=\"$subject[0]\";
			var the_length=my_car.length;
			var last_char=my_car.charAt(the_length-1);
			var rating='images/'+last_char+'star.gif';
			document.write('<IMG SRC='+rating+'>');
		</script>
		<div class='tb-comment-text'>$text[0]</div>
	</div>";

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Print the comments entry form
//	+++++++++++++++++++++++++++++++++++++++++++++++
print "

	<p class='tb-stress'>{$lang['reply_panel_legend']} {$author[0]}</p>";
	require COMMENTS_FORM_TPL;
print "

</div> <!--end of tb-wrapper -->
<br />
<div id='tb-panel-footer'>&nbsp;</div>
</div>
</body>
</html>
";
?>