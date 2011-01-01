<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Driver script for editing the configuration settings
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
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');
$menu = 'config';
$report_title = "{$lang['panel_config_title']}";

require 'admin-config-variables.php';

if ($_REQUEST['action'] == 'displayconfig') {
	// Display the configuration form
	require 'admin-config-head-tpl.php';
	require 'admin-config-tpl.php';
	require 'admin-footer-tpl.php';
} elseif ($_REQUEST['action'] == 'updateconfig') {
	if (!$config['is_demo_system']) {
		// Validate changes and update database
		require 'admin-config-validate.php';
		
		if ($_POST['regen_seed']){
			// Regenerate if random seed was checked
			$keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
			$length = 10;
			$random_seed = "";
			$max=strlen($keychars)-1;
			for ($i=0;$i<=$length-1;$i++) {
				$random_seed .= substr($keychars, rand(0, $max), 1);
			}
			$_POST['random_seed'] = $random_seed;
		}
		
		foreach ($_POST as $key => $value) {
			if ($key != 'action' && $key != 'admin_password2' && $key != 'regen_seed') {
				if ($value != $config[$key])  {
					$value = mysql_real_escape_string($value);
					$result = mysql_query("UPDATE " . DBPREFIX . "config SET option_data='$value' WHERE  option_name='$key' LIMIT 1", $dblink);
					if (!$result) exit('DB query error, admin-config 1 <br /> mysql error:<br />' . mysql_error());
				}
			}
		}
	}
	header("HTTP/1.1 302");
	header("Location: " .URL_PATH."admin?action=displayconfig");
}
?>