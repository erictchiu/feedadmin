<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Display snippet of text (a teaser) from latest comment
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Read the user guide /doc/teaser.html for more information.
	Create the following styles in your website stylesheet if you want to style the teaser:
	   .teaser-paragraph
	   .teaser-title
	   .teaser-snippet
	Or, change the style names in the HTML tags below to styles you have already defined
	in your stylesheet.
*/
defined('IS_VALID_INCLUDE') or define('IS_VALID_INCLUDE', true);

$teaser_length  = 50;
$teaser_link    = "Read more &raquo;";
$teaser_title   = "Latest guestbook entry:";
$num_comments   = 5;

include_once 'config.php';

$limit = $num_comments + 100;
$result = mysql_query("SELECT text, href FROM " . DBPREFIX . "data WHERE moderate='0' AND id=replyto ORDER BY time DESC LIMIT $limit", $dblink);

$count = 0;
while (list($text, $href) = mysql_fetch_array($result)) {
	
	if (ereg("(<a|<img|<block|<ul|<ol)", $text) || !$text) continue;
	
	$title = ($count != 0) ? '' : $teaser_title;
	$text = preg_replace('#(<p>|</p>)#i', '', $text);
	$text = substr($text,0,$teaser_length);

	// Add entries for these style names to *your* stylesheet (not TalkBack's stylesheet)
	// Or using existing styles from your stylesheet
	// You can also alter the format/layout of the teaser html
	print "
	<div class='teaser'>
		<div class='teaser-title'><strong>$title</strong></div>
		<div class='teaser-snippet'>$text...</div>
		<div><a href='$href'>$teaser_link</a></div>
	</div>";
	$count++;
	
	if ($count >= $num_comments) break;
}
?>