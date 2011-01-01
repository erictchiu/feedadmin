<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin processing initialization
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

// http_ok is list of fields that may contain "HTTP://"
$http_ok['website'] = 1;
$http_ok['site_url'] = 1;
check_for_evil ($_POST, $http_ok);
check_for_evil ($_GET, $http_ok);
?>