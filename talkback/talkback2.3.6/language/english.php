<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Primary English Language file
	Last modified for version 2.3.5
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');
	$lang_iso_code = 'en'; // two character IISO 639-1 code http://www.loc.gov/standards/iso639-2/php/English_list.php

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 QUICK TAG BUTTON LABELS
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['ed_bold'] = 'b';         // <b> bold text
$lang['ed_italic'] = 'i';       // <i> italic text
$lang['ed_under'] = 'u';        // <u> underline
$lang['ed_strike'] = 's';       // <s> strike through
$lang['ed_link'] = 'link';      // <a> tag
$lang['ed_block'] = 'quote';    // <blockquote> blockquote tag
$lang['ed_code'] = 'code';      // <code> code tag
$lang['ed_pre'] = 'pre';        // <pre> performatted text
$lang['ed_big'] = 'big';        // <big> large text
$lang['ed_small'] = 'small';    // <small> small text
$lang['ed_center'] = 'ctr';     // <center> center text
$lang['ed_font'] = 'font';      // <font> font tag
$lang['ed_img'] = 'img';        // <img> image tag
$lang['ed_lt'] = '<';           // less than or left bracket
$lang['ed_gt'] = '>';           // greter than or right bracket
$lang['ed_ul'] = 'ul';          // <ul> unordered list
$lang['ed_ol'] = 'ol';          // <ol> ordered list
$lang['ed_li'] = 'li';          // <li> list item
$lang['ed_hr'] = '&mdash;';     // horizontal rule
$lang['ed_lightbox'] = 'image'; // lightbox image link

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 COMMENTS TEMPLATES
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// comments-display-tpl.php
$lang['comdisplay1']  = "$first_row-$last_row of $total_rows Comments"; 
$lang['comdisplay1a'] = "$current_page of $total_pages pages";
$lang['comdisplay2']  = "There is 1 comment";
$lang['comdisplay2a'] = "There are $ccount comments";
$lang['comdisplay3']  = "There are no comments yet";
$lang['comdisplay4']  = "Comments are closed";
$lang['comdisplay5']  = "Comments are temporarily unavailable";
$lang['comdisplay6']  = "Leave a Comment";
$lang['next_link'] = "Next";
$lang['prev_link'] = "Prev";
$lang['first_link'] = ""; // intentionally empty because gif background image is used instead of a legend
$lang['last_link'] = ""; // intentionally empty because gif background image is used instead of a legend
$lang['show'] = "Show:";
$lang['sort'] = "Sort:";
$lang['order_desc'] = "Newest first";
$lang['order_asc'] = "Oldest first";
$lang['apply'] = "Apply";
$lang['reply_legend'] = "Reply to";
$lang['replyto_link'] = "Reply";
$lang['edit_link'] = "Edit";
$lang['reply_link'] = "Reply";
$lang['comment_spam_link'] = "Spam";
$lang['website_link'] = "&nbsp;&nbsp;[website]";
$lang['subject'] = "Subject:";
$lang['noscript'] = "Javacript is required for help and viewing images.";

// comments-form, comments-edit-form
$lang['comform1'] = "Leave a Comment";
$lang['comform2'] = ""; // not used
$lang['comform3'] = "Your name";
$lang['comform3e'] = "Author name";
$lang['comform4'] = "Your email address (will not be published)";
$lang['comform4e'] = "Author email";
$lang['comform5'] = "Your website";
$lang['comform5e'] = "Author website";
$lang['comform6'] = "Subscribe to followup comments"; 
$lang['comform7'] = "Remember me"; 
$lang['comform9'] = "This is a reply to comment ID"; 
$lang['comform9a'] = "(leave empty if not a reply)";
$lang['comform10e'] = "Date: MM.DD.YYYY";
$lang['comform11e'] = "Time: HH:MM:SS (24 hour format)";
$lang['comform12e'] = "Page";
$lang['comform13'] = "Comment size:";
$lang['comform14'] = "Maximum:";
$lang['comform15'] = "Your location";
$lang['comform15e'] = "Author location";
$lang['comform16'] = "Subject: ";
$lang['form_subscribe_1'] = "All comments";
$lang['form_subscribe_2'] = "Replies to my comment";
$lang['form_subscribe_3'] = "No ";
$lang['form_subscribe_4'] = "Subscribe: ";
$lang['submit'] = "Submit"; 
$lang['preview'] = "Preview"; 
$lang['powered_by1'] = "Powered by <a href='http://www.scripts.oldguy.us' title='TalkBack comments and guestbook'>TalkBack</a>"; 
$lang['form_admin_reply1'] = "Reply by:";
$lang['form_admin_reply2'] = "Comment page";
$lang['form_admin_reply3'] = "Comment page &amp; email";
$lang['form_admin_reply4'] = "email";
$lang['comform17'] = "Comment ID: ";
$lang['captcha_visual_prompt'] = "Enter the two words ";
$lang['captcha_audio_prompt'] = "Enter the numbers you hear ";
$lang['captcha_promotion'] = "<div>By typing the above words, you help to digitize old books.</div>";

// Other scripts
$lang['preview_title'] = "Comment Preview"; 
$lang['reply_title'] = "Reply to Comment"; 
$lang['edit_title'] = "Edit Comment"; 
$lang['db_error'] = "<p class='tb-center tb-stress'>Comments for this page are temporarily unavailable</p>"; 
$lang['reply_panel_legend'] = "Reply to the comment by"; 

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 SEARCH
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['csh_help'] = "<p class='title'>Using Search</p>
<p><code>\"support forum\"</code> will find all comments that contain the exact phrase <em>support forum</em>.</p>
<p><code>support forum</code> Will find all comments that contain the word <em>support</em> <b>or</b> the word <em>forum</em>.</p>
<p><code>+support +forum</code> Will find all comments that contain the word <em>support</em> <b>and</b> the word <em>forum</em>.</p>
<p><code>-support forum</code> Will find all comments that contain the word <em>forum</em> and which do <b>not</b> contain the word <em>support</em>.</p>
<p>The comparison is made against full words. The search term <em>forum</em>, for example, will not match <em>forums</em>.</p>";
$lang['invalid_search1'] = "is not a valid search term, a phrase (words between quotes) must not occur with other words";
$lang['invalid_search2'] = "is not a valid search term, more than two quote characters";
$lang['search'] = "Search";
$lang['search_author'] = "Author:";
$lang['search_date'] = "Date:";
$lang['search_subject'] = "Subject:";
$lang['search_legend'] = " Comments found for ";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 EMAIL NOTIFICATION MESSAGES
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['email_from'] = "Comments ";  // the name that precedes email address in the email header From line
$lang['fatal_error'] = "TalkBack encountered a fatal error";

// New comment notice to administrator
$lang['email_nc_subject1'] = "New comment on";  // the email header Subject line - site is appended
$lang['email_nc_subject2'] = "New SPAM comments on"; // the email header Subject line - site is appended
$lang['email_nc_1stline1'] = "The below listed comment has been added.";  
$lang['email_nc_1stline2'] = "At least one new spam comment has been added in the last 24 hours.";  
$lang['email_nc_author'] = "Author:"; 
$lang['email_nc_website'] = "Website:"; 
$lang['email_nc_moderate'] = "It is on-hold for your approval or deletion.";
$lang['email_nc_panel_title'] = "Admin panel";
$lang['email_nc_the_page'] = "Comment page";

// Confirm subscription notice
$lang['email_cs_subject'] = "Confirm subscription";	// the email header Subject line
$lang['email_cs_text'] = "You (or somebody using your email address) subscribed to follow up comments on: {$config['site_name']}. Use the following link to complete the subscription. Do nothing if you do not want to subscribe.";
$lang['email_cs_link'] = "Confirm subscription";

// New comment notice to subscribers
$lang['email_sn_1stline'] = "You are subscribed to receive notices of follow up comments and a new comment has been added to page: "; // page url is appended
$lang['email_sn_unsubscribe'] = "If you don't want to receive emails about new comments on this page, use this link to unsubscribe: ";
$lang['email_sn-link-text'] = "Unsubscribe";

// Notice to original author of a reply
$lang['email_an_subject'] = "Reply to your comment on";
$lang['email_an_1stline'] = "A reply has been made to your comment on {$config['site_name']}:";
$lang['email_an_lastline'] = "You may see the comment at:";

