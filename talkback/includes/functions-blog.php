<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Get the comments count for a page
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

function tbPrintCommentCount($tb_article_url) {	
	$count = tbRetrieveCommentCount($tb_article_url);
	printf('%d', $count);
}

function tbGetCommentCount($tb_article_url) {	
	$count = tbRetrieveCommentCount($tb_article_url);
	return  sprintf('%d', $count);
}

function tbRetrieveCommentCount($tb_article_url) {
	global $config, $dblink;
	
	if (!$dblink) return 0;
	$result = @mysql_query("SELECT com_count FROM " . DBPREFIX . "articles WHERE href='$tb_article_url' LIMIT 1", $dblink);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function tbCommentsLink($zero='No Comments', $one='1 Comment', $more='% Comments', $link_title='', $CSSclass='') {
	global $tb_article_url, $tb_permalink;
	
	$number = tbRetrieveCommentCount($tb_article_url);
	if ($CSSclass) $class = "class='" . $CSSclass . "'";
	if ($number == 0) {
		$blah = $zero;
	} elseif ($number == 1) {
		$blah = $one;
	} elseif ($number  > 1) {
		$blah = str_replace('%', $number, $more);
	}
	
	print "<a href='$tb_permalink' title='$link_title' $class>" . $blah . "</a>";
}
?>