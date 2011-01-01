<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin panels HTML header
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='Content-Style-Type' content='text/css' />
<?php
$nav_count = 0;
include '../head-inc.php';

if (!$config['lightbox'])
	// These are not loaded in head-inc.php if lightbox is not enabled
	print "
	<script type='text/javascript' src='".TB_PATH."includes/jquery-c.js'></script>
	<script type='text/javascript' src='".TB_PATH."includes/thickbox.js'></script>
	<link rel='stylesheet' type='text/css' href='".TB_PATH."styleThickbox.css' />";
	
 print "
 	<link rel='stylesheet' type='text/css' href='admin.css' />
	<style type='text/css'>
		#TB_closeAjaxWindow a:hover {background: none;}
		#TB_closeWindow a:hover {background: none;}
		#TB_prev a:hover {background: none;}
		#TB_next a:hover {background: none;}
	</style>";
?>