// Admin sends copy of reply via email
$lang['email_admin_reply1'] = "The website administrator has replied to your comment at ";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	COMMENTS ERROR MESSAGES
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['fatal_error1'] = "There has been an error from which the program cannot recover. A message has been sent to the site administrator who will look into the problem. You can try to perform the operation again. It might have been a temporary problem and may work the second time. Or you may continue browsing other pages.";
$lang['unrecoverable_error'] = "Unrecoverable error";
$lang['browser_back'] = "Use your browser back button to return to the comment form.";
$lang['return_link_text'] = "Return";
$lang['doing-maintenance'] = "The comments system is currently being upgraded so comments are not available at the moment. I hope to have them operational soon.";

// message-panel.php, comments-help.php
$lang['msg_center_title'] = "TalkBack Comments and Guestbook Message";

// by subscriptions.php
$lang['subscriptions_title'] = "Subscriptions Validation";
$lang['unsubscribe_true'] = "You will no longer receive new comment notices for page: "; 
$lang['unsubscribe_false'] = "You were not subscribed. No action was taken."; 
$lang['subscribed'] = "Your subscription has been activated.";
$lang['invalid_confirmation'] ="It appears the data in the confirmation link that was sent to you has been altered. Unable to subscribe you.";

// comments-validate or comments-add
$lang['comments_title'] = "Comments Entry Validation";
$lang['anti_flood_msg'] = "You must wait {$config['wait_time']} seconds before posting again";
$lang['duplicate_comment'] = "This is a duplicate of a comment you previously submitted.";
$lang['name_required'] = "Name is required";
$lang['text_required'] = "Comment text cannot be empty";
$lang['text_size'] = "characters entered exceeds the {$config['comment_size']} characters maximum comment length";
$lang['email_required'] = "Email address is required";
$lang['email_invalid'] = "Invalid email adddress.";
$lang['location_invalid'] = "Location field may contain only: letters spaces numbers , .";
$lang['name_invalid']     = "Name may contain only: letters numbers spaces - ' _ . ";
$lang['subject_invalid']  = "Subject may contain only: letters numbers spaces : , . '";
$lang['date_invalid'] = "Invalid date";
$lang['time_invalid'] = "Invalid time";
$lang['page_required'] = "Page URL cannot be empty";
$lang['website_invalid'] = "Invalid website URL";
$lang['banned_error'] = "You are not allowed to post comments here";
$lang['moderation_on'] = "Thank you for your comment.<br />Your comment will appear after it has been approved.";
$lang['comment_is_spam'] = "The spam checker reports your comment is spam.<br />The comment is being held for approval by the website administrator.";
$lang['unbalanced_tags'] = "One or more HTML tags is missing an end tag or is incorrectly formatted. <br /><br />Or you have typed bracket characters in your text: &lt; or &gt;. Use the bracket button instead or type \"&amp;lt<b>;</b>\" for left bracket and \"&amp;gt<b>;</b>\" for right bracket.";
$lang['moderation_return_link'] = "Return";
$lang['already_subscribed'] = "The email address you entered is already subscribed.";
$lang['confirm_subscription'] = "An email has been sent to the address you provided. Follow the instructions in the email to activate your subscription.";
$lang['spam_discarded'] = "Your comment has been flagged as spam and has not been accepted.<br /><br />Because of ever increasing spam comments we had to make our spam filtering rules stronger. If you entered a \"real\" comment please try again with differnt wording. If you are unable to successfully enter your comment, please notify the webmaster.";
$lang['missing_tag'] = "Missing end tag:";
$lang['inv_captcha_key'] = "The reCAPTCHA public or private key is invalid";

$lang['recaptcha-result:incorrect-captcha-sol'] = "The two words are missing or were typed incorrectly. Enter the new words after using your browser back button.";
$lang['recaptcha-result:empty-response'] = "The two words are missing or were typed incorrectly. Enter the new words after using your browser back button.";
$lang['recaptcha-result:empty-challenge'] = "The two words are missing or were typed incorrectly. Enter the new words after using your browser back button.";
$lang['recaptcha-result:invalid-site-private-key'] = "The reCAPTCHA private key is invalid";
$lang['recaptcha-result:invalid-site-public-key'] = "The reCAPTCHA putlic key is invalid";
$lang['recaptcha-result:unknown'] = "reCAPTCHA sent back an unknown error code. Ask for help in the support forum. Error code is: ";
$lang['spamwords_file'] = "Spamwords checking is enabled but a spamwords file cannot be found in the TalkBack directory. The file name must be either 'my-spamwords.php' or 'spamwords.php'.";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	COMMENTS HELP PANELS (comments form help)
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['comments_help_title'] = "<strong>Comments Help</strong>";
$lang['cfh_panel_title'] = "Comment help";
$lang['cfh_remember_me'] = "<p class='title'>Remember me</p>Check the box when entering a comment if you want the system to set a cookie with your name, email address and website. Thereafter, whenever you visit this website those fields in the comments entry form will automatically be filled in.";
$lang['cfh_subscribe1'] = "<p class='title'>Subscribe to comments</p>Check this button if you want to receive email notices when comments are added to this page. 
<p>You may subscribe without entering a comment. Enter your name and email address, check this button then click Submit.</p>";
$lang['cfh_subscribe2'] = "<p class='title'>Email replies to my comment only</p>Check this button if you want to receive notices only when replies to your comment are added. </p>";
$lang['cfh_buttons'] = "<p class='title'>Formatting buttons</p>These buttons will insert formatting tags at the current cursor position in your comment.</p>
<p>You can also select text, click any tag button except Link and the text will be surrounded by the begin and end tags.</p>
<p>The tag buttons you see will depend on how the webmaster has configured the system. If you type a tag that is not allowed into a comment, it will be removed. The set of all possible tags is:</p>
<table >
	<tr style='background: #ddd'><td><b>Button<br />Label</b></td> <td><b>HTML<br />Tag</b></td> <td><b><br />Effect</b></td></tr>
	<tr><td>{$lang['ed_bold']}</td> <td>b</td> <td><b>bold text</b></td></tr>
	<tr><td>{$lang['ed_italic']}</td> <td>i</td> <td><i>italic text</i></td></tr>
	<tr><td>{$lang['ed_under']}</td> <td>u</td> <td><u>underlined text</u></td></tr>
	<tr><td>{$lang['ed_strike']}</td> <td>s</td> <td><s>strike through</s></td></tr>
	<tr><td>{$lang['ed_code']}</td> <td>code</td> <td><code>monospaced with background color</code></td></tr>
	<tr><td>{$lang['ed_pre']}</td> <td>pre</td> <td>monospaced, all spacing and line breaks preserved</td></tr>
	<tr><td>{$lang['ed_big']}</td> <td>big</td> <td><big>large text</big></td></tr>
	<tr><td>{$lang['ed_small']}</td> <td>small</td> <td><small>small text</small></td></tr>
	<tr><td>{$lang['ed_center']}</td> <td>center</td> <td>centered text</code></td></tr>
	<tr><td>{$lang['ed_block']}</td> <td>blockquote</td> <td>quoted text</td></tr>
	<tr><td>{$lang['ed_link']}</td> <td>a</td> <td>inserts a link to a web page</td></tr>
	<tr><td>{$lang['ed_img']}</td> <td>img</td> <td>inserts a link to an image on the web</td></tr>
	<tr><td>{$lang['ed_lightbox']}</td> <td>a</td> <td>inserts a link to an image on the web</td></tr>
	<tr><td>{$lang['ed_hr']}</td> <td>hr</td> <td>inserts a horizontal rule (a line)</td></tr>
	<tr><td>{$lang['ed_lt']}</td> <td>none</td> <td>inserts a left bracket</td></tr>
	<tr><td>{$lang['ed_gt']}</td> <td>none</td> <td>inserts a right bracket</td></tr>
	<tr>
		<td>
			{$lang['ed_ul']}<br />
			{$lang['ed_ol']}<br />
			{$lang['ed_li']}
		</td> 
		<td>
			ul<br />
			ol<br />
			li
		</td> 
		<td>
			inserts an unordered list tag<br />
			inserts an ordered (numbered) list tag<br />
			inserts a list item tag<br />
			Example:
			<div><code>
				&lt;ul&gt;<br />
					&nbsp;&nbsp;&lt;li&gt;first list item&lt;/li&gt;<br />
					&nbsp;&nbsp;&lt;li&gt;second list item&lt;/li&gt;<br />
				&lt;/ul&gt;</code>
			</div>
			Results in:
			<ul style='margin-top: 0'>
				<li>first list item</li>
				<li>second list item</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>{$lang['ed_font']}</td> <td>font</td> <td>Changes text size, face and color:
			<br />Size: a number from 1 through 7
			<br />Face: a font name
			<br />Color: an HTML color name or a hexidecimal color number
			<br />Examples:
			<br /><code>&lt;font size=\"2\"&gt;some text&lt;/font&gt;</code>
			<br /><font size='2'>some text</font>
			<br /><code>&lt;font face=\"times\" color=\"red\"&gt;some text&lt;/font&gt;</code>
			<br /><font face='times' color='red'>sometext</font>
		</td>
	</tr>
