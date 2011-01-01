<?php 
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Validate the form data and create config.php and config table entries
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

require '../includes/functions.php';
require '../includes/functions-array.php';
$installing = true;

//	Create the tables
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$dblink = mysql_connect($_POST['dbhost'],$_POST['dbuser'],$_POST['dbpassword']);
if (mysql_error()) {
	print  mysql_error() . "<br /><br />{$lang['aborted']}";
	exit();
}
else {
	print "{$lang['successful_connect']}<br />";
}

mysql_SELECT_db($_POST['dbname'], $dblink);
if (mysql_error()) {
	print  mysql_error() . "<br /><br />{$lang['aborted']}";
	exit();
} else {
	print "{$lang['successful_access']}<br />";
}

mysql_query("DROP TABLE IF EXISTS {$_POST['dbprefix']}data", $dblink);
mysql_query("CREATE TABLE {$_POST['dbprefix']}data (
  `ID` bigint(20) NOT NULL auto_increment,
  `replyto` bigint(20) NOT NULL default '0',
  `time` int (11) NOT NULL default '0',
  `href` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `website` varchar(255) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `moderate` tinyint(1) NOT NULL default '0',
  `email_reply` tinyint(1) NOT NULL default '0',
  `user_agent` varchar(255) NOT NULL default '',
  `location` varchar(64) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
	PRIMARY KEY  (`ID`),
	KEY `time` (`time`),
	KEY `href` (`href`),
	FULLTEXT KEY `search` (`text`,`subject`, `author`)
	)", $dblink);
if (mysql_error()) {
	if (!mysql_errno() == 1050) { // if the table already exists
		print  mysql_error() . "<br /><br />{$lang['aborted']}";
		exit();
	} else {
		print "{$_POST['dbprefix']}data - {$lang['table_exists']}<br />\n";
	}
} else {
	print "{$lang['table']} {$_POST['dbprefix']}data<br />\n";
}

mysql_query("DROP TABLE IF EXISTS {$_POST['dbprefix']}spam", $dblink);
mysql_query("CREATE TABLE {$_POST['dbprefix']}spam (
  `ID` bigint(20) NOT NULL auto_increment,
  `replyto` bigint(20) NOT NULL default '0',
  `time` int (11) NOT NULL default '0',
  `href` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `website` varchar(255) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `user_agent` varchar(255) NOT NULL default '',
  `article_title` varchar(255) NOT NULL Default '',
  PRIMARY KEY  (`ID`),
  KEY `time` (`time`),
  KEY `href` (`href`)
	)", $dblink);
if (mysql_error()) {
	if (!mysql_errno() == 1050) { // if the table already exists
		print  mysql_error() . "<br /><br />{$lang['aborted']}";
		exit();
	} else {
		print "{$_POST['dbprefix']}data - {$lang['table_exists']}<br />\n";
	}
} else {
	print "{$lang['table']} {$_POST['dbprefix']}spam<br />\n";
}

