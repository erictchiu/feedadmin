<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Cummulative database updates for version 2.3.0
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
ini_set('error_reporting', E_ALL & ~E_NOTICE);
define('IS_VALID_INCLUDE', TRUE);

require 'config.php';
require 'language/' . DEFAULT_LANGUAGE. '.php';
require 'version.php';
$db_version = $config['db_version'];

echo "TalkBack cummulative database upgrade.<br /><br />";

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	version 2.0
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
$result = addField('data', 'email_reply', "TINYINT( 1 ) NOT NULL DEFAULT '0'");
addConfig('sort_order_line', 'always');
addConfig('comments_emoticons', '1');
addConfig('comments_display_tpl', 'comments-display-tpl.php');
addConfig('comments_form_tpl', 'comments-form-tpl.php');
addConfig('preview_panel_tpl', 'comments-preview.php');
addConfig('reply_panel_tpl', 'comments-reply-tpl.php');
addConfig('help_panel_tpl', 'comments-help.php');

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	version 2.1
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
addConfig('date_locale', '');

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	version 2.2
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
$result = addField('data', 'user_agent', "varchar(255) NOT NULL DEFAULT ''");
$result = addField('spam', 'user_agent', "varchar(255) NOT NULL DEFAULT ''");
$result = addField('data', 'location', "varchar(64) NOT NULL DEFAULT ''");
$result = addField('data', 'subject', "varchar(128) NOT NULL DEFAULT ''");

deleteConfig('talkback_path');
deleteConfig('message_panel_tpl');
deleteConfig('admin_email');
deleteConfig('testing');

addConfig('user_agent_days', '30');
addConfig('files_directory', '');
addConfig('discard_spam', '0');
addConfig('bad_words', '0');
$result = @mysql_query("ALTER TABLE " . DBPREFIX . "config CHANGE `option_data` `option_data` VARCHAR( 255 ) NOT NULL default ''", $dblink);

// 2.2b4
addConfig('comments_driver', 'comments.php');
addConfig('comment_subject', '1');
addConfig('author_location', '1');
addConfig('author_website', '1');
addConfig('comments_subscribe', '1');
addConfig('allow_replies', '1');
addConfig('lightbox', '1');
addConfig('mysqldump_path', '/usr/bin/mysqldump');
addConfig('author_website_link', '3');
reformatAllowedTags();
addConfig('comments_legend', 1);

// 2.2b5
$result = @mysql_query("ALTER TABLE " . DBPREFIX . "spam DROP INDEX time, ADD INDEX time (time)", $dblink);

if (tableExists("" . DBPREFIX . "counts")) $result = @mysql_query("DROP TABLE " . DBPREFIX . "counts", $dblink);
if(!$result) print mysql_error();

$result = @mysql_query("CREATE TABLE " . DBPREFIX . "articles (
  `ID` bigint(20) NOT NULL auto_increment,
  `href` varchar(255) NOT NULL,
  `com_count` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `summary` text NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `href` (`href`) )", $dblink);
if($result) {
	echo "Created articles table<br /><br />";
	$did_something = 1;
}
$result = addField('spam', 'article_title', "varchar(255) NOT NULL DEFAULT ''");

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	version 2.3.0
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
addConfig('captcha', '0');
addConfig('captcha_public', '');
addConfig('captcha_private', '');
addConfig('spamwords', '0');
addConfig('use_pages', '0');
addConfig('comment_search', '0');
addConfig('log_errors', '0');
addConfig('errorlog_filename', 'tb_error.log');
addConfig('gravatar', '0');
addConfig('gravatar_size', '40');
addConfig('gravatar_rating', 'G');

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	version 2.3.8
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
$result = @mysql_query("ALTER TABLE " . DBPREFIX . "data DROP INDEX text", $dblink);
if($result) {
	echo "Dropped FULLTEXT index 'text'<br /><br />";
	$did_something = 1;
}
$result = mysql_query("ALTER TABLE " . DBPREFIX . "data ADD FULLTEXT search (text,subject,author)", $dblink);
if($result) {
	echo "Added FULLTEXT index 'search'<br /><br />";
	$did_something = 1;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	wrapup
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
if ($did_something) {
	echo "Upgrade finished. Database version is now: $db_version";
} else {
	echo 'Your database is up-to-date - no updates were applied';
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	functions
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

function addConfig($key, $value) {
	global $config, $dblink, $did_something;
	
	$result = mysql_query("SELECT * FROM " . DBPREFIX . "config WHERE option_name='$key' LIMIT 1", $dblink);
	if (!$result) echo mysql_error() . '<br /><br />';
	
	if (!mysql_num_rows($result)) {
		$result = mysql_query("INSERT INTO " . DBPREFIX . "config VALUES (NULL, '$key', '$value')", $dblink);
		if (!$result) {
		  	echo mysql_error() . '<br /><br />';
		} else {
			echo "Added '$key' configuration setting<br /><br />";
			$did_something = 1;
		}
	}
}

function deleteConfig ($key) {
	global $config, $dblink, $did_something;
	
	$result = mysql_query("SELECT id FROM " . DBPREFIX . "config WHERE option_name='$key' LIMIT 1", $dblink);
	if (!$result) echo mysql_error() . '<br /><br />';
	
	if (mysql_num_rows($result)) {
		$tbid = mysql_fetch_row($result);
		$result = mysql_query("DELETE FROM " . DBPREFIX . "config WHERE id='{$tbid[0]}' ", $dblink);
		if (!$result) {
			exit("Error 3d - " . mysql_error()); 
		} else {
			echo "Removed '$key' configuration entry<br /><br />";
		}
		$did_something = 1;
	}
}

function addField($table, $name, $string) {
	global $config, $dblink, $did_something;
	
	$result=mysql_query("SHOW COLUMNS FROM " . DBPREFIX . "$table LIKE '$name'", $dblink);
	if (!$result) echo mysql_error() . '<br /><br />';
	
	if (!mysql_num_rows($result)) {
		$result=mysql_query("ALTER TABLE " . DBPREFIX . "$table ADD $name $string ",$dblink);
		if (!$result) {
			echo mysql_error() . '<br /><br />';
		} else {
			echo "Added '$name' to table '$table'<br /><br />";
			$did_something = 1;
		}
	}
}

function reformatAllowedTags() {
	global $config, $dblink, $did_something;
	
	$result=mysql_query("SELECT option_data FROM " .DBPREFIX. "config WHERE option_name='allowed_tags' LIMIT 1 ",$dblink);
	if (!$result) exit(mysql_error());
	
	$row = mysql_fetch_row($result);
	if (!$row[0]) return;
	if (!preg_match('/(&lt;)/', $row[0], $matches)) return;
	
	$row[0]  = preg_replace('/(&lt;)/',  '', $row[0]);
	$row[0]  = preg_replace('/(&gt;)/',  ',', $row[0]);
	$row[0] .= '<,>';
	
	$result=mysql_query("UPDATE " .DBPREFIX. "config SET option_data='{$row[0]}'WHERE option_name='allowed_tags' LIMIT 1 ",$dblink);
	if (!$result) exit(mysql_error());
	echo "Reformatted allowed_tags<br /><br />";
	$did_something = 1;
}

function tableExists($tableName) {
	global $dblink, $config;

	$result = mysql_query("SHOW TABLES FROM " .DBNAME. " LIKE '$tableName'", $dblink);
	if (!$result) print 'xxx '.mysql_error();
	if (mysql_num_rows($result)) return 1;;
	return 0;
}
?>