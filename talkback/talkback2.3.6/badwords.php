<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Bad words array
   ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	This is used only if the bad_words configuration setting is enabled
	via the admin maintenance panel. If so:
	
	    MAKE A COPY OF THIS FILE and name it "my-badwords.php"
	    MAKE YOUR CHANGES to that file.

	Add "character strings" that you do not want to appear in comment posts 
	to the array. The strings will be replaced with the second value in 
	the array. Example:
	
	'ass' will catch ass, asshole, assembly, etc.
	
	Be careful because some so called "bad words" can appear 
	as part of a good word as shown above.

	So, for some words, you may want a space before and after the
	word. Example:
		array(' ass ','****')

	No filtering system is perfect. The only way to really prevent all bad
	words is to moderate all posts.

	All entries except the last must be followed by a comma.
	
	The filter is not case sensitive, BadwORd and badword are equivalent.
	
	WARNING: [\^$.|?*+()
	Do not use the above characters in a character string that is to be
	replaced, e.g. sh*t. Doing so will cause unintended consequences, 
	i.e. mess up comments in ways you wouldn't expect unless you are
	familiar with regular expressions and know what you are doing.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

$badword = array(
   array(' ass ', 'bleeped'),
   array('asshole', 'bleeped'),
   array('bastard', 'bleeped'),
   array('bitch', 'bleeped'),
   array('b!tch', 'bleeped'),
   array('breast', 'bleeped'),
   array('cock', 'bleeped'),
   array('c0ck', 'bleeped'),
   array('clit', 'bleeped'),
   array('cum', 'bleeped'),
   array('cunt', 'bleeped'),
   array('dago', 'bleeped'),
   array('dick', 'bleeped'),
   array('dildo', 'bleeped'),
   array('dyke', 'bleeped'),
   array('ejaculate', 'bleeped'),
   array('foreskin', 'bleeped'),
   array('fuck', ''),
   array('fcuk', 'bleeped'),
   array('fuk', 'bleeped'),
   array('ho ', 'bleeped'),
   array('hoar', 'bleeped'),
   array('honkey', 'bleeped'),
   array('injun', 'bleeped'),
   array('jism', 'bleeped'),
   array('jizz', 'bleeped'),
   array('kike', 'bleeped'),
   array('kraut', 'bleeped'),
   array('lesbian', 'bleeped'),
   array('lesbo', 'bleeped'),
   array('masturbate', 'bleeped'),
   array('motherfucker', 'bleeped'),
   array('nazi', 'bleeped'),
   array('nigger', 'bleeped'),
   array('nutsack', 'bleeped'),
   array('penis', 'bleeped'),
   array('phuck', 'bleeped'),
   array('piss', 'bleeped'),
   array('prick', 'bleeped'),
   array('pussy', 'bleeped'),
   array('pusse', 'bleeped'),
   array('puta', 'bleeped'),
   array('queer', 'bleeped'),
   array('scrotum', 'bleeped'),
   array('shemale', 'bleeped'),
   array('shit', 'bleeped'),
   array('sh!t', 'bleeped'),
   array('slut', 'bleeped'),
   array('spic', 'bleeped'),
   array('splooge', 'bleeped'),
   array('testicles', 'bleeped'),
   array('tits', 'bleeped'),
   array('titties', 'bleeped'),
   array('titty', 'bleeped'),
   array('twat', 'bleeped'),
   array('wank', 'bleeped'),
   array('wetback', 'bleeped'),
   array('whore', 'bleeped'),
   array('wop', 'bleeped'),
);
?>