</table>
<table >
	<tr>
		<td colspan='2'><strong>Some font names and numbers</strong></td>
	</tr>
	<tr><td>aqua</td><td style='background:#0FF; color:#000;'>#00FFFF</td></tr>
	<tr><td>black</td><td style='background:#000; color:#FFF;'>#000000</td></tr>
	<tr><td>blue</td><td style='background:#00F; color:#FFF;'>#0000FF</td></tr>
	<tr><td>fuchsia</td><td style='background:#F0F; color:#000;'>#FF00FF</td></tr>
	<tr><td>gray</td><td style='background:#808080; color:#FFF;'>#808080</td></tr>
	<tr><td>green</td><td style='background:#008000; color:#FFF;'>#008000</td></tr>
	<tr><td>lime</td><td style='background:#0F0; color:#000;'>#00FF00</td></tr>
	<tr><td>maroon</td><td style='background:#800000; color:#FFF;'>#800000</td></tr>
	<tr><td>navy</td><td style='background:#000080; color:#FFF;'>#000080</td></tr>
	<tr><td>olive</td><td style='background:#808000; color:#FFF;'>#808000</td></tr>
	<tr><td>purple</td><td style='background:#800080; color:#FFF;'>#800080</td></tr>
	<tr><td>red</td><td style='background:#F00; color:#FFF;'>#FF0000</td></tr>
	<tr><td>silver</td><td style='background:#C0C0C0; color:#000;'>#C0C0C0</td></tr>
	<tr><td>teal</td><td style='background:#008080; color:#fff;'>#008080</td></tr>
	<tr><td>white</td><td style='background:#FFF; color:#000;'>#FFFFFF</td></tr>
	<tr><td>yellow</td><td style='background:#FF0; color:#000;'>#FFFF00</td></tr>
</table>";
$lang['cfh_admin_reply'] = "<p class='title'>Administrator Reply Options</p>If you check the button to send a copy of your reply by email, do not include any HTML formatting in the reply. This includes emoticons. HTML tags are not stripped out of the text before sending the email.</p>";

	
/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	ADMIN LOGIN PANEL
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['login_title'] = "TalkBack Admin Login";
$lang['login'] = "Login";
$lang['userid'] = "User ID";
$lang['password'] = "Password";
$lang['login-message'] = "You must have cookies enabled <br />in your browser to login to the admin panels.";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	ADMIN PANELS MESSAGES 
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['page'] = "Page: ";
$lang['nav_logout'] = "Logout";
$lang['nav_helpindex'] = "Help Index";
$lang['nav_commentsby'] = "Comments by:";
$lang['nav_banned_link'] = "Banned IP&rsquo;s";
$lang['nav_moderation_link'] = "Unapproved<br />Comments";
$lang['nav_spam_link'] = "Spam<br />Comments";
$lang['nav_subscribersby'] = "Subscribers by";
$lang['nav_subscribers_page'] = "Page";
$lang['nav_recent_link'] = "Recent<br />Comments";
$lang['nav_email_link'] = "Email";
$lang['nav_home_link'] = "Select<br />Page";
$lang['nav_page_link'] = "Comments<br />By Page";
$lang['nav_maint_link'] = "Maintenance<br />Menu";
$lang['nav_config_link'] = "Edit Configuration Settings";
$lang['nav_backup_link'] = "Backup Database";
$lang['nav_optimize_link'] = "Optimize Database";
$lang['panel_title'] = "TalkBack Administration Panel";
$lang['panel_page_title'] = "Comments List by Page";
$lang['panel_recent_title'] = "Comments For Last {$config['num_of_days']} Days";
$lang['panel_moderation_title'] = "Unapproved Comments List";
$lang['panel_spam_title'] = "Spam Comments List";
$lang['panel_banned_title'] = "Banned IP Address List";
$lang['panel_subscribers_title'] = "Subscribers List by";
$lang['panel_config_title'] = "Configuration Maintenance";
$lang['panel_home_title'] = "Select Comments Page";
$lang['panel_maint_title'] = "Maintenance Menu";
$lang['url_search_label'] = "Part of URL";
$lang['search_submit'] = "Search";
$lang['search_results'] = "Page URL&rsquo;s containing:";
$lang['no_search_results'] = "No page URL&rsquo;s contain: ";
$lang['no_comments'] = "There are no comments";
$lang['no_bannedip'] = "There are no banned IP addresses";
$lang['no_subscribers'] = "There are no subscribers";
$lang['delete_link'] = "Delete";
$lang['deletespam_link'] = "Delete All";
$lang['approve_link'] = "Approve";
$lang['spam_link'] = "Is Spam";
$lang['banip_link'] = "Ban IP";
$lang['unbanip_link'] = "Unban IP";
$lang['months'] = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$lang['spam_msg'] = "SPAM ";
$lang['max_links_msg'] = "Max links exceeded ";
$lang['admin-help-title'] = "Admin Panels Help";
$lang['moderation_msg'] = "Unapproved";
$lang['invalid_akismet_key'] = "Akismet key invalid ";
$lang['akismet_no_response'] = "Akismet connect failed ";
$lang['spamword'] = "Has spamword ";
$lang['banned'] = " - Banned";
$lang['your_comment'] = "Re: Your comment on";
$lang['spam_count'] = "Akismet spam count to date: ";
$lang['spam'] = "Spam: ";
$lang['unapproved'] = "Unapproved: ";
$lang['recent'] = "Recent: ";
$lang['admin-browser_back'] = "Use your browser back button to return to the admin panel.";
$lang['reply_label'] = "Reply to comment # ";
$lang['maint-footer'] = "Database operations may take a while. Please be patient.";
$lang['subscribed_label'] = "Subscribed";
$lang['subscribers'] = "Subscribers:";
$lang['banned1'] = "Banned:";
$lang['purge_submit'] = "Purge";
$lang['purge_days'] = " comments older than <input type='text' name='purge_days' value='' size='1' /> days";
$lang['purge_days_zero'] = "Number of days is invalid or zero.";
$lang['comments_purged'] = "Purged $rows comments older than $purge_date";
$lang['files_directory_err1'] = "The directory specified in configuration setting &ldquo;Path to backup files directory&rdquo; does not exist or is not writable.";
$lang['lightbox_err'] = "If you enable lightbox you must also include the &ldquo;a&rdquo; tag in allowed tags.";
$lang['mysqldump_err1'] = "is not a valid file. Correct the configuration setting path for mysqldump.";
$lang['mysqldump_err2'] = "The mysqldump command did not complete successfully.";
$lang['admin_date'] = "Date/time format for admin panels.";
$lang['captcha_public_err'] = " Captcha checking is enabled, a reCAPTCHA public key is required.";
$lang['captcha_private_err'] = " Captcha checking is enabled, a reCAPTCHA private key is required.";
$lang['mysqldump_directory_err'] = "The path and file name specified for &ldquo;Path to the mysqldump program&rdquo; does not exist";
$lang['logfile_err1'] = "When &ldquo;Log HTTP request errors&rdquo; is checked you must also enter a log file name.";
$lang['logfile_err2'] = "You checked &ldquo;Log HTTP request errors&rdquo; but &ldquo;Path to backup files directory&rdquo; does not exist or is not writable.";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	ADMIN CONFIGURATION PANEL
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// template file names
$lang['header_templates'] = "Template File Names";
$lang['comments_driver'] = "Comments driver script";
$lang['comments_display_tpl'] = "Comments display template";
$lang['comments_form_tpl'] = "Comment form template";
$lang['preview_panel_tpl'] = 'Comment preview panel template';
$lang['reply_panel_tpl'] = 'Comment reply panel template';
$lang['help_panel_tpl'] = 'Comments help panel template';
$lang['message_panel_tpl'] = 'Comments message panel template';

