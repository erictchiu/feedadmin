<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Prints comments and displays form for new comment entry
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. 
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/

// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

// Refresh the variables in $lang
require LANGUAGE_FILE;
	
print "
<div id='tb-wrapper'>";

//	+++++++++++++++++++++++++++++++++++++++++++++++
// Print the "Leave a comment" link
//	+++++++++++++++++++++++++++++++++++++++++++++++
if ($ccount) print "
	<!-- Leave a comment link -->
	<p id='tb-comment-link'><a href='#entry'>{$lang['comdisplay6']}</a></p>"; 
	
//	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Print language selection links if there are multiple languages
//	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print "
	<!-- Language select links -->
	<p class='tb-center'>$language_links</p>";
	
// If there are comments
if ($ccount) { 
	//	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//	Print the show number of comments input field and sort order radio buttons
	//	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	if ($config['sort_order_line'] == 'always' || ($config['sort_order_line'] == 'depends' && $num_rows < $total_rows)) print "
	
	<a id='list' name='list'></a>
	<!-- Sort order line -->
	<form id='tb-sort' action='".COMMENTS_DRIVER."'  method='post'>
		$sort_order_hidden_fields
		
		<!-- Input field for number of comments to be displayed -->
		<label>{$lang['show']}</label> 
		<input class='tb-num-rows' type='text' name='numrows' value='{$num_rows}' size='4' /> 
		
		<!-- Sort order radio buttons -->
		<label>&nbsp;&nbsp;{$lang['sort']}</label> 
		<input type='radio' name='sortorder' $radio1 /><label class='tb-radio'>{$lang['order_desc']}</label>
		<input type='radio' name='sortorder' $radio2 /><label class='tb-radio'>{$lang['order_asc']} &nbsp;</label>
		
		<!-- Apply button -->
		<input class='tb-submit' type='submit' name ='customize' value ='{$lang['apply']}' onmouseout=\"this.className='tb-submit'\" onmouseover=\"this.className='tb-submit-hover'\" />
	</form>";
	
	// noscript tag
	print "<div class='tb-small tb-center'><noscript>{$lang['noscript']}</noscript></div>";
	
	//	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// Print the number of comments legend 
	//	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	if ($total_rows > 0 && $config['comments_legend']) {
		if ($total_rows > $num_rows) {
			print "
	
	<!-- Showing n-n of n comments line -->
	<div class='tb-comment-legend'>{$lang['comdisplay1']}</div>";  // "Showing n of n comments";
		} elseif ($total_rows == 1) {
			print "
		
	<div class='tb-comment-legend'>{$lang['comdisplay2']}</div>";  // "There is 1 comment";
		} else {
			print "
		
	<div class='tb-comment-legend'>{$lang['comdisplay2a']}</div>";  // "Showing n of n comments";
		}
	}
	
	//	+++++++++++++++++++++++++++++++++++++++++++++++
	//	For each comment print the comments
	//	+++++++++++++++++++++++++++++++++++++++++++++++
	for($i=0; $i<$ccount; $i++) {
		
		print "
		
	<div id='ID-$tbid[$i]' $comment_type_class[$i]>
		<div class='tb-reply-legend'>$reply_legend[$i] $original_author[$i]</div>
		<div class='tb-outer-box'>
			<div class='tb-inner-box'>
				<!-- <div class='$subject_class[$i]'><span class='$subject_title_class[$i]'>$subject_title[$i]</span> {$subject[$i]}</div> -->
				<div class='$comment_class[$i]'>$text[$i]</div>
			</div>
			<div class='$header_class[$i]'> 
				<div class='$author_loc_class[$i]'>
					&nbsp;by <span class='$author_class[$i]'>$author[$i]</span> 
					<span class='$location_class[$i]'>$location[$i]</span>
				</div>
				<div class='$date_class[$i]'>$time[$i]</div> 
			</div>
		</div>
		<div class='tb-comment-footer'>
			$replyto_link[$i] $edit_link[$i] $spam_link[$i] $delete_link[$i]
		</div>
	</div>";
	}
	
	//	+++++++++++++++++++++++++++++++++++++++++++++++
	//	Print previous/next and first/last page buttons
	//	+++++++++++++++++++++++++++++++++++++++++++++++
	if ($prev_link || $next_link) {	
		print "
		
		<!-- Prior/next page links -->
		<form id='tb-prev-next' action='{$_REQUEST['page']}#list'  method='post'>
			$priornext_hidden_fields
			";
				
		if ($prev_link) print "
			<input class='tb-first' type='submit' name='first' value='{$lang['first_link']}'  onmouseout=\"this.className='tb-first'\" onmouseover=\"this.className='tb-first-hover'\" /> 
			<input class='tb-prev' type='submit' name='prev' value='{$lang['prev_link']}'  onmouseout=\"this.className='tb-prev'\" onmouseover=\"this.className='tb-prev-hover'\" />";

		if ($next_link) print "
			<input class='tb-next' type='submit' name='next' value='{$lang['next_link']}'  onmouseout=\"this.className='tb-next'\" onmouseover=\"this.className='tb-next-hover'\" />
			<input class='tb-last' type='submit' name='last' value='{$lang['last_link']}'  onmouseout=\"this.className='tb-last'\" onmouseover=\"this.className='tb-last-hover'\" />";
		
		print "
		
	</form>";
	}
} else {
	// There are no comments
	print "
	
		<p class='tb-comment-legend'>{$lang['comdisplay3']}</p>";  // "There are no comments yet"
} // end of comments printing

print "<a name='entry'></a>";

//	+++++++++++++++++++++++++++++++++++++++++++++++
//	Print the comments entry form
//	+++++++++++++++++++++++++++++++++++++++++++++++
// Note: "$tb_closed" is set by you in your page that initiates comments.php
if (!$tb_closed) {
	// Comments are not closed
	print "
	
	<div class='tb-leave-comment-legend'>{$lang['comform1']}</div>";  // "Leave a comment";
	require COMMENTS_FORM_TPL;
} else {
	// Comments are closed
	print "
	
	<p class='tb-closed-legend'>{$lang['comdisplay4']}</p>"; // "Comments are closed";
}

print "

</div> <!--end of tb-wrapper -->";
?>