mysql_query("DROP TABLE IF EXISTS {$_POST['dbprefix']}subscribers", $dblink);
mysql_query("CREATE TABLE {$_POST['dbprefix']}subscribers (
  `ID` bigint(20) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `href` varchar(255) NOT NULL default '',
  `hash` varchar(255) NOT NULL default '',
  `time` int (11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `href` (`href`),
  KEY `email` (`email`)
)", $dblink);
if (mysql_error()) {
	if (!mysql_errno() == 1050) {
		print  mysql_error() . "<br /><br />{$lang['aborted']}";
		exit();
	} else {
		print "{$_POST['dbprefix']}subscribers - {$lang['table_exists']}<br />\n";
	}
} else {
	print "{$lang['table']} {$_POST['dbprefix']}subscribers<br />\n";
}

mysql_query("DROP TABLE IF EXISTS {$_POST['dbprefix']}banned", $dblink);
mysql_query("CREATE TABLE {$_POST['dbprefix']}banned (
  `ip` varchar(15) NOT NULL default '',
  `time` int (11) NOT NULL default '0',
  PRIMARY KEY  (`ip`)
	)", $dblink);
if (mysql_error()) {
	if (!mysql_errno() == 1050) {
		print  mysql_error() . "<br /><br />{$lang['aborted']}";
		exit();
	} else {
		print "{$_POST['dbprefix']}banned - {$lang['table_exists']}<br />\n";
	}
} else {
	print "{$lang['table']} {$_POST['dbprefix']}banned<br />\n";
}

mysql_query("DROP TABLE IF EXISTS {$_POST['dbprefix']}config", $dblink);
mysql_query("CREATE TABLE {$_POST['dbprefix']}config (
  `ID` bigint(20) NOT NULL auto_increment,
  `option_name` varchar(64) NOT NULL default '',
  `option_data` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `option_name` (`option_name`)
  )", $dblink);
if (mysql_error()) {
	if (mysql_errno() == 1050) {
		// If the config table exists, delete all rows
		$result = mysql_query("TRUNCATE {$_POST['dbprefix']}config", $dblink);
		print "{$_POST['dbprefix']}config - {$lang['table_exists']}<br />\n";
	} else {
		print  mysql_error() . "<br /><br />{$lang['aborted']}";
		exit();
	}
} else {
	print "{$lang['table']} {$_POST['dbprefix']}config<br />\n";
}

mysql_query("DROP TABLE IF EXISTS {$_POST['dbprefix']}articles", $dblink);
mysql_query("CREATE TABLE {$_POST['dbprefix']}articles(
  `ID` bigint(20) NOT NULL auto_increment,
  `href` varchar(255) NOT NULL,
  `com_count` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `href` (`href`) )", $dblink);
if (mysql_error()) {
	if (mysql_errno() == 1050) {
		// If the articles table exists, delete all rows
		$result = mysql_query("TRUNCATE {$_POST['dbprefix']}articles", $dblink);
		print "{$_POST['dbprefix']}articles - {$lang['table_exists']}<br />\n";
	} else {
		print  mysql_error() . "<br /><br />{$lang['aborted']}";
		exit();
	}
} else {
	print "{$lang['table']} {$_POST['dbprefix']}articles<br />\n";
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//	Create config table entries 
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
print "Creating configuration table entries:\n<div style='padding-left: 15px;'>\n";

if (is_file('/usr/bin/mysqldump')) {
	$_POST['mysqldump_path'] = '/usr/bin/mysqldump';
} else {
	$_POST['mysqldump_path'] = '';
}

// Settings  not on the entry form
$_POST['admin_cookie'] = '1';
$_POST['admin_date'] = '%m/%d/%y - %H:%M';
$_POST['admin_hash'] = '';
$_POST['admin_notices'] = '1';
$_POST['admin_notices_suppressed'] = '0';
$_POST['akismet_key'] = '';
$_POST['allowed_tags'] = 'b,i,u,s,a,img-,pre,code,blockquote,big-,small-,center-,font-,hr-,ul-,ol-,li-,<,>';
$_POST['bad_words'] = '0';
$_POST['comment_size'] = '';
$_POST['comments_date'] = '%B %d, %Y - %H:%M';
$_POST['comments_emoticons'] = '1';
$_POST['comments_link_target'] = '1';
$_POST['comments_driver'] = 'comments.php';
$_POST['comments_display_tpl'] = 'comments-display-tpl.php';
$_POST['comments_form_tpl'] = 'comments-form-tpl.php';
$_POST['help_panel_tpl'] = 'comments-help.php';
$_POST['preview_panel_tpl'] = 'comments-preview-tpl.php';
$_POST['reply_panel_tpl'] = 'comments-reply-tpl.php';
$_POST['cookie_name'] = 'TalkBack';
$_POST['date_locale'] = $language;
$_POST['discard_spam'] = '0';
$_POST['email_from'] = $_POST['admin_email'];
$_POST['files_directory'] = '';
$_POST['last_spam_notice'] = '0';
$_POST['maintenance'] = '0';
$_POST['max_links'] = '2';
$_POST['moderation'] = '0';
$_POST['num_of_days'] = '7';
$_POST['page_limit'] = '15';
$_POST['sort_order_line'] = 'always';
$_POST['spam_count'] = '0';
$_POST['test_ip'] = '';
$_POST['time_offset'] = '';
$_POST['user_agent_days'] = '30';
$_POST['wait_time'] = '60';
$_POST['comment_subject'] = '1';
$_POST['comments_subscribe'] = '1';
$_POST['author_location'] = '1';
$_POST['author_website'] = '1';
$_POST['allow_replies'] = '1';
$_POST['lightbox'] = '1';
$_POST['author_website_link'] = '3';
$_POST['comments_legend'] = '1';
$_POST['captcha'] = '0';
$_POST['captcha_public'] = '';
$_POST['captcha_private'] = '';
$_POST['spamwords'] = '0';
$_POST['use_pages'] = '0';
$_POST['comment_search'] = '0';
$_POST['log_errors'] = '0';
$_POST['errorlog_filename'] = 'tb_error.log';
$_POST['gravatar'] = '0';
$_POST['gravatar_size'] = '40';
$_POST['gravatar_rating'] = 'G';


// Create random seed config entry
$keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
$length = 10;
$random_seed = "";
$max=strlen($keychars)-1;
for ($i=0;$i<=$length-1;$i++) {
	$random_seed .= substr($keychars, rand(0, $max), 1);
}
$_POST['random_seed'] = $random_seed;

$_POST = mysql_escape_array($_POST);
foreach ($_POST as $key => $value) {
	if (substr($key, 0, 2) 
		!= 'db' && $key !='action' 
		&& $key != 'admin_password2' 
		&& $key != 'admin_email'
		&& $key != 'language_file'
		) {
		$desc = mysql_real_escape_string($lang[$key]);
		$result = mysql_query("INSERT INTO {$_POST['dbprefix']}config VALUES (NULL, '$key', '$value')", $dblink);
		if (mysql_error()) {
			print  mysql_error();
			exit();
		}
		if ($value == '') {
			$value = '0';
		}
		print "$key = $value<br />\n";
	}
}
print "</div>\n";
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//	Create config.php
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$config_file = "<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	These are the configuration settings that are needed before the
	database configuration table is accessed
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

\$config['dbhost'] 				= '{$_POST['dbhost']}';        // Database server name
\$config['dbuser'] 				= '{$_POST['dbuser']}';       // Database user name
\$config['dbpassword'] 			= '{$_POST['dbpassword']}';   // Database user password
\$config['dbname'] 				= '{$_POST['dbname']}';       // Database name
\$config['dbprefix'] 			= '{$_POST['dbprefix']}';     // Database tables prefix
\$config['admin_email']			= '{$_POST['admin_email']}';  // Your email address
\$config['default_language'] 	= '$language';                // Default language
\$config['message_panel_tpl'] 	= 'message-panel.php';   // message panel template
\$config['document_root_path']	= '".DOC_ROOT."';           // Path to HTML root directory
\$config['talkback_path']		= '".TB_PATH."';           // Path from HTML root to TalkBack directory

// If you are testing on a development system that does not have a mail server,
// this will supress attempts to send emails
\$config['testing'] = 0;		// 1 = testing, 0 = not testing

// Don't change below this line!!!!
require_once 'includes/init.php';
?>";

// Write configuration file
ini_set('display_errors', 0);
if($handle = fopen("../config.php", 'w')) {
  	fwrite($handle, $config_file);
  	fclose($handle);
  	print "{$lang['config_file1']}<br />";
}
else {
	print "<br />Cannot open config file for writing. You must create a text file named &ldquo;config.php&rdquo;, copy and paste following content into it, then upload it to the TalkBack directory on your server.<br /><br />";

	print "<pre style='background: #eee'>\n$config_file\n</pre>";
}
?>