// administration settings
$lang['header_site'] = "Site Settings";
$lang['asterisk_explanation'] = "Indicates required fields";
$lang['site_name'] = "Website Name";
$lang['site_url'] = "Website URL without trailing slash";
$lang['header_admin'] = "Administration Settings";
$lang['admin_name'] = "Name you will use in your comment posts";
$lang['admin_login'] = "Administrator login user ID";
$lang['admin_password'] = "Administrator password";
$lang['admin_password2'] = "Confirm administrator password";
$lang['admin_website'] = "URL for the &ldquo;Website&rdquo; field in administrator comments"; 
$lang['email_from'] = "The &ldquo;From&rdquo; address for email notices";
$lang['time_offset'] = "Server time difference";
$lang['server_time'] = "(server time)";
$lang['corrected_time'] = "(corrected time)";
$lang['date_locale'] = "Date locale language code";
$lang['admin_notices'] = "Suppress admin notices for new, non-spam comments:";
$lang['admin_notices_0'] = "No suppression: send an email notice for each comment";
$lang['admin_notices_1'] = "Send one notice, then suppress additional notices until you visit the admin panels";
$lang['admin_notices_2'] = "Suppress all new comment email notices";
$lang['admin_notices_suppressed'] = "Indicates whether or not admin new comment email notices are currently suppressed";
$lang['admin_cookie'] = "Admin cookie:";
$lang['admin_cookie_N'] = "Temporary";
$lang['admin_cookie_Y'] = "Permanent";
$lang['user_agent_days'] = "Number of days to keep the comment&rsquo;s user agent string on file";
$lang['files_directory'] = "Path to backup files directory with trailing slash";
$lang['mysqldump_path'] = "Path to the mysqldump program";

// comment settings
$lang['header_general'] = "Comments Settings";
$lang['maintenance'] ="Maintenance mode:";
$lang['maintenance_N'] = "System is operational.";
$lang['maintenance_Y'] = "System is in maintenance mode.";
$lang['comments_date'] = "Date/time format for comments template.";
$lang['wait_time'] = "Wait time in seconds before user can post again";
$lang['num_of_days'] = "Number of days to include on admin recent comments list";
$lang['allowed_tags'] = "Allowed HTML tags.";
$lang['page_limit'] = "Number of comments to print on a page";
$lang['comment_size'] = "Maximum number of characters in a comment";
$lang['comments_link_target'] = "Open links in new window:";
$lang['comments_link_target_N'] = "No";
$lang['comments_link_target_Y'] = "Yes";
$lang['sort_order_line'] = "Show sort order line:";
$lang['sort_order_line_ALWAYS'] = "Always";
$lang['sort_order_line_NEVER'] = "Never";
$lang['sort_order_line_DEPENDS'] = "If multiple pages";
$lang['comments_legend'] = "Show comments legend:";
$lang['comments_legend_N'] = "No";
$lang['comments_legend_Y'] = "Yes";
$lang['emoticon_error'] = "You have set emoticons to show in comment posts but allowed tags does not contain the &lt;img&gt; tag. Add '&lt;img&gt;' to allowed tags.";
$lang['bad_words'] = "Bad words filter:";
$lang['bad_words_Y'] = "Enable";
$lang['bad_words_N'] = "Disable";
$lang['comments_subscribe'] = "Show subscribe to comments line:";
$lang['comments_subscribe_N'] = "No";
$lang['comments_subscribe_Y'] = "Yes";
$lang['show_fields'] = "Show these on the comments list and/or comment entry form?";
$lang['comments_emoticons'] = "Emoticons:";
$lang['comments_emoticons_N'] = "Disable";
$lang['comments_emoticons_Y'] = "Enable";
$lang['gravatar'] = "Gravatars:";
$lang['gravatar_N'] = "Disable";
$lang['gravatar_Y'] = "Enable";
$lang['gravatar_size'] = "Gravatar size";
$lang['gravatar_rating'] = "Gravatar rating";
$lang['comment_subject'] = "Show comment subject:";
$lang['comment_subject_N'] = "No";
$lang['comment_subject_Y'] = "Yes";
$lang['author_location'] = "Show author location:";
$lang['author_location_N'] = "No";
$lang['author_location_Y'] = "Yes";
$lang['author_website'] = "Show author website:";
$lang['author_website_N'] = "No";
$lang['author_website_Y'] = "Yes";
$lang['author_website_link1'] = "link1.gif";
$lang['author_website_link2'] = "link2.gif";
$lang['author_website_link3'] = "Name link";
$lang['author_website_link4'] = "No link";
$lang['lightbox'] = "Enable lightbox for images:";
$lang['lightbox_N'] = "No";
$lang['lightbox_Y'] = "Yes";
$lang['allow_replies'] = "Comment replies:";
$lang['allow_replies_N'] = "Disable";
$lang['allow_replies_Y'] = "Enable";
$lang['comment_search'] = "Comments search:";
$lang['comment_search_N'] = "Disable";
$lang['comment_search_Y'] = "Enable";
$lang['use_pages_N'] = "As number of comments";
$lang['use_pages_Y'] = "As number of pages";

// Spam and moderation settings
$lang['header_moderation'] = "Spam and Moderation Settings";
$lang['moderation_form'] = "Moderation method:";
$lang['moderation'] = "Comments moderation: 0 = spam comments only, 1 = moderate all comments";
$lang['moderate_all_N'] = "System default";
$lang['moderate_all_Y'] = "Moderate all comments";
$lang['akismet_key'] = "Akismet key";
$lang['max_links'] = "Maximum number of permitted links";
$lang['discard_spam'] = "Discard spam";
$lang['captcha'] = "Enable captcha checking";
$lang['captcha_public'] = "reCAPTCHA Public key";
$lang['captcha_private'] = "reCAPTCHA Private key";
$lang['spamwords'] = "Enable spam words checking";

// Advanced and testing settings
$lang['header_advanced'] = "Advanced and Testing Settings";
$lang['note_advanced'] = "There is normally no need to change these.";
$lang['test_ip'] = "Test IP: LEAVE IT empty ON YOUR &ldquo;LIVE&rdquo; SYSTEM";
$lang['log_errors'] = "Log HTTP request errors";
$lang['logfile_name'] = "Name of the error log file";
$lang['cookie_name'] = "Cookie name.";
$lang['random_seed'] = "Random seed";
$lang['regen_seed'] = "Regenerate random seed";

// Settings in config.php
$lang['header_configphp'] = "Settings in config.php";
$lang['note_configphp'] = "These are shown for your information only. They cannot be edited here.";
$lang['dbhost'] = "MySQL host server name";
$lang['dbuser'] = "MySQL user name";
$lang['dbpassword'] = "MySQL password";
$lang['dbname'] = "MySQL database name";
$lang['dbprefix'] = "MySQL tables preffix";
$lang['talkback_path'] = "Path to TalkBack directory";
$lang['default_language'] = "Default language";
$lang['admin_email'] = "Email address at which to send administrator notices";
$lang['testing'] = "Testing flag";
$lang['doc_root_path'] = "Path to HTML root directory";

