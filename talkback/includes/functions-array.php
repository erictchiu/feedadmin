<?php
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

// Strip slashes from "everything"
function stripAllSlashes() {
	if (get_magic_quotes_gpc()) {
		$_SERVER	= stripSlashesArray($_SERVER);
		$_GET		= stripSlashesArray($_GET);
		$_POST		= stripSlashesArray($_POST);
		$_COOKIE	= stripSlashesArray($_COOKIE);
		$_FILES		= stripSlashesArray($_FILES);
		$_ENV		= stripSlashesArray($_ENV);
		$_REQUEST	= stripSlashesArray($_REQUEST);
	}
}

// Strip slashes from all elements of an array
function stripSlashesArray($data) {
	if (get_magic_quotes_gpc()) {
		if (is_array($data)){
			foreach ($data as $key => $value) {
				$data[$key] = stripslashes($value);
			}
		}else {
			stripslashes($data);
		}
   }
   return $data;
}

// Trim all elements of an array
function trimArray($data) {
	if (is_array($data)){
		foreach ($data as $key => $value) {
			$data[$key] = trim($value);
		}
	} else {
		trim($data);
	}
 return $data;
}

// Escape all elements of an array
function mysql_escape_array($data) {
   if (is_array($data)){
       foreach ($data as $key => $value) {
           $data[$key] = mysql_real_escape_string($value);
       }
   } else {
       mysql_real_escape_string($data);
   }
   return $data;
}
?>