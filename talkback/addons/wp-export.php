<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copies comments from WordPress database to TalkBack database
	The WP database is not changed (the exported comments are not deleted)
	Recommend you backup up your TB dabase first.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Edit these WordPress configuraton entries

define('DB_NAME', 'wp');       // the name of the database
define('DB_USER', 'name');     // your MySQL username
define('DB_PASSWORD', 'password');     // your mysql password
define('DB_HOST', 'localhost');  // your mysql server name
$table_prefix  = 'wp_';        // the table name prefix
$wp_path       = '/blog/';     // path to the wordpress directory

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

require 'config.php';
require_once 'includes/functionsEmoticons.php';  // Replace smiley codes with img tags
require_once 'comments-validate-functions.php';

$wplink   = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, true);
if (!$wplink) exit("<br />Cannot access the WordPress mysql server - mysql_error =<br /><br />" . mysql_error());

$result   = mysql_SELECT_db(DB_NAME, $wplink);
if (!$result) exit("<br />Cannot access the WordPress database - mysql_error =<br /><br />" . mysql_error());

$table    = $table_prefix . 'comments';
$wpresult = mysql_query("SELECT comment_date, comment_post_ID, comment_content, comment_author, comment_author_email, comment_author_url, comment_author_IP 
				FROM $table WHERE comment_approved = '1' AND comment_type = '' ", $wplink);
if (!$wpresult) exit("<br />Cannot select from the WordPress comments table - mysql_error =<br /><br />" . mysql_error());

$tblink = @mysql_connect(DBHOST,DBUSER,DBPASS, true);
if (!$tblink) exit("Cannot access the mysql server - mysql_error =<br /><br />" . mysql_error());

$result   = mysql_SELECT_db(DBNAME, $tblink);
if (!$result) exit("<br />Cannot access the TalkBack database - mysql_error =<br /><br />" . mysql_error());

$dblink = $tblink;
$count = 0;
while(list($date, $post_id, $content, $author, $email, $url, $ip) = mysql_fetch_array($wpresult)) {
	$table    = $table_prefix . 'posts';
	$presult  = mysql_query("SELECT post_title, post_status FROM $table WHERE ID = '$post_id' LIMIT 1", $wplink);
	if (!$presult) exit("<br />Cannot select $post_id  from posts table - mysql_error =<br /><br />" . mysql_error());
	$row     = mysql_fetch_row($presult);
	if (!$row || $row[1] != 'publish') continue;
	
	$content          = formatCommentText($content);
	$date             = mysql_real_escape_string(strtotime($date));
	$post_id          = mysql_real_escape_string($post_id);
	$content          = mysql_real_escape_string($content);
	$author           = mysql_real_escape_string($author);
	$email            = mysql_real_escape_string($email);
	$url              = mysql_real_escape_string($url);
	$ip               = mysql_real_escape_string($ip);
	$article_title    = mysql_real_escape_string($row[0]);

	$post_id = "{$wp_path}?p=$post_id";
	$tbresult = mysql_query("INSERT INTO " . DBPREFIX . "data SET
									time           = '$date',
									href           = '$post_id',
									text           = '$content',
									author         = '$author',
									email          = '$email',
									website        = '$url',
									ip             = '$ip'
									", $tblink);
	if (!$tbresult) exit("<br />Cannot insert into the TalkBack comments table - mysql_error =<br /><br />" . mysql_error());
	
	$tbid = mysql_insert_id($tblink);
	$tbresult = mysql_query("UPDATE " . DBPREFIX . "data SET replyto='$tbid' WHERE ID='$tbid' LIMIT 1", $tblink);
	if (!$tbresult) exit("<br />Cannot update the TalkBack comments table - mysql_error =<br /><br />" . mysql_error());
	
	update_comment_count($post_id, 'add');
	
	$count++;
}

echo $count . ' comments inserted in the TalkBack database<br /><br />All done';

?>