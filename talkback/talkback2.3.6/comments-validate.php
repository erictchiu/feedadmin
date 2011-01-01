<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Process the comments entry form and prepare the data for add, edit or display
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

// we exit instead of fatal_error() because these are most likely to be caused by
// malformed request from hacker
if (!$_REQUEST['page']) {
	write_error_log("page is empty");
	exit("<br />Unable to process the request cv1<br />");
}
if (!$_REQUEST['article_url']) {
	write_error_log("article_url is empty");
	exit("<br />Unable to process the request cv2<br />");
}

require LANGUAGE_FILE;

// <script> tag and javascript inside any html tag is not allowed...PERIOD
$pattern = "/=[\S\s]*s\s*c\s*r\s*i\s*p\s*t\s*:\s*\S+/Ui";
$test =   $_REQUEST['form_author'] 
		. $_REQUEST['form_email']
		. $_REQUEST['form_textarea']
		. $_REQUEST['form_website']
		. $_REQUEST['form_subject']
		. $_REQUEST['form_location'];
if (preg_match("/< *?script/i", $test) || preg_match($pattern, $test)) { 
	$display_message = 'script tag and Javascript code are not allowed in any field.';
	$mc_link  = $lang['browser_back'];
	require MESSAGE_PANEL_TPL;
}

$display_message =  author_error_checks();
$display_message  .= flood_check();
if ($_REQUEST['add']) { 
	 // For edit and preview, the comment will be a duplicate until the text is changed so we don't check while editing/previewing
	$display_message .= duplicate_check();  
}
if (!$_REQUEST['form_replyto']) replyto_check();

if ($display_message) {
	// Whether we are adding a new comment, editing or previewing, we go no further with bad data
	$mc_link  = $lang['browser_back'];
	require MESSAGE_PANEL_TPL;
}

// Does the visitor want to subscribe without entering a comment?
if ($_REQUEST['form_email'] && ($_REQUEST['form_subscribe'] == 1 || $_REQUEST['form_subscribe'] == 2) && !$_REQUEST['form_textarea']) {
	if (!$display_message ) {
		// Send email to confirm subscription
		confirm_subscription('');
		header("HTTP/1.1 302");
		header("Location: ".SITE_URL."{$_REQUEST['page']}");
	} else {
		$mc_link = $lang['browser_back'];
		require MESSAGE_PANEL_TPL;
	}
}

// I guess not, so we continue on to process the new comment
$display_message  .= basic_error_checks();

if ($display_message) {
	// Whether we are adding a new comment, editing or previewing, we go no further with bad data
	$mc_link  = $lang['browser_back'];
	require MESSAGE_PANEL_TPL;
}

// strip_tags function (used in format_comment_text) does not recognize the iframe tag so we need to make it inoperable  
$_REQUEST['form_textarea'] = eregi_replace('<iframe', '< iframe', $_REQUEST['form_textarea']);

// Save the unformatted comment data for scripts that need it
$raw['form_textarea']  = $_REQUEST['form_textarea'];
$raw['form_author']    = $_REQUEST['form_author'];
$raw['form_email']     = $_REQUEST['form_email'];
$raw['form_website']   = $_REQUEST['form_website'];
$raw['form_location']  = $_REQUEST['form_location'];
$raw['form_subject']   = $_REQUEST['form_subject'];

// Prepare the data for the database
$_REQUEST['form_textarea']  = format_comment_text(trim($_REQUEST['form_textarea']));
$_REQUEST['form_author']    = htmlspecialchars(strip_tags(trim($_REQUEST['form_author'])), ENT_QUOTES);
$_REQUEST['form_email']     = htmlspecialchars(strip_tags(trim($_REQUEST['form_email'])), ENT_QUOTES);
$_REQUEST['form_website']   = ($_REQUEST['form_website'] == 'http://') ? '' : htmlspecialchars(strip_tags(trim($_REQUEST['form_website'])), ENT_QUOTES);
$_REQUEST['form_location']  = htmlspecialchars(strip_tags(trim($_REQUEST['form_location'])), ENT_QUOTES);
$_REQUEST['form_subject']   = htmlspecialchars(strip_tags(trim($_REQUEST['form_subject'])), ENT_QUOTES);
if ($opentags) {
	$display_message = '';
	foreach ($opentags as $value) {
		$display_message .= "{$lang['missing_tag']} $value<br />";
	}
	$mc_link  = $lang['browser_back'];
	require MESSAGE_PANEL_TPL;
}