// Miscellaneous
$lang['update_button'] = "Update";
$lang['required_field_1'] = "Field "; // field name is inserted between the two messages
$lang['required_field_2'] = " is required but is empty.";
$lang['invalid_field'] = "contains invalid data.";
$lang['error_footer'] = "Use your browser back button to correct the errors";
$lang['updated'] = "Updated";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	INSTALLATION SCRIPT MESSAGES
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['header_database'] = "Database settings";
$lang['install_preface'] = "These are the basic settings. All others will be set to default values which you may change via admin configuration maintenance.";
$lang['error_header'] = "<strong>The following errors occurred:</strong>";
$lang['aborted'] = "<strong>Installation aborted</strong>";
$lang['successful_connect'] = "Successfully connected to the database server";
$lang['successful_access'] = "Successfully accessed the TalkBack database";
$lang['table'] = "Created table";
$lang['table_exists'] = "Table already exists";
$lang['error_action'] = "Delete the tables from the prior installation if you want to reinstall.";
$lang['config_file1'] = "Created configuration file";
$lang['config_file2'] = "Cannot open config file for writing. You must create a text file named &ldquo;config.php&rdquo;, copy and paste following content into it, then upload it to the TalkBack directory on your server.";
$lang['help'] = "Help";
$lang['install_complete'] = "Installation complete";
$lang['config_help_title'] = "Configuration Settings Help";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	FATAL ERROR MESSAGES
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['error_handler_title'] = "TalkBack Error Handler"; 
$lang['db_no_connect'] = "Unable connect to the database server. Comments cannot be displayed."; 
$lang['db_not_exist'] = "Unable to select the database.  Comments cannot be displayed."; 
$lang['dberror_config'] = "Unable to read configuration table";
$lang['dberror_admin_key_update'] = "Unable to update the admin_key.";
$lang['comment_nof'] = "common-functions notifyOriginalAuthor(): original comment is not on file.";
$lang['dberror_subject'] = "TalkBack Error on";
$lang['cid_error'] = "comments.php was expecting CID (comment id) as input but did not receive it. This is a script problem, notify the author.";

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	ADMIN HELP PANELS
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['admin_help_title'] = "Admin Help";
$lang['admin_help_index_title'] = "Contents";
$lang['admin_help_index'] = "
<ul>
	<li><span style='color: #FF9C00'>The &lsquo;page&rsquo; panels</span>
		<ul class='second-level'>
			<li><a href='admin-help.php?p=pageselect'>Select Page panel</a></li>
			<li><a href='admin-help.php?p=pagelist'>Comments by Page panel</a></li>
			<li><a href='admin-help.php?p=recentlist'>Recent Comments panel</a></li>
			<li><a href='admin-help.php?p=unapprovedlist'>Unapproved Comments panel</a></li>
			<li><a href='admin-help.php?p=spamlist'>Spam Comments panel</a></li>
			<li><a href='admin-help.php?p=actionslist'>Action column messages and their meaning</a></li>
			<li><a href='admin-help.php?p=actions'>Explanation of the action links</a></li>
		</ul>
	</li>
	<li><a href='admin-help.php?p=bannedlist'>Banned IP Addresses panel</a></li>
	<li><a href='admin-help.php?p=subscriberlist'>Subscribers panel</a></li>
	<li><span style='color: #FF9C00'>Maintenance panel</span>
		<ul class='second-level'>
			<li><a href='admin-help.php?p=optimize'>Optimizing database tables</a></li>
			<li><a href='admin-help.php?p=backup'>Backing up the database</a></li>
			<li><a href='admin-help.php?p=config'>Configuration settings</a></li>
		</ul>
	</li>
	<li><a href='../doc/index.html'>User Guide</a></li>
</ul>";
$lang['admin_help_actions_title'] = "Action Links";
$lang['admin_help_actions'] = "
<p>These are the links that may appear in the Action column. Any noted Akismet actions will be performed only if (1) a WordPress API key (configuration setting) exists and (2) the &ldquo;Testing&rdquo; configuration option is not set.</p>
<ul>
	<li>
	<span class='blue'>[Edit]</span> appears for every comment on every panel. Clicking it opens the comment edit form allowing you to change the comment without going to the page on which the comment appears.
	</li>
	<li>
	<span class='blue'>[Reply]</span> appears for every comment on every panel. Clicking it opens the comment reply form allowing you to reply without going to the page on which the comment appears. On that panel you have the option to send a copy of the reply by email to the comment author. A copy of that email is sent to you (the address in configuration setting admin_email).
	<p>Note that you can reply by email without entering a reply on the comment page by clicking the the author name which is a mailto link.</p>
	</li>
	<li>
	<span class='blue'>[Ban IP]</span> or <span class='blue'>[Uban IP]</span> appears for every comment on every panel. The link &ldquo;toggles&rdquo; between ban and unban. Clicking it bans or unbans the comment author&rsquo;s IP address.
	<p>A comment entered from a banned IP address is rejected and results in the visitor receiving a &ldquo;you are not allowed to enter comments&rdquo; error message.</p>
	</li>
	<li><span class='blue'>[Approve]</span> appears for every &ldquo;unapproved&rdquo; comment. Clicking it changes the comment&rsquo;s status to approved. 
	<p>In addition, if the comment was marked as spam, the Akismet service will be sent an &ldquo;is ham&rdquo; notice informing it of the mis-diagnosis.</p>
	</li>
	<li><span class='blue'>[Delete]</span> appears for every comment on every panel. Clicking it deletes the comment. There is no confirmation dialog so be careful. Once deleted, it cannot be undeleted.
	</li>
	<li>
	<span class='blue'>[Is Spam]</span> appears for every comment on every panel except the Spam Comments panel (if a WordPress API key exists). Clicking it deletes the comment. Again, be careful. Once deleted, it cannot be undeleted. 
	<p>Use this instead of <span class='blue'>[Delete]</span> if the comment is spam. The Akismet service will be sent an &ldquo;is spam&rdquo; notice informing it of the mis-diagnosis.</p>
	</li>
</ul>";
$lang['admin_help_actions_list_title'] = "Action Column Messages";
$lang['admin_help_actions_list'] = "
<p>The following messages can appear in the Action column of the various page panels.</p>
<ul>
	<li>
	<span class='red'>SPAM</span> will appear for every comment in the Spam Comments panel. It is redundant as all comments in this panel are spam but it serves as a visual reminder that you are viewing spam comments. You will not see this on any other panel because spam comments are listed only in the Spam Comments panel.
	</li>
	<li>
	<span class='red'>{$lang['moderation_msg']}</span> appears for all newly entered comments if you have set the &ldquo;moderate all&rdquo; configuration setting to moderate all comments. The comment will not be shown to visitors. You must either approve or delete the comment.
	</li>
	<li>
	<span class='red'>{$lang['max_links_msg']}</span> will appear for any comment that has more than the maximum number of permitted links (a configuration setting). The comment is &ldquo;unapproved&rdquo; and will not be shown to visitors. You must either approve or delete the comment.
	</li>
	<li>
	<span class='red'>{$lang['invalid_akismet_key']}</span> appears if, when attempting to validate the comment, the Akismet server returned an invalid key status. If this occurs at all, it should only happen when you are initially setting up the system. 
	<p>If it occurs after you have previously successfully connected with the Akismet server, then either (1) your Akismet key has become corrupted or (2) something is wrong with the Akismet server. Verify your Akismet key via the Maintenance <span style='font-size: 1.2em;'>&raquo;</span> Configuration Settings panel.</p>
	<p>The comment is “unapproved” and will not be shown to visitors. You should approve it or delete it.</p>
	</li>
	<li>
	<span class='red'>{$lang['akismet_no_response']}</span> appears if, when attempting to validate the comment, the Akismet server does not respond. Why it did not respond we do not know. It may be temporarily down for maintenance, or overwhelmed with spam check requests, or some other problem caused it to be unreachable at that moment. 
	<p>The comment is “unapproved” and will not be shown to visitors. You should approve it or delete it.</p>
	</li>
</ul>";
$lang['admin_help_pageselect_title'] = "Select Page Panel";
$lang['admin_help_pageselect'] = "
<p>This panel presents a menu of all pages that have comments, allowing you to view all comments for any page. If you have many comments pages, the search box allows you to quickly find a page without looking through the entire list.</p>";
$lang['admin_help_pagelist_title'] = "Comments by Page Panel";
$lang['admin_help_pagelist'] = "
<p>This panel lists all <strong>non-spam</strong> comments for the selected page. If there is no action message shown the comment is &ldquo;approved.&rdquo;</p>";
$lang['admin_help_recentlist_title'] = "Recent Comments Panel";
$lang['admin_help_recentlist'] = "
<p>This panel lists all <strong>non-spam</strong> comments for the last n days, where n is a configuration setting you can change. If there is no action message shown the comment is &ldquo;approved.&rdquo;</p>
<p>You should review the comments on this list at least once every n days or more frequently if you get many comments. Look for:</p>
<ul>
	<li>Comments that are spam but were not marked as so by the Akismet service. Use the <span class='blue'>[Is Spam]</span> link to delete such comments. Doing so causes a mis-diagnosis notice to be sent to the Akismet service.</li>
	<li>Comments that have a <a href='admin-help-actions-list.php'>warning message</a> in the Action column. Such comments must be either approved or deleted.</li>
