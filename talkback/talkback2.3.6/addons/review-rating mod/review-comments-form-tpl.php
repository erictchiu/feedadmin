<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Review/rating mod
	Comment form template
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/

// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

$h1 = "<a href" .TB_PATH. "comments-help.php?";
$h2 = "&amp;language={$_REQUEST['language']}&amp;keepThis=true&amp;TB_iframe=true' title='' class='thickbox  help'>?</a>";

print "
	<!-- The comment entry form -->
	<div id='tb-form-div'> 
		<form id='tb_form' name='tb_form' action='".COMMENTS_DRIVER."'  method='post'>
			<input type='hidden' name='action' value='add' /> 
			<input type='hidden' name='form_replyto' value=\"{$_REQUEST['form_replyto']}\" />
			$comment_form_hidden_fields
				
			<!-- Name field -->
			<input class='tb-field' type='text' name='form_author' value=\"{$_REQUEST['form_author']}\" />
			<label class='tb-required'>*</label>
			<label class='tb-label'>{$lang['comform3']}</label><br />
			
			<!-- Email field -->
	 		<input class='tb-field' type='text' name='form_email' value =\"{$_REQUEST['form_email']}\" />
			<label class='tb-required'>*</label>
			<label class='tb-label'>{$lang['comform4']}</label><br />";
				
		if ($config['author_website']) 
			print "
			<!-- Website field -->
			<input class='tb-field' type='text' name='form_website' value=\"{$_REQUEST['form_website']}\" /> 
			<label class='tb-label'>{$lang['comform5']}</label><br />";
			
		if ($config['author_location']) 
			print "
			<!-- Location field -->
			<input class='tb-field' type='text' name='form_location' value='{$_REQUEST['form_location']}' /> 
			<label class='tb-label'>{$lang['comform15']}</label><br />";
				
			print "
			<!-- Remember me checkbox --> 
			<input type='checkbox' name='form_rememberme' value='1' $rememberme_check /> <label class='tb-label'>{$lang['comform7']}</label>
			{$h1}height=250&amp;width=500&amp;name=cfh_remember_me{$h2}<br /> ";

		if ($config['comments_subscribe']) 
			print "
			<!-- Comment subscription radio buttons -->
			<div id='tb-subscribe-line'>
				<input type='radio' name='form_subscribe' value='1' $subscribed1_check /><label class='tb-label'>{$lang['form_subscribe_1']}</label> 
				{$h1}height=250&amp;width=500&amp;name=cfh_subscribe1{$h2}
				<input type='radio' name='form_subscribe2' value='2' $subscribed2_check /><label class='tb-label'>{$lang['form_subscribe_2']}</label> 
				{$h1}height=250&amp;width=500&amp;name=cfh_subscribe2{$h2}
			</div>
";
				
		require 'comments-display-quick-tags.php';
	
		if ($config['comments_emoticons']) {
			print "
			<!-- Inserts emoticon icon buttons -->";
			require_once 'includes/emoticon-insert-inc.php';
		}
	
		if ($config['comment_subject']) 
			print "
			How many stars do you give this product: 
			<select size='1' name='form_subject'>
				<option value='5'> 5 </option>
				<option value='4'> 4 </option>
				<option value='3'> 3 </option>
				<option value='2'> 2 </option>
				<option value='1'> 1 </option>
				<option value='' selected='selected'></option>
			</select>";
	
		print "
			<!-- Comment text area --> 
			<textarea cols='1' rows='1' name='form_textarea' id='tbcanvas'>{$_REQUEST['form_textarea']}</textarea><br />
		
			<!-- HTML quick tags javascript -->
			<script type='text/javascript'>var edCanvas = document.getElementById('tbcanvas');</script>";

		print "

			<!-- Submit and Preview buttons--> 
			<div id='tb-form-submit-line'>
				<div id='tb-admin-options'>
					$admin_reply_options
				</div>
				<input class='tb-submit' type='submit' name='add' value='{$lang['submit']}' /> 
				<input class='tb-submit' type='submit' name='preview' value='{$lang['preview']}' /> 
				<label>$comment_size</label>
			</div>
		</form>
		<div id='tb-error'></div> <!-- for jscript validation errors, don't remove -->
	</div> <!-- end of commentForm -->
	
	<div class='tb-credit'>{$lang['powered_by1'] } </div>
	<!-- version {$config['version']} -->
	<!-- This is a hidden div, don't change or remove it -->
	<div id='tb-link-target'>{$config['comments_link_target']}</div>";
?>