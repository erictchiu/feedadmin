<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	TalkBack  <head> section entries
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
ini_set('error_reporting', E_ALL ^ E_NOTICE);
define('IS_VALID_INCLUDE', TRUE);

// houskeeping: get config settings, sanitize vars, define constants
require_once (dirname(__FILE__)) . '/config.php';

// TB_PATH is path to TalkBack from webroot directory. e.g. "/talkback/"
// ABS_PATH is complete filesystem path. e.g. Linux "/home/username/public_html/talkback/"

print "
<!-- TALKBACK STYLESHEETS AND JAVASCRIPT -->
	<script type='text/javascript' src='includes/talkback.js'></script>
	<script type='text/javascript' src='includes/jquery-c.js'></script>
	<script type='text/javascript' src='includes/thickbox.js'></script>
	<link rel='stylesheet' type='text/css' href='styleThickbox.css' />";
	
if (file_exists(ABS_PATH.'styleCustom.css')) {
	// these were used prior to version 2.3.0 Rather than make user convert, we will continue to use them.
	print "
	<link rel='stylesheet' type='text/css' href='style.css' />
	<link rel='stylesheet' type='text/css' href='styleCustom.css' />";
}elseif (file_exists(ABS_PATH.'my-styles.css')) {
	// in use beginning with version 2.3.0
	print "
	<link rel='stylesheet' type='text/css' href='my-styles.css' />";
} else {
	exit('head-inc.php cannot find my-styles.css or styleCustom.css');
}

print "
	<!--[if IE]>
		<link rel='stylesheet' type='text/css' href='styleIE.css' />
	<![endif]-->";

require_once ABS_PATH.'includes/functions-browser-detect.php'; 
$browser = browserDetect('browser');
if ($browser == 'opera')
	print "	<link rel='stylesheet' type='text/css' href='styleOpera.css' />";

print "
<!-- END OF TALKBACK STYLES AND JAVASCRIPT -->
";
?>
