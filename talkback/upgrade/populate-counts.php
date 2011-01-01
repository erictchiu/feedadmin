<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Populate the href comment counts table
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

ini_set('error_reporting', E_ALL ^ E_NOTICE);
defined('IS_VALID_INCLUDE') or define('IS_VALID_INCLUDE', TRUE);

defined('SETUP_DONE') or require_once 'config.php';

echo "Updating articles table<br /><br />";

$dblink = open_db(0);

$result = mysql_query("UPDATE " . DBPREFIX . "articles SET com_count=0",$dblink);

$i = 0;
$result = mysql_query("SELECT href FROM " . DBPREFIX . "data",$dblink);
while (list($page) = mysql_fetch_array($result)) {
	update_comment_count($page, 'add');
	$i++;
}
echo $i . " comments were counted<br /><br />Finished";
?>