<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Prints comment edit form
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

print "
	<div id='tb-form-div'> 
		<form id='tb-form-edit' action='".COMMENTS_DRIVER."'  method='post' onsubmit='return validateForm(this.form)'>
			<input type='hidden' name='action' value='update' /> 
			<input type='hidden' name='form_id' value='{$_REQUEST['form_id']}' /> 
			<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
			<input type='hidden' name='article_url' value='{$_REQUEST['article_url']}' /> 
			<input type='hidden' name='reply' value='{$_REQUEST['reply']}' /> 
			<input type='hidden' name='edit' value='{$_REQUEST['edit']}' /> 
			<input type='hidden' name='sortorder' value='{$_REQUEST['sortorder']}' />
			<input type='hidden' name='rowstart' value='{$_REQUEST['rowstart']}' />
			<input type='hidden' name='rowend' value='{$_REQUEST['rowend']}' />
			<input type='hidden' name='numrows' value='{$_REQUEST['numrows']}'  /> 
			<input type='hidden' name='language' value='{$_REQUEST['language']}'  /> 
			
			<!-- Comment id -->
			{$lang['comform17']} {$tbid[0]}<br />
			
			<!-- Reply to field -->
			<label class='tb-label'>{$lang['comform9']}</label>
			<input class='tb-field-reply' type='text' name='form_replyto' value=\"{$_REQUEST['form_replyto']}\" size='4' maxlength='11' />
			<label class='tb-label'>{$lang['comform9a']}</label><br />
			
			<!-- Page field -->
			<input class='field' type='text' name='form_page' value=\"{$_REQUEST['form_page']}\" />
			<label class='tb-label'>{$lang['comform12e']}</label>
			<label class='tb-required'>*</label> <br />
			
			<!-- Date field -->
			<input class='field' type='text' name='form_date' value=\"{$_REQUEST['form_date']}\" />
			<label class='tb-label'>{$lang['comform10e']}</label>
			<label class='tb-required'>*</label> <br />
			
			<!-- Time field -->
			<input class='field' type='text' name='form_time' value=\"{$_REQUEST['form_time']}\" />
			<label class='tb-label'>{$lang['comform11e']}</label>
			<label class='tb-required'>*</label> <br />
			
			<!-- Name field -->
			<input class='field' type='text' name='form_author' value=\"{$_REQUEST['form_author']}\" />
			<label class='tb-label'>{$lang['comform3e']}</label>
			<label class='tb-required'>*</label> <br />
			
			<!-- Email field -->
	 		<input class='field' type='text' name='form_email' value =\"{$_REQUEST['form_email']}\" />
			<label class='tb-label'>{$lang['comform4e']}</label>
			<label class='tb-required'>*</label> <br />";
				
		if ($config['author_website']) 
			print "
			<!-- Website field -->
			<input class='field' type='text' name='form_website' value=\"{$_REQUEST['form_website']}\" /> 
			<label class='tb-label'>{$lang['comform5e']}</label><br />";
			
		if ($config['author_location']) 
			print "
			<!-- Location field -->
			<input class='field' type='text' name='form_location' value=\"{$_REQUEST['form_location']}\"  /> 
			<label class='tb-label'>{$lang['comform15e']}</label><br />";
				
		require 'comments-display-quick-tags.php';
		
		print "
			
			<!-- Comment subject --> 
			<label class='tb-label'>{$lang['comform16']}</label>
			<input class='tb-subject-field' type='text' name='form_subject' value=\"{$_REQUEST['form_subject']}\"  maxlength='128' />
			
			<!-- Comment text area --> 
			<textarea cols='1' rows='1' name='form_textarea' id='tbcanvas'>{$_REQUEST['form_textarea']}</textarea><br />
			
			<!-- HTML quick tags javascript -->
			<script type='text/javascript'>var edCanvas = document.getElementById('tbcanvas');</script>";
	
	print "

			<!-- Submit and Preview buttons--> 
			<div id='tb-form-submit-line'>
				<input class='tb-submit' type='submit' name='update' value='{$lang['submit']}' />
				<input class='tb-submit' type='submit' name='preview' value='{$lang['preview']}' />
				<label>$comment_size</label>
			</div>
		</form> 
	</div> <!-- end of commentForm -->
	<div id='tb-link-target'>{$config['comments_link_target']}</div> <!-- This is a hidden div used by javascript, don't change or remove it -->
";
?>