<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	The driver script for installing TalkBack
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
ini_set('error_reporting', E_ALL ^ E_NOTICE);
defined('IS_VALID_INCLUDE') or define('IS_VALID_INCLUDE', TRUE);

if ($_REQUEST['docroot']) {
	// The paths were previously calculated and were incorrect
	define('DOC_ROOT', $_REQUEST['docroot']);
	define('TB_PATH',  $_REQUEST['tbpath']);
} else {
	$script_filename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);
	$script_name = str_replace("\\", "/", $_SERVER['SCRIPT_NAME']);
	$pos  = strpos($script_filename, $script_name);
	define('DOC_ROOT', substr($script_filename,0,$pos));
	define ('TB_PATH', str_replace('install/install.php','',$_SERVER['PHP_SELF']));
}
define ('ABS_PATH',  DOC_ROOT . TB_PATH);

$server_time = strftime('%c'); // Displayed on the form
$title = "TalkBack 2.0 Installer - For original installation - Do not use if you are upgrading.";
require 'install-head-tpl.php';

if ($_REQUEST['action'] == 'display') {
	$language = $_POST['language'];
	define('LANGUAGE_FILE', '../language/' . $language . '.php');
	if (!is_file(LANGUAGE_FILE)) exit("<br />Language file not found, path to file: <br>'" .LANGUAGE_FILE. "'<br />");
	include  LANGUAGE_FILE;
	require 'install-form-tpl.php';
	
} elseif ($_REQUEST['action'] == 'update') {
	$language = $_POST['language'];
	define('LANGUAGE_FILE', $_POST['language_file']);
	if (!is_file(LANGUAGE_FILE)) exit("<br />Language file not found, path to file: <br>'" .LANGUAGE_FILE. "'<br />");
	include  LANGUAGE_FILE;
	require 'install-make.php';
	print "<p><b>{$lang['install_complete']}</b> - <a href='../test.php'>TalkBack Demonstration</a> - <a href='../admin'>TalkBack Admininistration</a></p>";
	
} else {
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// Print language select form
	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$config_path = ABS_PATH . 'config.php';
	$language_directory = ABS_PATH.'language/';
	
	if (file_exists($config_path)) {
		print "
		<span style='color: #f00;'>The TalkBack config.php file already exists. It will be overwritten.<br /><br /> If you continue...If any tables exist in the TalkBack database, they will be deleted and recreated. <strong>Any data in those tables will be lost!</strong></span><br /><br />";
	}
	
	// Build select list
	print "
		<form action='{$_SERVER['PHP_SELF']}' method='post'>
			<input type='hidden' name='action' value='display' />
			<input type='hidden' name='docroot' value='".DOC_ROOT."' />
			<input type='hidden' name='tbpath' value='".TB_PATH."' />
			<input type='hidden' name='cfgpath' value='$config_path' />
			<input type='hidden' name='langdir' value='$language_directory' />
			<select name='language'>";
			
		// Build options tags for select list
	   if ($handle = opendir($language_directory)) {
			$found = 0;
			while (false !== ($file = readdir($handle))) {
				if (ereg('.php',$file) && !ereg('my-',$file)) { // use only the primary language files
					$found = 1;
					$parts = explode('.', $file);
					print "
				<option value='{$parts[0]}'>{$parts[0]}</option>";
				}
			}
			print "
			</select><br /><br />
			<input type='submit' value='Select language file' /><br /><br />";
			if (!$found) print "
			<span style='color: #f00;'>ERROR - No language file was found. There must be at least one language file in directory " . ABS_PATH . "language.</span><br /><br />";
		} else {
			
			print "
			<input type='hidden' name='action' value='' /><br /><br />
			<input type='text' name='docroot' size='40' value='" . DOC_ROOT . "'/> Path to HTML root directory<br />
			<input type='text' name='tbpath' size='40' value='" . TB_PATH . "'/> Path from HTML root to talkback directory<br /><br />
			
			<span style='color: #f00;'>ERROR - Unable to open the language directory: '$language_directory'. Did you upload it?</span><br /><br />
			<input type='submit' value='Submit' /><br /><br />";
		}
	print "
		</form>
	</div>
</div>
</body>
</html>";
}
?>