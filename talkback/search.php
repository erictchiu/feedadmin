<?php 
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	TSearches the comments db for text matching the search terms
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy) 
	Website: http://wwwscriptsoldguyus/talkback - noldguy@gmailcom

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991 

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

if (!is_numeric($num_results) || $num_results = '') fatal_error(0, 0, 'Invalid data type for &#36;num_results in search.php');
if (!$num_results) $num_results  = 20;

$var      = trim($_REQUEST['search_terms']);
$phrase   = '';
$error    = FALSE;
$fields   = 'id, href, text, author, subject, time ';
$limit    = ($num_results) ? "LIMIT " . $num_results : '';

// Check for quote characters
$count = substr_count($var, '"');
if ($count) {
	// has quotes so process as a phrase
	if ($count == 2) {
		while (ereg('  ',$var)) {
			// strip multiple spaces between words
			$var = ereg_replace('  ', ' ', $var);
		}
		$last_pos = strrpos($var, '"');
		$length   = (strlen($var)-1);
		
		if ($last_pos != $length) {
			print "'$var' " . $lang['invalid_search1'];
			$error = TRUE;
			return;
		}
		$query = "SELECT $fields FROM " . DBPREFIX . "data 
		WHERE MATCH(text, subject, author) 
		AGAINST ('$var' IN BOOLEAN MODE) $limit"; 
	} else {
		print "'$var' " . $lang['invalid_search2'];
		$error = TRUE;
		return;
	}
} else {
	// we will do a boolean mode search
	while (ereg('  ',$var)) {
		// strip multiple spaces between words
		$var = ereg_replace('  ', ' ', $var);
	}
	$var = mysql_real_escape_string($var);
	$terms = trimArray(explode(' ',$var));
	$query = "SELECT $fields  FROM " . DBPREFIX . "data 
		WHERE MATCH(text, subject, author) 
		AGAINST ('$terms[0] $terms[1] $terms[2] $terms[3] $terms[4] $terms[5]' IN BOOLEAN MODE) $limit";
}

$result = mysql_query("$query", $dblink);
$comment_count = (mysql_num_rows($result)+0);
?>