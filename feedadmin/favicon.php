<?php
/*
 * This file is part of FEED ON FEEDS - http://feedonfeeds.com/
 *
 * favicon.php - displays an image cached by SimplePie
 *
 *
 * Copyright (C) 2004-2007 Stephen Minutillo
 * steve@minutillo.com - http://minutillo.com/steve/
 *
 * Distributed under the GPL - see LICENSE
 *
 */
require_once('simplepie/simplepie.inc');

if(file_exists("./cache/" . md5($_GET[i]) . ".spi"))
{
    SimplePie_Misc::display_cached_file($_GET['i'], './cache', 'spi');
}
else
{
    header("Location: image/feed-icon.png");
}
?>
