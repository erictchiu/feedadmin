<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	recent comments mod
	Select and print a specified number of the most recent comments 
   ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
define('IS_VALID_INCLUDE', TRUE);

$num_comments   = 15;                   // Number of comments to select
$page_legend    = 'Comments on page:';  // precedes page url on the list, e.g. Comments on page: /guestbook.php
$subject_title  = 'Subject:';           // precedes the comment subject
$groupby_page   = 'N';                  // Y = list is sorted by page ascending, date descending
                                        // N = list is sorted by date descending
$show_link      = 0;                    // 1 = always show the page link
                                        // 0 = only if it is different from the comment above
$length         = 0;                    // Number of characters of comment to display. 0 = display entire comment.

// Convert page URL's to a page name
$conv_table =		array(
							'/guestbook.php'      => 'Guestbook',
						);

// Exclude comments on specified pages
$exclude_page =	array(
							'/talkback/test.php',
						);

// Exclude comments on all pages in specified directories
$exclude_dir =		array(
						);
	
/*	
 +++++++++++++++++++++++++++++ Examples +++++++++++++++++++++++++++++
$conv_table =		array(
							'/guestbook.php'      => 'Guestbook',
						);

$exclude_dir =		array(
							'/dir1/',
							'/dir1/dir1/',
						);
   ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	You probably don't want to mess with anything below here
   ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

require_once (dirname(__FILE__)) . '/config.php';
require_once 'includes/functions.php';

// Get language file (used by open_db() if there's an error)
setup_language();
require_once LANGUAGE_FILE;

$dblink = open_db(0); // If error it displays message then dies

get_config(); // Get additional config data from database

// Is TalkBack in maintenance mode?
$admin= get_admin_cookie(); 
if (!$admin&& $config['maintenance']) {
	// Show "doing maintenance" message is visitor does not have admin cookie
	require 'comments-maintnenace.php';
	exit();
}

// Exclude specified pages
$first     = 1;
$exclude_pages  = 'WHERE moderate=0';
foreach($exclude_page as $value) {
	$exclude_pages .= " AND href != '$value' ";
	if ($first) {
		$first = 0;
	}
}

// Exclude specified directories
foreach($exclude_dir as $value) {
	$exclude_pages .= " AND href NOT REGEXP '($value)' ";
	if ($first) {
		$first = 0;
	}
}

// Sort the comments by date/time descending and select the first n comments from that result
$query = "SELECT id, time, text, author, location, subject, href, id, replyto 
				FROM " . DBPREFIX . "data 
				$exclude_pages 
				ORDER BY time DESC 
				LIMIT $num_comments";

$result = mysql_query($query, $dblink);
if (!$result) fatal_error(0, 0, 'DB query error, recent-comments.php 1<br /> mysql error:<br />' . mysql_error());

$i = 0;
// Put the fields from selected comments into arrays
while (list($tbid[$i], $time[$i], $text[$i], $author[$i], $location[$i], $subject[$i], $page[$i], $tbid[$i], $replyto[$i]) = mysql_fetch_array($result)) {

	if ($length) $text[$i] = substr($text[$i], 0, $length) . '...';

	// Add date/time to the page key so we'll get comments within page sorted by date/time
	$page[$i] = $page[$i] . ':' . $time[$i];		
	$i++;
}

unset($page[$i]); // Delete the last (0) entry in the page array
if ($groupby_page == 'Y') arsort($page); 
$prior_page  = '';

// Print the comments
print "
<div id='tb-wrapper'>";

// For each comment in the $page array
foreach ($page as $pgkey => $pgurl) {

	// Remove the date/time from the page url
	$pieces  = explode(':', $pgurl);
	$pgurl   = $pieces[0];
	
	// Format the date/time
	$time[$pgkey] = ucwords(strftime($config['comments_date'], $time[$pgkey])); 
	
	// If location is not 0 put a dash before the location
	if ($location[$pgkey]) $location[$pgkey] = " &ndash; {$location[$pgkey]}"; 
	 
	// If comment is a reply add name or original comment author after location
	if ($tbid[$pgkey] != $replyto[$pgkey]) {
		$result = mysql_query("SELECT author FROM " . DBPREFIX . "data WHERE id='{$replyto[$pgkey]}' LIMIT 1", $dblink);
		if (!$result) fatal_error(0, 0, 'DB query error, recent-comments.php 2<br /> mysql error:<br />' . mysql_error());
		$row               = mysql_fetch_row($result);
		$location[$pgkey] .= " (reply to {$row[0]})";
	}

	// Format the comment legend (page url line)
	if (!$show_link && $pgurl == $prior_page) {
		// Clear the line if it is same page as prior comment
		$page_url = '';
	} else {
		if (isset($conv_table[$pgurl])) {
			// Replace url with page name
			$page_name[$pgkey]  = $conv_table[$pgurl];
		} else {
			$page_name[$pgkey]  = $pgurl;
		}
		
		$page_url[$pgkey]      = $pgurl;
		$legend[$pgkey]        = $page_legend;
		$prior_page            = $pgurl;
	}
	
require 'recent-tpl.php';
}
	
	print "
</div> <!--end of tb-wrapper -->";
?>