</ul>";
$lang['admin_help_unapprovedlist_title'] = "Unapproved Comments Panel";
$lang['admin_help_unapprovedlist'] = "
<p>This panel lists all unapproved comments excluding those flagged as spam. Note that these comments also appear on the Comments by Page and Recent Comments panels. So this listing is redundant but serves as a way to double check that you have not missed acting on any unapproved comments.</p>
<p>These comments must be either approved or deleted.</p>";
$lang['admin_help_spamlist_title'] = "Spam Comments Panel";
$lang['admin_help_spamlist'] = "This panel lists all comments flagged as spam by the Akisment service. You should review these comments regularly and either approve or delete them.";
$lang['admin_help_bannedlist_title'] = "Banned IP Panel";
$lang['admin_help_bannedlist'] = "
<p>This panel presents a simple list of banned IP addresses along with a link to unban the IP. Because of the methods used by comment spammers (eg using hundreds of compromised PC&rsquo;s as robot systems) banning IP addresses affords no protection against comment spam.</p>
<p>IP banning is useful only to block comments from a known visitor whose comments you do not want to appear on your site. Even then it is of limited usefulness as a semi knowledgeable person can easily circumvent the block by browsing to your site through a proxie server.</p>";
$lang['admin_help_subscriberlist_title'] = "Subscribers Panel";
$lang['admin_help_subscriberlist'] = "
<p>This panel lists visitors who have subscribed to followup comments. The subscriptions are by page so one person will have multiple subscriptions on file if they have subscribed to multiple pages.</p>
<p>The subscriptions can be sorted by either page or the subscriber&rsquo;s email address. Clicking the <span class='blue'>[Delete]</span> link deletes the subscription.</p>";
$lang['admin_help_optimizedb_title'] = "Optimizing Database Tables";
$lang['admin_help_optimizedb'] = "
<p>The database backup script optimizes the tables before creating the backup. So if you do a regular backup you do not have to execute this script.</p>
<p>The database tables should be optimized periodically to improve performance. Adding and deleting comments over a period of time will degrade performance similar to fragmentation on a hard drive.</p>
<p>On low volume personal sites it is not a critical issue. Only on high volume sites could it become a serious performance factor. But it doesn&rsquo;t hurt to do it. So make a mental note to run the optimizer once a month or so. Unless the database is very large, it will run and finish quickly.</p>";
$lang['admin_help_backupdb_title'] = "Backing up the Database";
$lang['admin_help_backupdb'] = "
<p>The first time you do a backup check the downloaded file to be sure it is not a 0k or 1k file. If the file is empty, the dump command did not work. The most likely reason for it not working is an invalid path in configuration settings for the mysqldump command.</p>
<p>Windows server users: you may experience difficulty getting the backup to work even if you have the correct path to mysqldump in the configuration setting. Your best source of information will be your web host&rsquo;s technical support department. You might also read the PHP manual for the <a href='http://us2.php.net/manual/en/function.system.php' target='_blank'>system() function</a> (which is used to excute the mysqldump command). Do a series of finds on that page for \"windows\" to read what others have experienced.</p>
<p><b>Tip:</b> Create a bookmark that points to <code>http://yoursite.com/talkbak-path/admin/?action=backupdb</code>. This eliminates the need to go to the admin maintenance menu to backup your database.</p>
<p>Backing up your comments database on a regular basis is important. You will kick yourself if your server crashes and loses your comments and you don&rsquo;t have a very recent backup.</p>
<p>After clicking the backup button, the data will be gathered into a file. When that is finished you will be prompted with a standard download dialog to save the file on your PC. After it is saved you can delete the prior backup file from your PC.</p>
<p>The backup routine uses the standard mysqldump command. Use phpMyAdmin to restore the file.</p>
<p>To view the contents of the backup file, unzip it and open it in any text editor.</p>
<p><strong>Note: </strong>The backup script also optimizes the database and clears the user_agent field in the comments table for comments older than <a href='admin-help-config.php#user_agent_days'>user_agent_days</a>. This removes up to 255 characters per comment from the database. It then optimizes the database before creating the backup.</p>";
$lang['admin_help_config_title'] = "Configuration Settings";
$lang['admin_help_config1'] = "
<p>This panel allows you to view all of the configuration settings and change all but those that reside in config.php. If the settings in config.php should ever need to be changed (unlikely), you must download the file, edit it then upload it.</p>";

