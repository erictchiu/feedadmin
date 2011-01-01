<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Initialization script, used by all primary scripts
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. This script may contain copyrighted code from another source that was
	released under the GPL. See credits-copyrights.txt for more information.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Initializtion processing common to all driver scripts
   ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
define('LF',               "\n");
define('EOL',              strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");

define('DBHOST',           $config['dbhost']);
define('DBUSER',           $config['dbuser']);
define('DBPASS',           $config['dbpassword']);
define('DBNAME',           $config['dbname']);
define('DBPREFIX',         $config['dbprefix']);
define('ADMIN_EMAIL',      $config['admin_email']);
define('DEFAULT_LANGUAGE', $config['default_language']);
define('TESTING',          $config['testing']);
define('TB_PATH',          $config['talkback_path']);

if ($config['document_root_path']) {
	// version 2.6 and later
	define('DOC_ROOT', $config['document_root_path']);
} else {
	// version 2.5 and earlier
	$pos  = strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['SCRIPT_NAME']);
	$temp = substr($_SERVER['SCRIPT_FILENAME'],0,$pos);
	define('DOC_ROOT', str_replace('\\', '/', $temp));
}
define ('ABS_PATH',  DOC_ROOT . TB_PATH);

define('MESSAGE_PANEL_TPL', ABS_PATH . $config['message_panel_tpl']);
if (!is_file(MESSAGE_PANEL_TPL)) 
	exit("<br />Message panel template not found, init.php, path to file: <br>" . MESSAGE_PANEL_TPL . "<br />");

require_once ABS_PATH . 'includes/functions.php';
require_once ABS_PATH . 'includes/functions-blog.php';
require_once ABS_PATH . 'includes/functions-array.php';
require_once ABS_PATH . 'version.php';

setlocale(LC_TIME, $config['date_locale']); // determines in what language dates will display

setup_language();
require LANGUAGE_FILE;

$dblink = open_db(0);
$config = get_config();

// now we have config settings from the db
define ('SITE_URL',		$config['site_url']);
define ('URL_PATH',		SITE_URL . TB_PATH);
define ('FILES_PATH',	$config['files_directory']);
define('LOG_ERRORS',    $config['log_errors']);
define ('LOG_FILE',		FILES_PATH.$config['errorlog_filename']);
define ('ADMIN_HASH',   $config['admin_hash']);

stripAllSlashes();	// strips slashes from $_GET, $_POST, $_REQUEST, $_COOKIE

if (defined('PROCESSING_ADMIN')) {
	require 'init-admin.php';
} else {
	require 'init-comments.php';
}

define ('SETUP_DONE', TRUE);


// ++++++++++++++++++++++++++ FUNCTIONS +++++++++++++++++++++++++++++++++++++
function check_for_evil($array, $http_ok) {	
	if (LOG_ERRORS) {
		foreach($array as $key => $value) {
			//check for 'HTTP://' in fields it should not be in
			if(eregi('HTTP://', $value)) {
				if (isset($http_ok[$key])) continue;
				write_error_log("$key contains '$value'");
				exit("Unable to process the request cfe1");
			}
		}
	}
}

function write_error_log($message) {
	if (LOG_ERRORS) {
		$string = "{$_SERVER['REQUEST_METHOD']}: ";
		$date = date('y/m/d-H:i');
		if ($handle = fopen(LOG_FILE, 'a')) {
			fwrite($handle, "$date {$_SERVER['REQUEST_METHOD']} Error: $message -- URI: {$_SERVER['REQUEST_URI']}".LF.LF);
			fclose($handle);
		}
	}
}
?>