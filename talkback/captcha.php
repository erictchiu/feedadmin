<?php
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');

if ($captcha_theme == 'custom' || !$captcha_theme) {
	print "
		<!-- Captcha checking -->
		<script type='text/javascript'>
			var RecaptchaOptions = {
			   theme : 'custom',
				lang  : '$lang_iso_code',
				custom_theme_widget: 'recaptcha_widget'
				};
		</script>
		<div id='recaptcha_widget' class='recaptcha_widget' style='display:none'>
			<div id='recaptcha_image' class='recaptcha_image'></div>
			<div id='captcha_actions' class='captcha_actions'>
				<div><a href='javascript:Recaptcha.reload()'><img src='" .TB_PATH. "images/captcha-reload.png' width='25' height='18' alt='' /></a></div>
				<div class='recaptcha_only_if_image'><a href=\"javascript:Recaptcha.switch_type('audio')\"><img src='" .TB_PATH. "images/captcha-audio.png' width='25' height='15' alt='' /></a></div>
				<div class='recaptcha_only_if_audio'><a href=\"javascript:Recaptcha.switch_type('image')\"><img src='" .TB_PATH. "images/captcha-text.png' width='25' height='15' alt='' /></a></div>
				<div><a href='javascript:Recaptcha.showhelp()'><img src='" .TB_PATH. "images/captcha-help.png' width='25' height='16' alt='' /></a></div>
			</div>
			
			<div id='response_line' class='response_line'>
				<span class='recaptcha_only_if_image'>{$lang['captcha_visual_prompt']}</span>
				<span class='recaptcha_only_if_audio'>{$lang['captcha_audio_prompt']}</span>
				<input type='text' id='recaptcha_response_field' class='recaptcha_response_field' name='recaptcha_response_field' />
			</div>
			<script type='text/javascript' src='http://api.recaptcha.net/challenge?k={$config['captcha_public']}&lang=en'></script>
			<div class='recaptcha_only_if_incorrect_sol' style='color:red'>Incorrect please try again</div>
		</div>";
} else {
		print "
		<!-- Captcha checking -->
		<script type='text/javascript'>
			var RecaptchaOptions = {
				theme : '$captcha_theme',
				lang  : '$lang_code'};
			</script>
		";
		require_once 'includes/classRecaptcha.php';
		print recaptcha_get_html($config['captcha_public']);
}
		print "
		<noscript>
			<iframe src='http://api.recaptcha.net/noscript?k={$config['captcha_public']}&lang=en' height='255' width='420' frameborder='0'></iframe><br />
			<textarea name='recaptcha_challenge_field' rows='3' cols='40'></textarea>
			<input type='hidden' name='recaptcha_response_field' value='manual_challenge' />
		</noscript>";
?>
