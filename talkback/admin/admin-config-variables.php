<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Sets variables to display on the configuration form
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. This script may contain copyrighted code from another source that was
	released under the GPL. See credits-copyrights.txt for more information.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

$now = time() + $config['time_offset'] * 3600;
$server_time = ucwords(strftime('%A, %d %B %Y - %H:%M', (time())));
$local_time = ucwords(strftime('%A, %d %B %Y - %H:%M', $now));
$comments_time = ucwords(strftime($config['comments_date'], $now));
$admin_time = ucwords(strftime($config['admin_date'], $now));

// Hide sensitive data in configuration edit panel
if ($config['is_demo_system']) {
	$dbname = '********';
	$dbuser = '********';
	$dbpassword = '********';
	$dbprefix = '********';
	$akismet_key = '****************';
	$admin_email = '********';
	$email_from = '********';
	$captcha_public = '************************';
	$captcha_private = '************************';
	$random_seed = '****************';
} else {
	$dbname = DBNAME;
	$dbuser = DBUSER;
	$dbpassword = '********';
	$dbprefix = DBPREFIX;
	$akismet_key = $config['akismet_key'];
	$admin_email = ADMIN_EMAIL;
	$email_from = $config['email_from'];
	$captcha_public = $config['captcha_public'];
	$captcha_private = $config['captcha_private'];
	$random_seed = $config['random_seed'];
}

// select options ++++++++++++++++++++
$select_g   = ($config['gravatar_rating'] == 'G')   ? "selected='selected'" : '';
$select_pg  = ($config['gravatar_rating'] == 'PG')  ? "selected='selected'" : '';
$select_r   = ($config['gravatar_rating'] == 'R')   ? "selected='selected'" : '';
$select_x   = ($config['gravatar_rating'] == 'X')   ? "selected='selected'" : '';

// checkboxes ++++++++++++++++++++++++
if ($config['discard_spam']) {
	$discard_spam = "checked='checked'";
} else {
	$discard_spam = '';
}
if ($config['captcha']) {
	$captcha = "checked='checked'";
} else {
	$captcha = '';
}
if ($config['spamwords']) {
	$spamwords = "checked='checked'";
} else {
	$spamwords = '';
}
if ($config['log_errors']) {
	$log_errors = "checked='checked'";
} else {
	$log_errors = '';
}
	
// Radio buttons ++++++++++++++++++++
if ($config['moderation']) {
	$moderate_all_Y = "checked='checked'";
	$moderate_all_N = '';
} else {
	$moderate_all_N = "checked='checked'";
	$moderate_all_Y = '';
}
if ($config['comments_link_target']) {
	$comments_link_target_Y = "checked='checked'";
	$comments_link_target_N = '';
} else {
	$comments_link_target_N = "checked='checked'";
	$comments_link_target_Y = '';
}
if (TESTING === TRUE) {
	$testing_Y = "checked='checked'";
	$testing_N = '';
} else {
	$testing_N = "checked='checked'";
	$testing_Y = '';
}
if ($config['maintenance']) {
	$maintenance_Y = "checked='checked'";
	$maintenance_N = '';
} else {
	$maintenance_N = "checked='checked'";
	$maintenance_Y = '';
}
if ($config['admin_notices'] == 0) {
	$admin_notices_0 = "checked='checked'";
	$admin_notices_1 = "";
	$admin_notices_2 = "";
} elseif ($config['admin_notices'] == 1) {
	$admin_notices_0 = "";
	$admin_notices_1 = "checked='checked'";
	$admin_notices_2 = "";
} else {
	$admin_notices_0 = "";
	$admin_notices_1 = "";
	$admin_notices_2 = "checked='checked'";
}
if ($config['admin_cookie']) {
	$admin_cookie_Y = "checked='checked'";
	$admin_cookie_N = '';
} else {
	$admin_cookie_N = "checked='checked'";
	$admin_cookie_Y = '';
}
if ($config['sort_order_line'] == 'always') {
	$sort_order_line_ALWAYS = "checked='checked'";
	$sort_order_line_NEVER = '';
	$admin_sort_order_DEPENDS = '';
} elseif ($config['sort_order_line'] == 'never') {
	$sort_order_line_ALWAYS = '';
	$sort_order_line_NEVER = "checked='checked'";
	$sort_order_line_DEPENDS = '';
} else {
	$sort_order_line_ALWAYS = '';
	$sort_order_line_NEVER = '';
	$sort_order_line_DEPENDS = "checked='checked'";
}
if ($config['comments_emoticons']) {
	$comments_emoticons_Y = "checked='checked'";
	$comments_emoticons_N = '';
} else {
	$comments_emoticons_N = "checked='checked'";
	$comments_emoticons_Y = '';
}
if ($config['bad_words']) {
	$bad_words_Y = "checked='checked'";
	$bad_words_N = '';
} else {
	$bad_words_N = "checked='checked'";
	$bad_words_Y = '';
}
if ($config['comment_subject']) {
	$comment_subject_Y = "checked='checked'";
	$comment_subject_N = '';
} else {
	$comment_subject_N = "checked='checked'";
	$comment_subject_Y = '';
}
if ($config['author_location']) {
	$author_location_Y = "checked='checked'";
	$author_location_N = '';
} else {
	$author_location_N = "checked='checked'";
	$author_location_Y = '';
}
if ($config['author_website']) {
	$author_website_Y = "checked='checked'";
	$author_website_N = '';
} else {
	$author_website_N = "checked='checked'";
	$author_website_Y = '';
}
if ($config['comments_subscribe']) {
	$comments_subscribe_Y = "checked='checked'";
	$comments_subscribe_N = '';
} else {
	$comments_subscribe_N = "checked='checked'";
	$comments_subscribe_Y = '';
}
if ($config['allow_replies']) {
	$allow_replies_Y = "checked='checked'";
	$allow_replies_N = '';
} else {
	$allow_replies_N = "checked='checked'";
	$allow_replies_Y = '';
}
if ($config['lightbox']) {
	$lightbox_Y = "checked='checked'";
	$lightbox_N = '';
} else {
	$lightbox_N = "checked='checked'";
	$lightbox_Y = '';
}
if ($config['comments_legend']) {
	$comments_legend_Y = "checked='checked'";
	$comments_legend_N = '';
} else {
	$comments_legend_N = "checked='checked'";
	$comments_legend_Y = '';
}
if ($config['use_pages']) {
	$use_pages_Y = "checked='checked'";
	$use_pages__N = '';
} else {
	$use_pages_N = "checked='checked'";
	$use_pages_Y = '';
}
if ($config['comment_search']) {
	$comment_search_Y = "checked='checked'";
	$comment_search__N = '';
} else {
	$comment_search_N = "checked='checked'";
	$comment_search_Y = '';
}
if ($config['gravatar']) {
	$gravatar_Y = "checked='checked'";
	$gravatar__N = '';
} else {
	$gravatar_N = "checked='checked'";
	$gravatar_Y = '';
}


$author_website_link1 = ($config['author_website_link'] == 1) ? "checked='checked'" : '';
$author_website_link2 = ($config['author_website_link'] == 2) ? "checked='checked'" : '';
$author_website_link3 = ($config['author_website_link'] == 3) ? "checked='checked'" : '';
$author_website_link4 = ($config['author_website_link'] == 4) ? "checked='checked'" : '';
?>