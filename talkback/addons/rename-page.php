<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	If you ever rename a page that has comments, use this to rename the
	page URI for the comments in the database.
	
	Upload the script to your TalkBack directory then browse to it.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
define('IS_VALID_INCLUDE', TRUE);
require_once 'config.php';

$dblink = open_db(1);
$config = get_config();

print "Rename page URI (directory path) for comments in the TalkBack database.<br />
The URI must start with a / character which is the start of your html directory.<br />
<br /><br />

<form action='rename-page.php' method='get'>
	<input type='text' name='oldname' value='{$_REQUEST['oldname']}' /> Old page (e,g, /filename.php)<br />
	<input type='text' name='newname' value='{$_REQUEST['newname']}' /> New page (e,g, /directoryname/filename.php)<br />
	<input type='submit' name='submit' value='submit' />
</form>";

if ($_REQUEST['oldname'] && $_REQUEST['newname']) {
	$oldname = mysql_real_escape_string(trim($_REQUEST['oldname']));
	$newname = mysql_real_escape_string(trim($_REQUEST['newname']));
	
	$result = mysql_query("UPDATE " . DBPREFIX . "data SET href='$newname' WHERE href='$oldname'", $dblink);
	print mysql_error();
	print mysql_affected_rows($dblink) . " comments were updated";
} else {
	print "<br /><br />The old name and new name cannot be 0.";
}
?>

