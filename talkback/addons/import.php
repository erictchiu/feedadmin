<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Import a mysql dump into a database
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us - noldguy@gmail.com
	Support: http://www.scripts.oldguy.us/forums/
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/


define(DB_SERVER, 'localhost');
define(DB_USER, 'username');
define(DB_PASSWORD, 'password');
define(DB_DATABASE, 'databasename');
define(SQL_FILENAME, '/home/yoursite.com/directory/filename.sql');

set_time_limit(0);
$command   = '/usr/bin/mysql --host=' . DB_SERVER . ' --user=' . DB_USER . ' --password=' . DB_PASSWORD . ' --database=' . DB_DATABASE . ' <  ' . SQL_FILENAME; 
$last_line = system($command, $result);
echo $last_line;
?>