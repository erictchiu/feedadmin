<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Puts icons in the comments form that, when clicked, inserts a smiley code in the text area
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

$file = ABS_PATH . "images/smilies/emoticons.inc.php";
$handle = fopen($file, 'r') or fatal_error(1, 0, $lang['emoticon_err1']); // email error notice and return

print "
			<div id='tb-form-emoticons'>";

while (!feof($handle)) {
	$buffer    = fgets($handle);
	$buffer    = trim(preg_replace('/(\n|\r)/', '', $buffer));
	if (substr($buffer, 0, 1) == '#' || !$buffer) continue;
	$buffer    = explode(',', $buffer);
	$buffer[0] = trim($buffer[0]);
	$buffer[1] = preg_replace("/'/", '', trim($buffer[1]));
	$buffer[2] = preg_replace("/'/", '', trim($buffer[2]));
	print"
				<a href='#' title='{$buffer[2]}' onclick='insertCode(\" {$buffer[1]} \");return false;'><img  src='".URL_PATH."images/smilies/{$buffer[0]}' alt='' /></a>";
}

print "
			</div>
";
?>