/* ++++++++++++++++++s+++++++++++++++++++++++++++++++++++++++++++++++
	ADMIN CONFIGURATION SETTINGS HELP
   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$lang['ach_panel_title'] = "Configuration setting help";
$CTN = 'Configuration entry name:';

// Administration settings
$lang['ach_site_name'] = "$CTN site_name <p>The name of your website. Appears in admin panel headings, email administrator and subscriber email notices and error messages heading.</p>";
$lang['ach_site_url'] = "$CTN site_url<p>The URL to your website without trailing slash. Used in external communications, e.g. to create links to your website in email notices. Example: http://www.mysite.com</p>";
$lang['ach_admin_login'] = "$CTN admin_login <p>Administrator user ID. The name that you enter into the administrator login panel.</p>";
$lang['ach_admin_password'] = "$CTN admin_password<p>Administrator password. The password for the administrator login panel</p>";
$lang['ach_admin_name'] = "$CTN admin_name <p>Administrator&rsquo;s name. This should be the name you intend to use in your comment posts. Together with admin_email (see below) this name is used to identify and apply admin CSS styles to your posts</p>.";
$lang['ach_email_from'] = "$CTN email_from <p>The email address to be inserted in the &ldquo;From&rdquo; header in email notices. This may be the same as admin_email (in config.php section below) or you may want to create a new mailbox specifically for TalkBack email notices. Example: comments@yoursite.com.</p>";
$lang['ach_admin_date'] = "$CTN admin_date <p>The date/time format string for admin panels. See user guide <a href='../doc/date-format.html' target='_blank'>Date Format String Options</a> for information about the format string parameters.</p>";
$lang['ach_num_of_days'] = "$CTN num_of_days <p>The number of days to include on the admin Recent Comments panel</p>";
$lang['ach_files_directory'] = "$CTN files_directory <p>The complete path to the directory in which backup files will be placed temporarily. Must end with a slash.</p>
<p>Strongly recommend it be above your html root (which is usually named public_html, www, or htdocs) so that files in it cannot be download by entering a URL in a browser.</p>
<p></p>The path will look something like: <code style='font-size: 1.2em'>/home/username/directoryname/</code>. Where directoryname is the directory in which the files will be placed. It must be writable by PHP and mySQL.</p>
<p>You can use an existing temporary files directory.</p>";
$lang['ach_mysqldump_path'] = "This is the path to the mySQL database dump utility program used to create database backups. On a Unix type server the path will be most likely be \"/usr/bin/mysqldump\".</p> 
<p>Windows users, read: <a href='admin-cph.php?&name=admin_help_backupdb&TB_iframe=true&height=250&width=400' title='{$lang['admin_help_backupdb_title']}' class='thickbox'>backup help</a>.</p>";
$lang['ach_admin_cookie'] = "$CTN admin_cookie <p>Determines whether the administrator cookie is temporary (deleted when you close your browser) or permanent.</p>
<p>Having a permanent cookie that allows admin access to TalkBack may or may not be a security risk depending on your environment.</p> 
<p>The advantage to making it permanent is that edit and delete links will always be displayed when you view comments pages. With a temporary cookie, if you have closed your browser since your last visit to the admin panels, you will have to login to the admin panels to create the cookie.</p>";
$lang['ach_admin_notices'] = "$CTN admin_notices <p>If you want to receive an email notice each time a comment is entered, check &ldquo;No suppression.&rdquo; If you never want to receive an email notice when a comment is entered, check &ldquo;Suppress all new comment email notices.&rdquo;</p>
<p>The other option, &ldquo;Send one notice...&rdquo;, is a good choice if you typically receive a number of comments each day but, for example, only want to review them once a day. The first comment will trigger an email notice and a <em>flag</em> will be set. The flag suppresses additonal notices. The flag is reset each time you visit the admin panels. The result is that you receive one notice but no more until after you have visited the admin panels.</p>";

// Comments settings
$lang['ach_maintenance'] = "$CTN maintenance <p>Setting this flag causes visitors to see a &ldquo;doing maintenance&rdquo; message in place of the list of comments and comments entry form. It is for use when installing a TalkBack upgrade and/or you are in the midst of changing CSS styles or comments template layout. Setting this flag prevents the user from seeing page not found errors or incorrectly formatted comments.</p>
<p>This redirection applies only to visitors. If your cookie identifies you as the administrator you will see the normal pages. The message displayed to the user is issued by comments-maintnenace.php. The message content is in \$lang['doing-maintenance'] in the language file.</p>
<p>You might want to apply some styles to the message. The default style and layout is rather plain.</p>";
$lang['ach_time_offset'] = "$CTN time_offset <p>The difference between your website server and your local time. This allows the time on comments posts to be shown as your local time. The value may be preceded with a minus sign and may be a decimal number. Examples:</p>
<p>2 (two hours later than server time)
<br /><br />-2 (two hours earlier than server time)
<br /><br />1.5 (one and one half hours later than server time).</p>";
$lang['ach_date_locale'] = "$CTN date_locale <p>The language code that governs in which language dates are displayed. If empty, weekday and month names will be displayed in your server&rsquo;s default language (usually English). See user guide <a href='../doc/date-locale.html' target='_blank'>Date Locale Options</a> for information about the codes.</p>";
$lang['ach_comments_date'] = "$CTN comments_date <p>The date/time format string for comment posts. See user guide <a href='../doc/date-format.html' target='_blank'>Date Format String Options</a> for information about the format string parameters.</p>";
$lang['ach_wait_time'] = "$CTN wait_time <p>The number of seconds after submitting a comment before the visitor can enter another comment. I don&rsquo;t think much of &ldquo;flood control&rdquo; and set my sites to 1 second. It won&rsquo;t stop spammers, most use a different IP, name and email for each post.</p>";
$lang['ach_page_limit'] = "$CTN page_limit <p>The default number of comments per page for the comments template. Visitors may override this number.";
$lang['ach_comment_size'] = "$CTN comment_size <p>The maximum number of characters allowed in a comment.empty = unlimited.</p>";
$lang['ach_user_agent_days'] = "$CTN user_agent_days <p>The number of days to keep the browser user agent string field on file for the comment, after which the field will be cleared. The field may contain as much as 255 characters. Clearing it saves a little storage space on a system with a large number of comments.</p>
<p>The field is cleared by optimizing and backing up the database.</p>
<p>The user agent string is sent to Akismet when the <strong>Is Ham</strong> and <strong>Is Spam</strong> action links are clicked in the admin panels. So you want the number to be at least the number of days that might pass without reviewing your comments.";
$lang['ach_allowed_tags'] = "$CTN allowed_tags <p>Specifies which HTML tags are allowed in comments. The visitor will receive an error message if a tag not listed here is entered in a comment. 
<p>Before version 2.2 the &ldquo;img&rdquo; tag had to be in the list for emoticons to show in comments. That is no longer true.</p>
<p>If this setting is empty, the HTML &ldquo;quick tag&rdquo; buttons will not be shown on the comment form.</p> 
<p>If the &ldquo;a&rdquo; tag is not in the list, URL&rsquo;s will not be converted to hyperlinks.</p>
<p>HTML tag buttons will appear on the comment form in the order in which the tags appear in this list.</p>
<p>If you do not want a tag button on the form for a given HTML tag, place a - (minus) after it. The tag will be allowed but will have to be manually entered. Example:</p>
<code>a,i,u,b,s,pre,code,img,blockquote,big-,small-,center-,font-,<,></code>
<p>The < and > &ldquo;tags&rdquo; are not HTML tags. They create the HTML entity codes &amp;lt; and &amp;gt;. These code place the < (left bracket) and > (right bracket) characters in the comment. The codes are necessary because simply typing a < or > charcter in the comment will trigger the the HTML tag parser to treat it and the subsequent characters as if it was an HTML tag. That will give unpredictable results in the comment text after it is validated.</p>
<p>The tag button routine will create tag buttons for the below tags. You can allow other tags but buttons will not be created for them:</p>
<code>big,small,center,font,hr,a,i,u,b,s,pre,code,img,blockquote,ul,ol,li,<,></code>";
$lang['ach_comments_link_target'] = "$CTN comments_link_target <p>Determines whether or not links will be opened in a new window.</p>";
$lang['ach_bad_words'] = "$CTN bad_words <p>If this is enabled words listed in badwords.php will be replaced with their associated replacement string. Edit badwords.php to add/delete words.</p>";
$lang['ach_allow_replies'] = "$CTN allow_replies <p>Determines whether or visitors will see a reply link in the comment footer. The link is always displayed if your admin cookie is set.</p>";
$lang['ach_comments_emoticons'] = "$CTN comments_emoticons <p>Determines whether or not the line of smiley icons is printed on the comments form and whether or not the system will replace smiley codes with image tags.</p>";
$lang['ach_gravatar'] = "$CTN gravatar <p>Determines whether or not the visitor&rsquo;s gravatar (if any) is displayed. See the user guide > About gravatars for more information.</p>";
$lang['ach_gravatar_size'] = "$CTN gravatar_size <p>The size of the gravatar in pixels from 1 - 80. If you change the default value, you must also resize and rename the default gravatar which is unknown-40.jpg. There must be a default gravatar for this size in the /talkback/images directory. The size of the image and the number in the name must be the same as this size. The name must be unknown-nn.jpg where nn is the pixel size of the image.</p>";
$lang['ach_gravatar_rating'] = "$CTN gravatar_rating <p>This code uses the USA motion picture rating system codes to indicate for which audiences you will accept gravatars on your site<br /><br />
G&nbsp;&nbsp;is suitable for all audiences including small children.<br />
PG&nbsp;&nbsp;is less suitable for small children.<br />
R&nbsp;&nbsp;is suitable only for teenagers and adults.<br />
X&nbsp;&nbsp;is suitable only for adults (may be pornographic).<br /><br />
The rating is set by the gravatar&rsquo;s owner so it is not necessarily reliable.</p>";
$lang['ach_lightbox'] = "$CTN lightbox <p>Determines whether or not a special &ldquo;image&rdquo; button will be added to the quick tag line in the comment entry form. Clicking that button creates a link to an image on the web. That image will be displayed in a &ldquo;lightbox&rdquo; (see about lightbox in the user guide).</p>
<p>If the visitor&rsquo;s browser does not have Javascript enabled, the lightbox image link will be treated like any other link, i.e. the image will be displayed by itself in a window and you have to use the browser back button to return to the comments page.</p>
<p>Note that for the lightbox to work you must have included the lightbox javascript links in the head section of your HTML. See user guide <a href='../doc/lightbox.html' target='_blank'>about Lightbox</a> for more information.</p>";
$lang['ach_author_location'] = "$CTN author_location <p>Determines whether or not the author location field appears in comments and on the comment form.</p>";
$lang['ach_author_website'] = "$CTN author_website <p>Determines whether or not the author website field appears in comments and on the comment form.</p>
<p>$CTN author_website_link</p>
<p>If you checked yes on the above option, you have four choices as to how the author&rsquo;s name and website are displayed:</p>
<ul>
	<li>link1.gif will show this <img src='../images/link1.gif' width='13' height='11' alt='' /> image link to the left of author name.</li>
	<li>link2.gif will show this <img src='../images/link2.gif' width='14' height='15' alt='' /> image link to the left of author name.</li>
	<li>Name link will show the author&rsquo;s name as a link to the website.</li>
	<li>No link will show the author&rsquo;s name without a link to his website.</li>
</ul>
<p>You may, of course, substitute an image of your choice for the default images. Just name it link1.gif or link2.gif and put it in the images directory. If it is taller than 15 pixels you will have to adjust the height of styles: .tb-comment-header, .tb-comment-header-admin</p>";
$lang['ach_comment_subject'] = "$CTN comment_subject <p>Determines whether or not the comment subject field appears in comments and on the comment form.</p>";
$lang['ach_comments_subscribe'] = "$CTN comments_subscribe <p>Determines whether or not the email subscription radio buttons appears on the comment entry form.</p>";
$lang['ach_comments_legend'] = "$CTN comments_legend<p>Determines whether or not the number of comments legend is displayed.</p><p>If you select yes, the line below it determines whether the legend shows the number of comments or number of pages.</p>";
$lang['ach_sort_order_line'] = "$CTN sort_order_line <p>Determines whether or not the sort order line (sort order radio buttons and page_limit override input field) will be printed at the top of the comments list on comments pages. The choices are print it: always, never or only if the total number of comments is greater than the value in &ldquo;page_limit&rdquo;</p>";

// Spam and moderation settings
$lang['ach_moderation'] = "$CTN moderation <p>Determines whether or not all comments will be held for your approval. If you choose the system default, the rules are: a comment will be held for your approval if:</p></li>
	<ul>
		<li>the maximum number of links is exceeded.</li>
		<li>Akismet checking is enabled and it marks comment as spam.</li>
		<li>Akismet checking is enabled and the system cannot connect to Akismet server.</li>
	</ul>
	<li></b></li>
</ul>";
$lang['ach_akismet_key'] = "$CTN akismet_key <p>Technically it is a <em>WordPress blog API key</em>, but Akismet key is less of a mouthfull.</p> 
<p>If a key is entered and if it is valid, all new comments will sent to the Akismet spam checking service for validation. If the service flags it as spam, the comment is marked as such in the database and is not included with comments shown to visitors. You must either approve or delete spam comments. See the installation guide for instructions on obtaining a key.</p>";
$lang['ach_discard_spam'] = "$CTN discard_spam <p>If checked, any comment flagged as spam by Akismet will be discarded. A comment rejected message is displayed (in the off chance that it was a real visitor and not a spambot) telling the visitor to try again or contact the webmaster. The comment will not be placed in the database.
<p>You may wish to set this once you have gained confidence in Akismet and if you are being inundated with spam comments to the point that it is impractical to review them for false positives.</p>";
$lang['ach_max_links'] = "$CTN max_links <p>The maximum number of links permitted in comment. Any comments with more than this number of links will be held for your approval or deletion and are not included with comments shown to visitors.</p>";
$lang['ach_captcha'] = "$CTN captcha <p>Check this box to enable captcha checking for spam.</p>";
$lang['ach_captcha_keys'] = "$CTN captcha_public &amp; captcha_private <p>If you enabled captcha checking, enter the public and private keys you obtained by signing up at <a href='https://admin.recaptcha.net/accounts/signup/?next=%2Frecaptcha%2Fcreatesite%2F' target='blank'>reCAPTCHA.net</a></p>";
$lang['ach_spamwords'] = "$CTN spamwords<p>Check this if you want the text of new comments to be checked against the list of spam words in spamwords.php.</p>";

// Template file names
$lang['ach_comments_driver'] = "<pre style='font-size: 1.1em;'>
comments_driver,       default = comments.php
comments_display_tpl,  default = comments-display-tpl.php
comments_form_tpl,     default = comments-form-tpl.php
preview_panel_tpl,     default = comments-preview.php
reply_panel_tpl,       default = comments-reply-tpl.php
help_panel_tpl,        default = comments-help.php</pre>
<p>These settings allow you to copy a template, rename it and make changes to the new template. Enter the name of the new template here. Doing this ensures that your customized templates will not be overwritten if you upgrade to a new TalkBack release in the future.</p>
<p>Note that comments.php is not a template so you don&rsquo;t want to make changes to it. But changing it&rsquo;s name may foil some spambots, at least temporarily.</p>";

// Advanced and Testing Settings
$lang['ach_log_errors'] = "$CTN log_errors <p>When a request for a page is received from a browser it is validated. Some of those requests are from hackers trying to break into your server via what the hacker thinks may be a security hole in TalkBack. Those types of requests have certain characteristics which the TalkBack validation routines check for. If found, the request is rejected (with an error message just in case it really is a request from a real visitor to your site).</p>
<p>If you wish you can monitor the rejected requests by checking the log errors checkbox. Information about the requests will be written to a log file which you can periodically review. If the checkbox is checked you must also specifiy an error log file name and a directory in &ldquo;Path to backup files directory&rdquo;.</p>";
$lang['ach_logfile_name'] = "$CTN logfile_name <p>The name of the file in which HTTP request errors will be written. The file will be palced in the directory specified by \"Path to backup files directory.\" So that field must also contain a valid path to a directory on your server.</p>
<p>Don&rsquo;t forget to periodically clear or delete the log file so that it does not grow too large.</p>";
$lang['ach_test_ip'] = "$CTN test_ip <p>IP address to be used for testing the system. If an IP address is entered in this setting it will be used as the comment author&rsquo;s IP address when sending comments to the Akismet service.</p>
<p>If you plan on doing much testing of the system with Akismet checking enabled, it would be wise to temporarily insert a &ldquo;dummy&rdquo; IP address in this field. That is because at some point in time, after having entered some number of comments that are flagged as spam, Akismet is likely to flag <b>your</b> IP address and thereafter treat every comment you enter as spam.</p>
<p>A valid IP address looks like nnn.nnn.nnn.nnn where nnn can be a number between 0 and 255. So the maximum legal address is 255.255.255.255</p>
<p>If you decide to use this feature while testing the system, enter an address in which any one (or more) of the numbers is greater than 255. Example: 256.1.1.1</p>
<p>Do not forget to clear this field before going &ldquo;live&rdquo; and allowing your visitors to enter comments.</p>";
$lang['ach_cookie_name'] = "$CTN cookie_name <p>There is no need to change the cookie name if you operate with only one TalkBack installation. 
<p>Users that want to have individual administration for each of multiple domains/subdomains need to have separate installations for each. In that case, each installation should have a differently named cookie.</p>
<p>As an example I operate three separate comments installations. One each for oldguy.us, scripts.oldguy.us and scripts.oldguy.us/dev. Each uses a separate database and differently named cookie.</p>";
$lang['ach_random_seed'] = "$CTN random_seed <p>This value (created during installation) is used to validate information provided by visitors. At this time it is used only in processing new subscriptions. There should be no need to ever change the value. But a checkbox to cause the value to be regenerated is included for contingency purposes.</p>
<p>Recreating the number if there are any outstanding subscription confirmation notices will cause an error when the subscriber tries to confirm the subscription.</p>";

// config.php settings
$lang['ach_configphp'] = "<p>These settings are in the config.php file because they are accessed by scripts before the configuration table is read from the database. If you need to change any of them, downlowad and edit config.php.</p>";
$lang['ach_dbhost'] = "$CTN dbhost <p>The name of the server on which the database resides (usually &ldquo;localhost&rdquo; on a Unix system).";
$lang['ach_dbuser'] = "$CTN dbuser <p>The database user ID that is to be used when accessing the database. This user must have the following MySQL permissions for daily operation: Select, Insert, Update, Delete. For upgrading to a new version, Create, Drop and Alter permissions may also be required.</p>
<p>Some web hosts require you to prepend your account name, e.g. accountname_databaseusername</p>";
$lang['ach_dbpassword'] = "$CTN dbpassword <p>The database user&rsquo;s password.</p>";
$lang['ach_dbname'] = "$CTN dbname <p>Name of the database in which the TalkBack tables will reside. Default is &ldquo;talkback&rdquo; but you can assign any name.
<p>Some web hosts require you to prepend your account name, e.g. accountname_databasename</p></p> 
<p>You can put the TalkBack tables in an existing database by assigning a different table prefix to each application.</p> 
<p>You can have a separate database for each instance of TalkBack. Or you can put them in one database.
<p>See &ldquo;Databases and multiple copies of TalkBack&rdquo; in the user guide.</p>";
$lang['ach_dbprefix'] = "$CTN dbprefix <p>Prefix that is to be assigned to the table names. Default is &ldquo;tb_&rdquo;. Also see &ldquo;About multiple instances of TalkBack&rdquo; in the user guide.</p>.";
$lang['ach_default_language'] = "$CTN default_language <p>Name of the language used, unless overridden by visitors, for displaying comments pages. This is the only language in which the admin panels are displayed.";
$lang['ach_talkback_path'] = "$CTN talkback_path <p>Path to the TalkBack directory from your web root directory. Must begin and end with a /</p>
<p>This is set by the installation script and must not be changed unless you rename or move the directory. An incorrect path will cause TalkBack to become inoperable.</p>";
$lang['ach_admin_email'] = "$CTN admin_email <p>The address to which you want email administrator email notices sent. It also , along with admin_name, is used to identify and apply admin CSS styles to your posts.";
$lang['ach_message_panel_tpl'] = "$CTN message_panel_tpl <p>Message panel template file name.</p>";
$lang['ach_testing'] = "$CTN testing <p>This is useful on development systems that do not have a mail server. If set to any value, scripts will not attempt to send email notices and error messages will have some additional information that is normally contained only in the email.</p>
<p>Leave it empty on your &ldquo;live,&rdquo; internet connected system.</p>";
$lang['ach_doc_root_path'] = "$CTN doc_root_path <p>This is the file system path to the HTML root directory (the directory in which your html resides). This is set by the installation script and must not be changed. An incorrect path will cause TalkBack to become inoperable.";


// This must be the last statement in the file
// The entries in my-xxxxx.php will override any entries in this file
require 'my-english.php';
?>