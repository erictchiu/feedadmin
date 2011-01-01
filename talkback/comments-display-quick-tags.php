<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Prints quick tag buttons on the comment form
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Kill the script if it is accessed directly
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

// You cannot add a tag simply by adding to these arrays. The quick tag
// edbuttons array in talkback.js must also be updated. 

// javascript and $lang name for the tag
$tname['b']           = 'ed_bold';
$tname['i']           = 'ed_italic';
$tname['a']           = 'ed_link';
$tname['img']         = 'ed_img';
$tname['ul']          = 'ed_ul';
$tname['ol']          = 'ed_ol';
$tname['li']          = 'ed_li';
$tname['blockquote']  = 'ed_block';
$tname['code']        = 'ed_code';
$tname['pre']         = 'ed_pre';
$tname['u']           = 'ed_under';
$tname['s']           = 'ed_strike';
$tname['big']         = 'ed_big';
$tname['small']       = 'ed_small';
$tname['center']      = 'ed_center';
$tname['font']        = 'ed_font';
$tname['\<']           = 'ed_lt';
$tname['\>']           = 'ed_gt';
$tname['hr']          = 'ed_hr';

// javascript edbuttons array ID
$tid['b']           = 0;
$tid['i']           = 1;
$tid['a']           = 2;
$tid['img']         = 3;
$tid['ul']          = 4;
$tid['ol']          = 5;
$tid['li']          = 6;
$tid['blockquote']  = 7;
$tid['code']        = 8;
$tid['pre']         = 9;
$tid['u']           = 10;
$tid['s']           = 11;
$tid['big']         = 12;
$tid['small']       = 13;
$tid['center']      = 14;
$tid['font']        = 15;
// lightbox is 16
$tid['\<']           = 17;
$tid['\>']           = 18;
$tid['hr']          = 19;

if (!isset($allowedtags)) get_allowed_tags();

if ($allowedtags) {
	print "
				<!-- Inserts HTML quick tag buttons -->
				<div id='ed_toolbar'>";
				
	foreach ($allowedtags as $key => $value) {
		$target = '';
		if (isset($tid[$key]) && $tagbuttons[$key]) {
			if ($key == 'a') {
				$function = 'edInsertLink';
				$target   = ', '. $config['comments_link_target'];
			} elseif ($key == 'img') {
				$function = 'edInsertImage';
			} else {
				$function = 'tbInsertTag';
			}
			
			print "
					<input id='{$tname[$key]}' class='ed-button' onclick='$function(tbcanvas, $tid[$key]$target);' value='{$lang[$tname[$key]]}' type='button' onmouseout=\"this.className='ed-button'\" onmouseover=\"this.className='ed-button-hover'\" />";
		}
	}
	
	if ($config['lightbox']) {
		print "
					<input id='ed_lightbox' class='ed-button' onclick='tbInsertLightbox(tbcanvas, 16);' value='$lang[ed_lightbox]' type='button' onmouseout=\"this.className='ed-button'\" onmouseover=\"this.className='ed-button-hover'\" /> ";
	}
	
	print "
					$help4
				</div>";
}
?>