// Make sure we still have data in the form fields (strip_tags may have left an empty field)
$display_message = '';
if ($_REQUEST['form_textarea'] == '')  $display_message    = "<p>{$lang['text_required']}</p>";
if ($_REQUEST['form_author'] == '')    $display_message   .= "<p>{$lang['name_required']}</p>";
if ($_REQUEST['form_email'] == '')     $display_message   .= "<p>{$lang['email_required']}</p>";

if ($display_message) {
	$mc_link  = $lang['browser_back'];
	require MESSAGE_PANEL_TPL;
}

define('VALIDATED', TRUE);

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Author error checks
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function author_error_checks() {
	global $dblink, $config, $lang;
	$error_message = '';
	
	// Banned IP check
	$ip = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
	$result = mysql_query("SELECT ip FROM " . DBPREFIX . "banned WHERE ip='$ip'", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, comments-validate 3<br /> mysql error:<br />' . mysql_error());
	if (mysql_num_rows($result)>0) $error_message = "<p>{$lang['banned_error']}</p>";
	
	// Author check
	if ($_REQUEST['form_author'] == '') {
		$error_message  .= "<p>{$lang['name_required']}</p>";
	}	
	
	// Email check
	if ($_REQUEST['form_email'] == '') {
		$error_message .= "<p>{$lang['email_required']}</p>";
	}
	
	return $error_message;
}
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	More basic error checks
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function basic_error_checks() {
	global $dblink, $config, $lang;
	
		// Textarea (comment) check, we do more sanitizing in prepare_data()
	if ($_REQUEST['form_textarea'] == '') $error_message = "<p>{$lang['text_required']}</p>";
	
	if (($_REQUEST['add'] == 'add' || $_REQUEST['action'] == 'update') && $_REQUEST['form_website'] == 'http://')
		$_REQUEST['form_website'] = '';
	
	// Comment size check
	if ($config['comment_size']) {
		$size = strlen($_REQUEST['form_textarea']);
		if ($size > $config['comment_size']) 
			$error_message .= "<p>$size {$lang['text_size']}</p>";
	}
	
	if ($_REQUEST['form_subscribe'] != '1' && $_REQUEST['form_subscribe'] != '2')
		$_REQUEST['form_subscribe'] = '';
		
	if ($_REQUEST['form_rememberme'] && $_REQUEST['form_rememberme'] != '1')
		$_REQUEST['form_rememberme'] = '';
		
	// Date, time, replyto and page checks (only for admin edits)
	if ($_REQUEST['action'] == 'update') {
		if (!preg_match('/\d{2}.\d{2}.\d{4}/', $_REQUEST['form_date']))
			$error_message .= "<p>{$lang['date_invalid']}</p>";
		if (!preg_match('/\d{2}:\d{2}(:\d{2})?/', $_REQUEST['form_time']))
			$error_message .= "<p>{$lang['time_invalid']}</p>";
		if (!$_REQUEST['form_page'])
			$error_message .= "<p>{$lang['page_required']}</p>";
		if (!is_numeric($_REQUEST['form_replyto']))
			$_REQUEST['form_replyto'] = 0;
	}
	
	return $error_message;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Is it too soon for another post from this visitor?
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function flood_check() {
	global $dblink, $config, $lang;	
	
	if ($_REQUEST['add']) {
		$ip = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
		$author = mysql_real_escape_string($_REQUEST['form_author']);
		$curr_time = time() + ($config['time_offset'] * 3600);
		
		$result = mysql_query("SELECT time from " . DBPREFIX . "data WHERE (ip='$ip' OR author='$author') AND ($curr_time - time) < {$config['wait_time']}", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, comments-validate 4<br /> mysql error:<br />' . mysql_error());
		
		$error_message = (mysql_num_rows($result)>0) ? "<p>{$lang['anti_flood_msg']}</p>" : '';
	}
	return $error_message;
}
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Check for duplicate comment
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function duplicate_check() {
	global $dblink, $config, $lang;
	
	$error_message  = '';
	$text           = mysql_real_escape_string($_REQUEST['form_textarea']);
	$author         = mysql_real_escape_string($_REQUEST['form_author']);
	$article_url    = mysql_real_escape_string($_REQUEST['article_url']);
	$email          = mysql_real_escape_string($_REQUEST['form_email']);
	
	$result = mysql_query("SELECT ID from " . DBPREFIX . "data WHERE href='$article_url' AND author='$author' AND email='$email' AND text='$text' ", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, comments-validate 5<br /> mysql error:<br />' . mysql_error());
	if (mysql_num_rows($result)>0) $error_message = "<p>{$lang['duplicate_comment']}</p>";
	
	return $error_message;
}
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	If it's a reply
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function replyto_check() {
	global $dblink, $config, $lang;
	
	$form_replyto = mysql_real_escape_string($_REQUEST['form_replyto']);
	
	// verify the original comment exists
	$query = mysql_query("SELECT COUNT(ID) FROM " . DBPREFIX . "data WHERE ID='$form_replyto' LIMIT 1", $dblink);
	if (!$query) fatal_error(0, 0, 'DB query error, comments-validate 7<br /> mysql error:<br />' . mysql_error());
	
	list($original) = mysql_fetch_row($query);
	if (!$original) {
		$_REQUEST['form_replyto'] = 0;
		return;
	}
	
	// make sure reply to is an original comment, not a reply
	$result = mysql_query("SELECT ID, replyto FROM " . DBPREFIX . "data WHERE ID = '$form_replyto' LIMIT 1", $dblink);
	if (!$result) fatal_error(0, 0, 'DB query error, comments-validate 6<br /> mysql error:<br />' . mysql_error());
	
	$tbid=$replyto=array();
	list($tbid[0], $replyto[0])=mysql_fetch_array($result);
	if ($tbid[0] != $replyto[0]) {
		// If trying to reply to a reply, change it to be a reply to the original comment
		$_REQUEST['form_replyto'] = $replyto[0];
	}
	
	return;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Convert comment text to html
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
function format_comment_text($comment) {
	global $allowedtags, $config;
	
	if (!isset($allowedtags)) get_allowed_tags();
	if ($allowedtags['a']) {
		// Create an <a> tag for each URL not already inside an <a> tag
		$comment = linkURL($comment, $mode='1', $trunc_before='', $trunc_after='', $config['comments_link_target']);
	}
	if ($config['bad_words']) { // Filter out disallowed words
		include 'my-badwords.php';
		for($i=0;$i<count($badword);$i++) {  //go through each bad word
			$comment = eregi_replace($badword[$i][0],$badword[$i][1],$comment); //replace it
		}
	}
	$comment = safe_html($comment); // strip all disallowed html tags
	
	if ($config['comments_emoticons']) $comment = emoticon_scan($comment); // Convert smiley codes to emoticons
	
	return wpautop($comment); // Format the comment text
	
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Text formatting function from WordPress
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
function wpautop($pee, $br = 1) {
	$pee = $pee . "\n"; // just to make things a little easier, pad the end
	$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
	// Space things out a little
	$allblocks = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|script|object|input|param|p|h[1-6]|hr)';
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
	$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
	$pee = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "<p>$1</p>\n", $pee); // make paragraphs, including one at the end
	$pee = preg_replace('|<p>\s*?</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
	$pee = preg_replace('!<p>([^<]+)\s*?(</(?:div|address|form)[^>]*>)!', "<p>$1</p>$2", $pee);
	$pee = preg_replace( '|<p>|', "$1<p>", $pee );
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
	if ($br) {
		$pee = preg_replace('/<(script|style).*?<\/\\1>/se', 'str_replace("\n", "<WPPreserveNewline />", "\\0")', $pee);
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	if (strpos($pee, '<pre') !== false)
		$pee = preg_replace('!(<pre.*?>)(.*?)</pre>!ise', " stripslashes('$1') .  stripslashes(clean_pre('$2'))  . '</pre>' ", $pee);
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
	return $pee;
}

function clean_pre($text) { 
	$text = str_replace('<br />', '', $text); $text = str_replace('<p>', "\n", $text); $text = str_replace('</p>', '', $text); return $text;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Create hyperlinks 
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// by Scott Reilly, http://www.coffee2code.com
// mode: 0=full url; 1=host-only ;11+=number of characters to truncate after
function linkURL ($text, $mode='0', $trunc_before='', $trunc_after='', $open_in_new_window='0') {
	$text = ' ' . $text . ' ';
	$new_win_txt = ($open_in_new_window == '1') ? ' target="_blank"' : '';
        
	// Hyperlink Class B domains *.(com|org|net|gov|edu|us|info|biz|ws|name|tv)(/*)
	$text = preg_replace("#([\s{}\(\)\[\]])([A-Za-z0-9\-\.]+)\.(com|org|net|gov|edu|us|info|biz|ws|name|tv|uk|de|nl|au|fr)((?:/[^\s{}\(\)\[\]]*[^\.,\s{}\(\)\[\]]?)?)#ie",
		"'$1<a href=\"http://$2.$3$4\" title=\"http://$2.$3$4\"$new_win_txt>' . truncateLink(\"$2.$3$4\", \"$mode\", \"$trunc_before\", \"$trunc_after\") . '</a>'",
		$text);

	// Hyperlink anything with an explicit protocol
	$text = preg_replace("#([\s{}\(\)\[\]])(([a-z]+?)://([A-Za-z_0-9\-]+\.([^\s{}\(\)\[\]]+[^\s,\.\;{}\(\)\[\]])))#ie",
		"'$1<a href=\"$2\" title=\"$2\"$new_win_txt>' . truncateLink(\"$4\", \"$mode\", \"$trunc_before\", \"$trunc_after\") . '</a>'",
                $text);

	// Hyperlink e-mail addresses
	$text = preg_replace("#([\s{}\(\)\[\]])([A-Za-z0-9\-_\.]+?)@([^\s,{}\(\)\[\]]+\.[^\s.,{}\(\)\[\]]+)#ie",
		"'$1<a href=\"mailto:$2@$3\" title=\"mailto:$2@$3\">' . truncateLink(\"$2@$3\", \"$mode\", \"$trunc_before\", \"$trunc_after\") . '</a>'",
		$text);

	return substr($text,1,strlen($text)-2);
}

function truncateLink ($url, $mode='0', $trunc_before='', $trunc_after='...') {
	if (1 == $mode) {
		$url = preg_replace("/(([a-z]+?):\\/\\/[A-Za-z0-9\-\.]+).*/i", "$1", $url);
		$url = $trunc_before . preg_replace("/([A-Za-z0-9\-\.]+\.(com|org|net|gov|edu|us|info|biz|ws|name|tv|uk|de|nl|au|fr)).*/i", "$1", $url) . $trunc_after;
 	} elseif (($mode > 10) && (strlen($url) > $mode)) {
		$url = $trunc_before . substr($url, 0, $mode) . $trunc_after;
	}
 	return $url;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Sanitizes HTML tags - slightly modified
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Copyright 2003 by Chris Snyder (csnyder@chxo.com), http://chxo.com/chxo-scripts/safe_html
Free to use and redistribute, but see License and Disclaimer below
*/

function safe_html($html) {
	global $allowedtags, $opentags, $allowable_tags;
	
	if (!isset($allowedtags)) get_allowed_tags();
	if (!isset($allowable_tags)) include_once ABS_PATH . 'includes/allowable-tags-inc.php'; // $allowable_tags array
	
	// Check for obvious no no's and for no tags allowed at all
	if (!$allowedtags || js_and_entity_check($html)) {
		$html = strip_tags($html);
		return $html;
	} else {
		$allowed = '';
		foreach ($allowedtags AS $tag => $notused) {
			$allowed .= '<' . $allowedtags[$tag] . '>';
		}
		strip_tags($html, $allowed);
	}

	// also, lets get rid of some pesky attributes that may be set on the remaining tags...
	// this should be changed to keep_attributes($htmlm $goodattrs), or perhaps even better keep_attributes
	//  should be run first. then strip_attributes, if it finds any of those, should cause safe_html to strip all tags.
	$bad_attrs  = array("on\w+", "style", "fs\w+", "seek\w+");
	$html       = strip_attributes($html, $bad_attrs);
	
	
	// close html tags if necessary -- note that this WON'T be graceful formatting-wise, it just has to fix any maliciousness
	foreach ($allowedtags AS $tag=>$closeit) {
		if (!$closeit) continue;
	    $patternopen= "/<$tag\b[^>]*>/Ui";
	    $patternclose= "/<\/$tag\b[^>]*>/Ui";
	    $totalopen= preg_match_all ( $patternopen, $html, $matches );
	    $totalclose= preg_match_all ( $patternclose, $html, $matches2 );
	    if ($totalopen>$totalclose) {
			$html.= str_repeat("</$tag>", ($totalopen - $totalclose));
	    }
	}
  
/*
	$opentags = array();
	$i        = 0;
	foreach ($allowedtags as $tag => $notused) {
		if (!$allowable_tags[$tag]) continue; // Self closing tag
		
		$patternopen   = "/<$tag\b[^>]*>/Ui";
		$patternclose  = "/<\/$tag\b[^>]*>/Ui";
		$totalopen     = preg_match_all ($patternopen, $html, $matches);
		$totalclose    = preg_match_all ($patternclose, $html, $matches2);
		if ($totalopen > $totalclose) {
			/*$html .= str_repeat("</$tag>", ($totalopen - $totalclose));*/
			/*$opentags[$i] = "&lt;/$tag&gt;";
			$i++;
		}
	}
	if ($opentags) return $html;*/
	
	// check (again!) for obvious oh-no's that might have been caused by tag stipping
	if (js_and_entity_check($html)) {
		$html = strip_tags($html);
		
		return $html;
  	}
	return $html;
}

//   after stripping attributes, this function does a second pass
//   to ensure that the stripping operation didn't create an attack
//   vector.
function strip_attributes ($html, $attrs) {
	if (!is_array($attrs)) {
		$array  = array( "$attrs" );
		unset($attrs);
		$attrs  = $array;
	}
  
	foreach ($attrs AS $attribute) {
		// once for ", once for ', s makes the dot match linebreaks, too.
		$search[]  = "/" .$attribute. '\s*=\s*".+"/Uis';
		$search[]  = "/" .$attribute. "\s*=\s*'.+'/Uis";
		// and once more for unquoted attributes
		$search[]  = "/" .$attribute. "\s*=\s*\S+/i";
	}
	$html = preg_replace($search, "", $html);
	
	// do another pass and strip_tags() if matches are still found
	foreach ($search AS $pattern) {
		if (preg_match($pattern, $html)) {
			$html = strip_tags($html);
			break;
		}
	}
	return $html;
}

function js_and_entity_check( $html ) {
	// anything with ="javascript: is right out -- strip all tags if found
	$pattern = "/=[\S\s]*s\s*c\s*r\s*i\s*p\s*t\s*:\s*\S+/Ui";
	if (preg_match($pattern, $html)) {
		return TRUE;
	}
  
	// anything with encoded entites inside of tags is out, too
	$pattern = "/<[\S\s]*&#[x0-9]*[\S\s]*>/Ui";
	if (preg_match($pattern, $html)) {
		return TRUE;
	}
	return FALSE;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Scan comment for emoticon codes and convert to an img tag
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function emoticon_scan($input) {
	global $config;
	
	$file = ABS_PATH . "images/smilies/emoticons.inc.php";
	$handle = fopen($file, 'r') or fatal_error(0, 0, $lang['emoticon_err2']);
	while (!feof($handle)) {
		$buffer    = fgets($handle);
		$buffer    = trim(preg_replace('/(\n|\r)/', '', $buffer));
		if (substr($buffer, 0, 1) == '#' || !$buffer) continue;
		$buffer    = explode(',', $buffer);
		$buffer[0] = trim($buffer[0]);
		$key = preg_replace("/'/", '', trim($buffer[1]));
		$smilies[$key] = "<img src='".SITE_URL.TB_PATH. "images/smilies/" . $buffer[0] . "' alt='' />";
	}
	$input=str_replace(array_keys($smilies), array_values($smilies), $input);
	return $input;
}
?>