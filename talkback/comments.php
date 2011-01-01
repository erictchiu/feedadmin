<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The main driver script for all comment entry and display functions
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy) 
	Website: http://wwwscriptsoldguyus/talkback - noldguy@gmailcom

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991 

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/

ini_set('error_reporting', E_ALL ^ E_NOTICE);
defined('IS_VALID_INCLUDE') or define('IS_VALID_INCLUDE', TRUE);

defined('SETUP_DONE') or require_once 'config.php';
$cookie = get_author_cookie();

if (!$_REQUEST['page']) {
	// We've been included from user's page or user clicked language link
	// We are not returning after a form submission
	if ($tb_article_url) {
		// Website has dynamic pages & user supplies page url
		$_REQUEST['page']           = $tb_article_url;
		$_REQUEST['article_url']    = $tb_article_url;
		$_REQUEST['article_title']  = $tb_article_title;
	} else {
		// Normal, static page website
		$_REQUEST['page']         = $_SERVER['PHP_SELF']; 
		$_REQUEST['article_url']  = $_SERVER['PHP_SELF'];
	}
}

// Setup query string
if (strpos($tb_article_url, '?') || strpos($_REQUEST['page'], '?')) {
	$separator = '&';
} else {
	$separator = '?';
}
if ($_REQUEST['language']) {
	if (!is_file(ABS_PATH.'language/'.$_REQUEST['language'].'.php')) {
		fatal_error(0, 0, "{$_REQUEST['language']} language file for does not exist.");
	}
	$language_string = $separator . "language={$_REQUEST['language']}";
} else {
	$language_string = '';
}

if ($_REQUEST['add']) {
	// Submit was clicked on comment form or comment reply form
	require 'comments-validate.php';
	require 'comments-add.php';
	set_author_cookie();
	header("HTTP/11 302");
	header("Location: ".SITE_URL.$_REQUEST['page']. "$language_string$start_page");

} elseif ($_REQUEST['update']) {
	// Admin clicked Submit button on comment edit form
	require 'comments-validate.php';
	require 'comments-edit-update.php';
	header("HTTP/11 302");
	header("Location: ".SITE_URL.$_REQUEST['page']. "$language_string$start_page2");

} elseif ($_REQUEST['preview']) {
	// Preview was clicked on either of above two forms
	require 'comments-validate.php';
	require 'comments-preview.php';
	require PREVIEW_PANEL_TPL;

} elseif ($_REQUEST['reply']) {
	// A "reply to comment" link was clicked on comments-display-tpl.php
	require 'comments-reply-prep.php';
	require REPLY_PANEL_TPL;
	
} elseif ($_REQUEST['search']) {
	// Search button was clicked
	if ($_REQUEST['search_terms']) {
		require 'search-results.php';
	} else {
		header("HTTP/11 302");
		header("Location: ".SITE_URL.$_REQUEST['page']. "$language_string");
	}

} elseif ($_REQUEST['edit']) {
	// Admin clicked edit comment link on comments-display-tpl.php
	require 'comments-edit-prep.php';
	require 'comments-edit-tpl.php';

} elseif ($_REQUEST['delete']) {
	// Admin clicked delete comment link on comments-display-tpl.php
	require 'comments-edit-prep.php';
	header("HTTP/11 302");
	header("Location: ".SITE_URL.$_REQUEST['page']. "$language_string$start_page");

} elseif ($_REQUEST['customize']) {
	// Apply was clicked on comments-display-tpl.php
	set_author_cookie(); // Sort order and/or num of comments per page has changed
	header("HTTP/11 302");
	header("Location: ".SITE_URL.$_REQUEST['page']. "$language_string");

} else { 
	// Display comments for the page	
	require 'comments-display-prep.php';
	require COMMENTS_DISPLAY_TPL;
}
?>