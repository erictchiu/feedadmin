<?php

/*
Script Name: Simple 'if' PHP Browser detection
Author: Harald Hope, Website: http://TechPatterns.com/
Script Source URI: http://TechPatterns.com/downloads/php_browserDetection.php
Version 2.0.1
Copyright (C) 13 October 2004

Special thanks to Tapio Markula, for his ideas of creating a useable php browser detector.

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

Lesser GPL license text:
http://www.gnu.org/licenses/lgpl.txt

Coding conventions:
http://cvs.sourceforge.net/viewcvs.py/phpbb/phpBB2/docs/codingstandards.htm?rev=1.3
*/

/*
the order is important, because opera must be tested first, and ie4 tested for before ie general
same for konqueror, then safari, then gecko, since safari navigator user agent id's with 'gecko' in string.
note that $dom_browser is set for all  modern dom browsers, this gives you a default to use, unfortunately we
haven't figured out a way to do this with actual method testing, which would be much better and reliable.

Please note: you have to call the function in order to get access to the variables, you call it by this:

browserDetect('browser');

then put you code that you want to use the variables with after that.

*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

function browserDetect( $which_test ) {

	// initialize the variables
	$browser = '';
	$dom_browser = '';

	// set to lower case to avoid errors, check to see if http_user_agent is set
	$navigator_user_agent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';

	// run through the main browser possibilities, assign them to the main $browser variable
	if (stristr($navigator_user_agent, "opera")) 
	{
		$browser = 'opera';
		$dom_browser = true;
	}

	elseif (stristr($navigator_user_agent, "msie 4")) 
	{
		$browser = 'msie4'; 
		$dom_browser = false;
	}

	elseif (stristr($navigator_user_agent, "msie")) 
	{
		$browser = 'msie'; 
		$dom_browser = true;
	}

	elseif ((stristr($navigator_user_agent, "konqueror")) || (stristr($navigator_user_agent, "safari"))) 
	{
		$browser = 'safari'; 
		$dom_browser = true;
	}

	elseif (stristr($navigator_user_agent, "gecko")) 
	{
		$browser = 'mozilla';
		$dom_browser = true;
	}
	
	elseif (stristr($navigator_user_agent, "mozilla/4")) 
	{
		$browser = 'ns4';
		$dom_browser = false;
	}
	
	else 
	{
		$dom_browser = false;
		$browser = false;
	}

	// return the test result you want
	if ( $which_test == 'browser' )
	{
		return $browser;
	}
	elseif ( $which_test == 'dom' )
	{
		return $dom_browser;
		//  note: $dom_browser is a boolean value, true/false, so you can just test if
		// it's true or not.
	}
}

/*
you would call it like this:

$user_browser = browserDetect('browser');

if ( $user_browser == 'opera' )
{
	do something;
}

or like this:

if ( browserDetection('dom') )
{
	execute the code for dom browsers
}
else
{
	execute the code for non DOM browsers
}

and so on.......


*/
?>