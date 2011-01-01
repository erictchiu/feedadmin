<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Allowable tags  and attributes arrays
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	If not in this array, user cannot specifiy a tag in $config['allowed_tags
	Must be lower case
	1 = must have closing tag, 0 = no closing tag
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

$allowable_tags  = array(
	'a'=> 0,
	'abbr'=> 1,
	'acronym' => 1,
	'b' => 1,
	'big' => 1,
	'blockquote' => 1,
	'br' => 0,
	'center' => 1,
	'cite' => 1,
	'code' => 1,
	'dd' => 1,
	'del' => 1,
	'dfn' => 1,
	'dl' => 1,
	'dt' => 1,
	'em' => 1,
	'font' => 1,
	'h1' => 1,
	'h2' => 1,
	'h3' => 1,
	'h4' => 1,
	'h5' => 1,
	'h6' => 1,
	'hr' => 0,
	'i' => 1,
	'img' => 0,
	'ins' => 1,
	'li' => 1,
	'ol' => 1,
	'p' => 1,
	'pre' => 1,
	'q' => 1,
	's' => 1,
	'samp' => 1,
	'small' => 1,
	'strike' => 1,
	'strong' => 1,
	'sub' => 1,
	'sup' => 1,
	'table' => 1,
	'td' => 1,
	'th' => 1,
	'tr' => 1,
	'u' => 1,
	'ul' => 1,
	'var' =>1,
	'<' => 0,
	'>' => 0,
	'object' => 1,
	'param' => 1,
	'embed' => 1
	);
?>