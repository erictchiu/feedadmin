<?
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Talkback addon RSS feed script
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	RSS reference: http://www.w3schools.com/rss/rss_reference.asp
	
	This script retrieves comment data from the TalkBack database and
	generates an RSS feed.
	
	Place this script in the TalkBack directory. The URL to the feed will
	be: http://yoursite.com/talkback/rss.php
	
	Add 
	                                                      Insert your site name     Insert correct path
	                                                              V                       V
	<link rel="alternate" type="application/rss+xml" title="Yoursite Guestbook" href="/talkback/rss.php">
	to the <head> section of your guestbook html file if you want visitors
	to be able to "discover" and subscribe to the feed. Don't do this 
	if you want to use the rss feed for yourself only.
	
	You can also use a feed publishing service such as:
	http://www.feedburner.com/
	"Allows weblog owners and podcasters the ability to manage their 
	RSS feeds and track usage of their subscribers."
	
	Browse to http://www.scripts.oldguy.us/rss.php using Firefox or your 
	RSS reader to see example output
	
	Edit the configuration lines below.
*/

$limit            = "LIMIT 10";  // Num of comments to publish (suggest it be same or less than your TB number of comments to show)
$size             = 0;           // Number of characters from each comment to be published, zero = entire comment
$ellipsis         = "";          // Change to "..." if you want the comment to be followed by an ellipsis
$title            = "Old Guy's Scripts Comments"; // whatever you want
$page             = "http://www.scripts.oldguy.us/comments/index.php"; // Link to the comments page
$desc             = "Feedback from users of my TalkBack comments/guestbook script";  // Whatever you want
$logo_url         = "http://www.scripts.oldguy.us/images/oldguy.gif"; // Your site's logo, optional can be 0

// Don't edit past here unless you know what you are doing
define('IS_VALID_INCLUDE', TRUE);

require_once 'config.php';
$dblink = open_db(1);
$config = get_config();

if ($logo_url) {
	$image = "
		<image>
			<title>$title</title>
			<url>$logo_url</url>
			<link>$page</link>
		</image>";
} else {
	$image = '';
}
		
print "<?xml version='1.0' encoding='utf-8'?>
<rss version='2.0'>
	<channel>
		<title>$title</title>
		<link>$page</link>
		<description>$desc</description>
		<pubDate>" .date('r') . "</pubDate>
		<language>en</language>
		<category>comments</category>
		$image";

// Retrieve comment data from the database
$result = mysql_query("SELECT id, replyto, text, author, author, subject, time, href FROM " . DBPREFIX . "data WHERE moderate=0 ORDER BY time DESC $limit") 
	or exit('Query 1 failed: ' . mysql_error());

while ($row = mysql_fetch_array($result)) {
	// Note that each comment begins with a <p> tag
	if ($size) $row['text'] = substr($row['text'],0,$size+3) . $ellipsis . '</p>';
	print "
		<item>
			<title>Subject: {$row['subject']}</title>
			<link>$page</link>
			<pubDate>" 
			. date('r', $row['time']) 
			. "</pubDate>
			<author>{$row['author']}@foo.com</author>
			<description>
			";
	print $row['text'];
	print "
			</description>
		</item>";
}

print "
	</channel>
</rss>";