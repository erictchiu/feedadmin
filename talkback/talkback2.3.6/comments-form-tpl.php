<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Comment form template - used in comments-display-tpl.php. comments-reply-tpl.php, comment-comments-preview.php
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

// Create the help links
$h1 = "<a href='" .TB_PATH. "comments-help.php?";
$h2 = "&amp;language={$_REQUEST['language']}&amp;keepThis=true&amp;TB_iframe=true' title='' class='thickbox help'>?</a>";
$help1 = "{$h1}height=250&amp;width=500&amp;name=cfh_remember_me{$h2}";
$help2 = "{$h1}height=250&amp;width=500&amp;name=cfh_subscribe1{$h2}";
$help3 = "{$h1}height=250&amp;width=500&amp;name=cfh_subscribe2{$h2}";
$help4 = "{$h1}height=500&amp;width=520&amp;name=cfh_buttons{$h2}";

print "	
<a name='form'></a>
<!-- The comment entry form -->
<div id='tb-form-div'> 
	<form id='tb_form' name='tb_form' action='".COMMENTS_DRIVER."'  method='post' onsubmit='return validateForm(this.form)'>
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
		$help1<br />"; 

	if ($config['comments_subscribe']) 
		print "
		<!-- Comment subscription radio buttons -->
		<div id='tb-subscribe-line'>
			<label class='tb-label'>{$lang['form_subscribe_4']}</label> 
			<input type='radio' name='form_subscribe' value='' $subscribed3_check /> <label class='tb-label'>{$lang['form_subscribe_3']}</label> 
			<input type='radio' name='form_subscribe' value='1' $subscribed1_check /> <label class='tb-label'>{$lang['form_subscribe_1']}</label> 
			$help2
			<input type='radio' name='form_subscribe' value='2' $subscribed2_check /> <label class='tb-label'>{$lang['form_subscribe_2']}</label> 
			$help3
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
		<!-- Comment subject --> 
		<div class='tb-form-subject'>
			<label class='tb-label'>{$lang['comform16']}</label>
			<input class='tb-subject-field' type='text' name='form_subject' value='{$_REQUEST['form_subject']}'  maxlength='128' />
		</div>";

	print "
		<!-- Comment text area --> 
		<textarea cols='1' rows='1' name='form_textarea' id='tbcanvas'>{$_REQUEST['form_textarea']}</textarea><br />
	
		<!-- HTML quick tags javascript -->
		<script type='text/javascript'>var edCanvas = document.getElementById('tbcanvas');</script>";
		
	if ($config['captcha']) {
		require 'captcha.php';
	}
	print "

		<!-- Submit and Preview buttons--> 
		<div id='tb-form-submit-line'>
			<div id='tb-admin-options'>
				$admin_reply_options
			</div>
			<input class='tb-submit' type='submit' name='add' value='{$lang['submit']}' onmouseout=\"this.className='tb-submit'\" onmouseover=\"this.className='tb-submit-hover'\" /> 
			<input class='tb-submit' type='submit' name='preview' value='{$lang['preview']}' onmouseout=\"this.className='tb-submit'\" onmouseover=\"this.className='tb-submit-hover'\"  />

			<label>$comment_size</label>
			<div id='waitgif' style='display:none'><img src='" .TB_PATH. "images/wait_animation.gif' alt='' /></div> <!-- jscript animated image, don't remove -->
		</div>
	</form>
	<div id='tb-error'>&nbsp;</div> <!-- for jscript validation errors, don't remove -->
</div> <!-- end of commentForm -->

<div class='tb-credit'>{$lang['powered_by1']}</div>
<!-- version {$config['version']} Release date {$config['release_date']} -->
<!-- This is a hidden div, don't change or remove it -->
<div id='tb-link-target'>{$config['comments_link_target']}</div>";
?>