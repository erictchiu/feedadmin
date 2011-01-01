<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The driver script for displaying comments via comments-display-tpl.php
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

// Show "doing maintenance" message
$admin = get_admin_cookie();
if (!$admin && $config['maintenance']) {
	require 'comments-maintnenace.php';
	exit();
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Paginate
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// Get total number of comments
$query_url = mysql_real_escape_string($_REQUEST['article_url']);
$result = mysql_query("SELECT COUNT(ID) FROM " . DBPREFIX . "data WHERE href='$query_url' AND moderate=0", $dblink);
if (!$result) fatal_error(0, 0, 'DB query error, comments-display-prep 1<br /> mysql error:<br />' . mysql_error());

list($total_rows) = mysql_fetch_row($result);

// Set number of comments per page
if ($_REQUEST['numrows']) {
	$first_time = false;
	$num_rows     = $_REQUEST['numrows'];
} elseif ($cookie['num_rows']){
	$first_time = false;
	$num_rows     = $cookie['num_rows'];
} else {
	$first_time = true;
	$num_rows     = $config['page_limit'];
}

// Setup the next/previous page links
// Yeah, it's cryptic. I was tired when I coded it. Next day I said to myself, WTF?
// But it works & when it ain't broke, I don't fix it.
$prev_link = 0;
$next_link = 0;
$row_start = 0;

if ($first_time || isset($_REQUEST['first'])) {
	if ($total_rows > $num_rows) {
		$next_link = 1;
		$last_link = 1;
	}
} elseif (isset($_REQUEST['last'])) {
	if ($total_rows > $num_rows) {
		$prev_link  = 1;
		$first_link = 1;
	}
	$row_start     = ($total_rows/$num_rows*$num_rows)-($total_rows % $num_rows);
	if ($row_start == $total_rows) $row_start = $row_start - $num_rows;
	if ($row_start < 0) $row_start = 0;
} else {
	$last_start    = $_REQUEST['rowstart'];
	$last_end      = $_REQUEST['rowend'];
	if ($_REQUEST['next']) {
		$row_start  = $last_end;
	} else {
		$row_start = $last_start - $num_rows;
	}
	if ($row_start < 0) $row_start = 0;
	if ($row_start + $num_rows < $total_rows) $next_link = 1;
	if ($row_start > 0) $prev_link = 1; 
	
}

// For those who want to show total pages instead of total rows
$total_pages = ceil($total_rows/$num_rows);
if ($row_start == 0) {
	$current_page = 1;
} else {
	$current_page = ceil($row_start/$num_rows+.5);
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Set the sort order
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
if ($_REQUEST['sortorder'] &&  ($_REQUEST['sortorder'] == 'DESC' || $_REQUEST['sortorder'] == 'ASC')){
	$sort_order = $_REQUEST['sortorder'];
} elseif ($cookie['sort_order']){
	$sort_order = mysql_escape_string($cookie['sort_order']);
} else {
	$sort_order = 'DESC';
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Get and format the comments to be displayed on the current page
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
$row_start  = mysql_real_escape_string($row_start);
$num_rows   = mysql_real_escape_string($num_rows);
$limit      = "LIMIT $row_start, $num_rows";

// sorting by replyto/ID places all replies to a comment immediately after the comment being replied to
$result = mysql_query("SELECT ID, time, text, author, email, website, replyto, location, subject FROM " . DBPREFIX . "data WHERE href='$query_url' AND moderate=0 ORDER BY replyto $sort_order, ID $limit ", $dblink);
if (!$result) fatal_error(0, 0, 'DB query error, comments-display-prep 2<br /> mysql error:<br />' . mysql_error());

// Values to be used next time through this routine
$_REQUEST['rowstart']   = $row_start;
$_REQUEST['rowend']     = $row_start + $num_rows;
$_REQUEST['numrows']    = $num_rows;
$_REQUEST['sortorder']  = $sort_order;

// hidden values common to all comments display forms
$common = "<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
				<input type='hidden' name='article_url' value='{$_REQUEST['article_url']}' /> 
				<input type='hidden' name='sortorder' value='{$_REQUEST['sortorder']}' />
				<input type='hidden' name='rowstart' value='{$_REQUEST['rowstart']}' />
				<input type='hidden' name='rowend' value='{$_REQUEST['rowend']}' />
				<input type='hidden' name='numrows' value='{$_REQUEST['numrows']}'  />
				<input type='hidden' name='language' value='{$_REQUEST['language']}' />
				<input type='hidden' name='show_captcha' value='{$_REQUEST['show_captcha']}' />";
				
$row_count = mysql_num_rows($result);

$ccount = 0;
$tbid=$time=$text=$author=$email=$website=$replyto=$location=$subject=array();
while (list($tbid[$ccount], $time[$ccount], $text[$ccount], $author[$ccount], $email[$ccount], $website[$ccount], $replyto[$ccount], $location[$ccount], $subject[$ccount]) = mysql_fetch_array($result)) {
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		Format the comments
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	// Give  administrator's comments a different class
	if ($email[$ccount] == ADMIN_EMAIL && $author[$ccount] == $config['admin_name']) {
			$header_class[$ccount]       = 'tb-comment-header-admin';
			$author_loc_class[$ccount]   = 'tb-author-loc-admin';
			$author_class[$ccount]       = 'tb-author-admin';
			$location_class[$ccount]     = 'tb-location-admin';
			$date_class[$ccount]         = 'tb-date-admin';
			$tbid_class[$ccount]           = 'tb-id-admin';
			$subject_class[$ccount]      = 'tb-comment-subject-admin';
			$subject_title_class[$ccount] = 'tb-comment-subject-title-admin';
			$comment_class[$ccount]      = 'tb-comment-text-admin';
		} else {
			$header_class[$ccount]       = 'tb-comment-header';
			$author_loc_class[$ccount]   = 'tb-author-loc';
			$author_class[$ccount]       = 'tb-author';
			$location_class[$ccount]     = 'tb-location';
			$date_class[$ccount]         = 'tb-date';
			$tbid_class[$ccount]           = 'tb-id';
			$subject_class[$ccount]      = 'tb-comment-subject';
			$subject_title_class[$ccount] = 'tb-comment-subject-title';
			$comment_class[$ccount]      = 'tb-comment-text';
	}
	
	// format the date/time
	$time[$ccount] = ucwords(strftime($config['comments_date'], $time[$ccount])); 
	
	// format the subject
	if ($config['comment_subject']) {
		$subject_content[$ccount] = $subject[$ccount];
		$subject_title [$ccount]  = $lang['subject'];
	}
	
	// Differentiate original comments from replies
	if ($tbid[$ccount] != $replyto[$ccount]) {
		// it is a reply
		$replyto_link[$ccount]         = '';
		$comment_type_class[$ccount]   = "class='tb-reply' ";
		$reply_legend[$ccount]         =  $lang['reply_legend'];
		$query = mysql_query("SELECT author FROM " . DBPREFIX . "data WHERE id='{$replyto[$ccount]}' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, comments-display-prep 3 <br /> mysql error:<br />' . mysql_error()); 
		$row                           = mysql_fetch_row($query);
		$original_author[$ccount]      = $row[0];
	} else {
		// it is an original comment
		$comment_type_class[$ccount]   = "class='tb-comment' ";
		$reply_legend[$ccount]         = "";
		$original_author[$ccount]      = '';
		// Create the reply to link
		$replyto_link[$ccount]         = ($config['allow_replies'] || get_admin_cookie()) ? "
			<form class='tb-replyto-link' action='".COMMENTS_DRIVER."'  method='post'>
				$common
				<input type='hidden' name='reply' value='reply' /> 
				<input type='hidden' name='form_replyto' value='{$tbid[$ccount]}' />
				<input class='tb-submit' type='submit' value='{$lang['replyto_link']}'  onmouseover=\"this.className='tb-submit-hover'\" onmouseout=\"this.className='tb-submit'\" />
			</form>" : '';
	}
	
	// If user is admin, create edit and delete links
	if (get_admin_cookie()) {
		$edit_link[$ccount] = "
			<form class='tb-edit-link' action='".COMMENTS_DRIVER."'  method='post'>
				$common
				<input type='hidden' name='edit' value='edit' /> 
				<input type='hidden' name='edit_id' value='{$tbid[$ccount]}' />
				<input type='hidden' name='language' value='{$_REQUEST['language']}' /> 
				<input class='tb-submit' type='submit' value='{$lang['edit_link']}'  onmouseover=\"this.className='tb-submit-hover'\" onmouseout=\"this.className='tb-submit'\"  />
			</form>";
		$delete_link[$ccount] = "
			<form class='tb-delete-link' action='".COMMENTS_DRIVER."'  method='post'>
				$common
				<input type='hidden' name='delete' value='delete' />
				<input type='hidden' name='edit_id' value='{$tbid[$ccount]}' /> 
				<input type='hidden' name='rowcount' value='$row_count' /> 
				<input type='hidden' name='language' value='{$_REQUEST['language']}' /> 
				<input class='tb-submit' type='submit' value='{$lang['delete_link']}' onclick='return confirmSubmit()'  onmouseover=\"this.className='tb-submit-hover'\" onmouseout=\"this.className='tb-submit'\"  />
			</form>";
		$spam_link[$ccount] = "
			<form class='tb-spam-link' action='".TB_PATH."admin/index.php'  method='post'>
				$common
				<input type='hidden' name='action' value='delete' />
				<input type='hidden' name='id' value='{$tbid[$ccount]}' /> 
				<input type='hidden' name='return' value='comments' /> 
				<input type='hidden' name='spam' value='spam' /> 
				<input type='hidden' name='rowcount' value='$row_count' /> 
				<input type='hidden' name='language' value='{$_REQUEST['language']}' /> 
				<input class='tb-submit' type='submit' value='{$lang['comment_spam_link']}' onclick='return confirmSubmit()'  onmouseover=\"this.className='tb-submit-hover'\" onmouseout=\"this.className='tb-submit'\" />
			</form>";			
	} else {
		$edit_link[$ccount]    = '';
		$delete_link[$ccount]  = '';
		$spam_link[$ccount]    = '';
	}
	
	// Do we show the author website:
	$website[$ccount] = ($config['author_website']) ? $website[$ccount] : '';
	
	// Format the author field
	if ($website[$ccount]) {
		$target = ($config['comments_link_target'] == 1) ? "target='_blank'" : '';
		if ($config['author_website_link'] == 1) {
			$author[$ccount] = "<a href='{$website[$ccount]}' $target><img src='" .TB_PATH. "images/link1.gif' alt='' align='top' /></a> {$author[$ccount]}";
		} elseif ($config['author_website_link'] == 2) {
			$author[$ccount] = "<a href='{$website[$ccount]}' $target><img src='" .TB_PATH. "images/link2.gif' alt='' align='top' /></a> {$author[$ccount]}";
		} elseif ($config['author_website_link'] == 3) {
			$author[$ccount] = "<a href='{$website[$ccount]}' $target>{$author[$ccount]}</a>";
		} // else we just display author name without a link
	}
	
	// Show author location in comment header?
	$location[$ccount] = ($config['author_location'] && $location[$ccount]) ? " &ndash; {$location[$ccount]}" : '';
	
	// Create gravatar
	if ($config['gravatar']) {
		$grav_email = $email[$ccount];
		$grav_default = "http://" . URL_PATH . "images/unknown-{$config['gravatar_size']}.jpg";
		
		$grav_url[$ccount] = "http://www.gravatar.com/avatar.php?gravatar_id="
			. md5($grav_email)
			. "&amp;default=" . urlencode($grav_default)
			. "&amp;size="    . $config['gravatar_size']
			. "&amp;rating="  . $config['gravatar_rating'];
	}
	$ccount++;
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Format other elements
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// These 2 variables are for the "Showing n-n of n Comments" legend
$last_row   = $row_start + $ccount;
$first_row  = $row_start +1;

// Set the prior/next line variables
$priornext_hidden_fields = $common;

// Set the comment entry form fields
$comment_form_hidden_fields   = "<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
			<input type='hidden' name='article_url' value='{$_REQUEST['article_url']}' /> 
			<input type='hidden' name='reply' value='{$_REQUEST['reply']}' /> 
			<input type='hidden' name='edit' value='{$_REQUEST['edit']}' /> 
			<input type='hidden' name='sortorder' value='{$_REQUEST['sortorder']}' />
			<input type='hidden' name='rowstart' value='{$_REQUEST['rowstart']}' />
			<input type='hidden' name='rowend' value='{$_REQUEST['rowend']}' />
			<input type='hidden' name='numrows' value='{$_REQUEST['numrows']}'  /> 
			<input type='hidden' name='language' value='{$_REQUEST['language']}' />
			<input type='hidden' name='article_title' value='{$_REQUEST['article_title']}' />";
			
if ($cookie['rememberme']) {
	$_REQUEST['form_author']      = stripslashes($cookie['author_name']);
	$_REQUEST['form_email']       = stripslashes($cookie['author_email']);
	$_REQUEST['form_website']     = stripslashes($cookie['author_website']);
	$_REQUEST['form_location']    = stripslashes($cookie['author_location']);
}

if (!$_REQUEST['form_website']) $_REQUEST['form_website'] = 'http://';

$_REQUEST['form_replyto']     = '';
$_REQUEST['form_subject']     = '';
$_REQUEST['form_textarea']    = '';
$comment_size                 = '';
$subscribed3_check				= "checked='checked'";
$subscribed1_check				= '';
$subscribed2_check				= '';
$rememberme_check             = ($cookie['rememberme']) ? "checked='checked'" : '';
// Set the sort order line variables
$sort_order_hidden_fields = "<input type='hidden' name='page' value='{$_REQUEST['page']}' /> 
		<input type='hidden' name='article_url' value='{$_REQUEST['article_url']}' /> 
		<input type='hidden' name='language' value='{$_REQUEST['language']}' />
		<input type='hidden' name='form_author' value='{$_REQUEST['form_author']}' />
	 	<input type='hidden' name='form_email' value ='{$_REQUEST['form_email']}' />
		<input type='hidden' name='form_website' value='{$_REQUEST['form_website']}' /> 
		<input type='hidden' name='form_location' value='{$_REQUEST['form_location']}' />
		<input type='hidden' name='form_rememberme' value='{$cookie['rememberme']}' />
		<input type='hidden' name='article_title' value='{$_REQUEST['article_title']}' />";
$radio1     = ($sort_order == 'DESC') ? "value='DESC' checked='checked' " : "value='DESC' ";
$radio2     = ($sort_order == 'ASC') ? "value='ASC' checked='checked' " : "value='ASC' ";

$spam_count  = number_format($config['spam_count']);

// Create language selection links if there are multiple languages

if ($handle = opendir(ABS_PATH.'language')) {
	$i         = 0;
	$language_links  = '';
	while (false !== ($file = readdir($handle))) {
		if (ereg('.php',$file) && !ereg('my-',$file) && !ereg('language-codes',$file)) { // e.g. include english.php, exclude my-english.php
			$parts      = explode('.', $file); // separate file name from extension
			$language_links .= "<a href='{$_REQUEST['page']}?language={$parts[0]}' title='{$parts[0]}'><img src='" .TB_PATH. "language/{$parts[0]}.gif' alt='' /></a>&nbsp;";
			$i++;
		}
	}
	if ($i <= 1) $language_links = ''; // No link if only one laguage file in the directory
}

// Create the search help links
$h1 = "<a href=\"" .TB_PATH. "comments-help.php?";
$h2 = "&amp;language={$_REQUEST['language']}&amp;keepThis=true&amp;TB_iframe=true\" title='' class='thickbox  help'>?</a>";
$search_help = "{$h1}height=350&amp;width=500&amp;name=csh_help{$h2}";
?>