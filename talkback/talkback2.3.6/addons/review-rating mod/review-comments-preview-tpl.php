<?php
//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Review/rating mod - Comment preview template
//	+++++++++++++++++++++++++++++++++++++++++++++++

// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

print "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" 
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title>{$lang['preview_title']}</title>";
	
require 'head-inc.php'; 
$separator = ($display['form_location'])  ? '&ndash;' : '';
$subject_line = ($config['comment_subject']) ? "<span class='tb-subject-title'>Rating: </span>" : '';
		
print "
</head> 
<body id='tb-panel'> 
<div id='tb-panel-wrapper'>

<div id='tb-panel-header'>{$lang['preview_title']}</div>

<div id='tb-wrapper'>
	<div class='tb-comment'>
		<div class='tb-comment-header'> 
			<div class='tb-author-loc'>
				<span class='tb-author'>{$display['form_author']}</span>
				$separator 
				<span class='tb-location'>{$display['form_location']}</span>
			</div>
		</div>
		$subject_line
		<script type='text/javascript'>
			var my_car=\"{$display['form_subject'][$i]}\";
			var the_length=my_car.length;
			var last_char=my_car.charAt(the_length-1);
			var rating='images/'+last_char+'star.gif';
			document.write('<IMG SRC='+rating+'>');
		</script>
		<div class='tb-comment-text'>
			{$display['form_textarea']}
		</div>
	</div>
	<br /><br />";

if ($_REQUEST['action'] == 'update') {
	require 'comments-edit-form-tpl.php';
} else {
	require COMMENTS_FORM_TPL;
}

print "
		
</div> <!--end of tb-wrapper -->

<br />
<div id='tb-panel-footer'>&nbsp;</div>

</div>
</body>
</html>
";
?>