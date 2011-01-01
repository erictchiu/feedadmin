<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Displays results of the searcch
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>TalkBack Search Results</title> 	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<?php include "head-inc.php"; ?>
	<style type="text/css">
		body {
			font-family: verdana, arial, helvetica, sans-serif;
			font-size: 80%;
			}
		#wrapper {
			width: 450px;
			margin: auto;
			border: 1px solid #ccc;
			padding: 0 20px 10px 20px;
			}
		a, a:visited {
			color: #00F;
			text-decoration: none;
			}
	</style>
</head> 
<body> 
<div id="wrapper"> 
	
	<h4 class='tb-center'>TalkBack Search Results<br />Example Page</h4>

	<?php 
		print "<p class='tb-center'><a href='{$_REQUEST['page']}'>Return to comments page</a></p>";

		$num_results = 0; // limits number of comments that will be retrieved, 0 = no limit
		define('IS_VALID_INCLUDE', TRUE);
		require 'search.php'; 
		
		$var = str_replace('"','',$var);
		if (!$error) {
			print "<p class='search-legend'>" . $comment_count . "{$lang['search_legend']} '$var'</p>";
			
			while (list($tbid, $href, $text, $author, $subject, $time) = mysql_fetch_array($result)) { 
				$date = ucwords(strftime($config['comments_date'], $time));
				highlight();  // in this script
				
				print "<span class='search-author-title'>{$lang['search_author']}</span>&nbsp;&nbsp; <span class='search-author'>$author</span><br />";
				
				print "<span class='search-date-title'>{$lang['search_date']}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class='search-date'>$date</span> <br />"; 
				
				if ($subject) print "<span class='search-subject-title'>{$lang['search_subject']}</span> <span class='search-subject'>$subject</span> <br /><br />";
				
				print "<div class='search-text'>$text</div>";
			}
		}
		
		// borrowed from:
		// WordPress plugin: Search Hilite
		// http://www.mediaprojekte.de/blog/
		function highlight() {
			global $terms, $text, $value, $var;
			
			if (isset($terms)) {
				foreach($terms as $value) {
					highlighter();
				}
			} else {
				$value = $var;
				highlighter();
			}
		}
		
		function highlighter() {
			global $value, $text;
		
			$value = preg_replace('/(\+|-|\*|")/', '', $value);
			$value = preg_quote($value, '/');
			if (!preg_match('/<.+>/',$text)) {
				$text = preg_replace('/(\b'.$value.'\b)/i','<span class="tb-search-highlight">$1</span>',$text);
			} else {
				$text = preg_replace('/(?<=>)([^<]+)?(\b'.$value.'\b)/i','$1<span class="tb-search-highlight">$2</span>',$text);
			}
		}
	?>

</div>
</body>
</html>