<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	recent comments mod
	Select and print a specified number of the most recent comments 
   ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');
// Note: the below HTML is within style #tb-wrapper

print "
	<div class='tb-page'>
		<span ><strong>$legend[$pgkey]</strong></span> 
		<span class='tb-page-url'><a href='".SITE_URL."$page_url[$pgkey]'>$page_name[$pgkey]</a></span>
	</div>
	<div class='tb-comment'>
		<div class='tb-comment-header'> 
			<div class='tb-author-loc'>
				<span class='tb-author'>$author[$pgkey]</span> 
				<span class='tb-location'>$location[$pgkey]</span>
			</div>
			<div class='tb-date'>$time[$pgkey]</div> 
		</div>";
	
if ($config['comment_subject']) print "
		<div class='tb-comment-subject'><span class='tb-subject-title'>$subject_title</span> {$subject[$pgkey]}</div>";

print "
		<div class='tb-comment-text'>$text[$pgkey]</div>
	</div>";
?>