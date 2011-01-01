<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Message displayed when system is down for maintenance/upgrade
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

print "

<p style='margin: 0 20% 0 20%; padding: 5px; border: 1px solid #ccc; font-size: .85em; background: #eee;'>{$lang['doing-maintenance']}</p>

</div> <!--end of tb-wrapper -->";
?>