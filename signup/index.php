<?php

	/*

	 ######  ####  ######   ##    ##       ##     ## ########  
	##    ##  ##  ##    ##  ###   ##       ##     ## ##     ## 
	##        ##  ##        ####  ##       ##     ## ##     ## 
	 ######   ##  ##   #### ## ## ##       ##     ## ########  
	      ##  ##  ##    ##  ##  ####       ##     ## ##        
	##    ##  ##  ##    ##  ##   ###       ##     ## ##        
	 ######  ####  ######   ##    ##        #######  ##        

	*/


	header('Content-Type: text/html; charset=utf-8');
	require_once '../signinCheck.php';

	$error = $_GET["error"];
	$success = $_GET["success"];
	$misc = $_GET["misc"];

	function printMessages(){

		global $error, $success, $misc;

		if(isset($error)) {
?>
		<div class="message_box message_error">
			<span class="message_header">Could not sign up because:</span>
			<ul>
				<?=$error?>
			</ul>
		</div>
<?php
		} else if(isset($misc)) {
?>
		<div class="message_box message_misc">
			<span class="message_header">
			<ul>
				<?=$misc?>
			</ul>
			</span>
		</div>
<?php
		} else if(isset($success)) {
?>
		<div class="message_box message_success">
			<span class="message_header">Success:</span>
			<ul>
				<?=$success?>
			</ul>
		</div>
<?php
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>

		<?php
			$page_title = 'arbr.se | Sign Up!';
			include('../head.php');
		?>

		<link rel="stylesheet" href="signup.css" media="screen"/>

	</head>
	<body onLoad="self.focus();document.SignUp.uName.focus()">

		<?php
			include('../header.php');
		?>

		<section class="wrapper">

			<div id="topContainer"> 
				<h1>Sign up</h1>
				<h2>
					Most possibly the best URL-shortener in the whole wide world. Fo realz yo.
				</h2>
				<p>
					If you already have an acoount you can <a href="../signin">sign in here</a>
				</p>
			</div>

			<?php
				printMessages();
			?>

			<script type="text/javascript">
				//var RecaptchaOptions = {
				//theme : 'clean',
  				//tabindex : 6
				//};
				 var RecaptchaOptions = {
				    theme : 'custom',
				    custom_theme_widget: 'recaptcha_widget'
				 };
			</script>

			<form name="SignUp" action="signmeup.php" method="post">

				<label>Username:</label><span id="uName_check"></span>
				<input TABINDEX="1" onkeyup="checkAvailability(this.value)" class="field" type="text" name="uName" id="uName" maxlength="25" placeholder="What should we call you?"/>

				<label>Full name:</label><p class="guide"></p>
				<input class="field" TABINDEX="2" type="text" name="fName" id="fName" maxlength="40" placeholder="First and last name"/>

				<label>Email:</label><p class="guide"></p>
				<input class="field" TABINDEX="3" type="email" name="eMail" id="eMail" maxlength="40" placeholder="yourname@email.com"/>

				<label>Password:</label><p class="guide"></p>
				<input class="field" TABINDEX="4" type="password" name="pass" id="pass" maxlength="25" placeholder="A minimum of 6 characters"/>

				<label>Retype password:</label><p class="guide"></p>
				<input class="field" TABINDEX="5" type="password" name="pass2" id="pass2" maxlength="25" placeholder="Same as above"/>

				<br/>

				<div id="captcha">	


					<div id="recaptcha_widget" style="display:none">
						<div id="recaptcha_image_container">
							<div id="recaptcha_image"></div>
						</div>

						<div class="captcha_choise"><a href="javascript:Recaptcha.reload()">New</a></div>
						<div class="captcha_choise recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Audio</a></div>
						<div class="captcha_choise recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Image</a></div>
						<div class="captcha_choise"><a href="javascript:Recaptcha.showhelp()">Help</a></div>

						<label class="recaptcha_only_if_image top">Enter reCAPTCHA:</label><p class="guide"></p>
						<label class="recaptcha_only_if_audio top">Enter the numbers you hear:</label><p class="guide"></p>
						<input class="field" type="text" id="recaptcha_response_field" name="recaptcha_response_field" TABINDEX="6" placeholder="The words from the image above"/>

						<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>

					</div>

					<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6Lcd_NwSAAAAAAHTzqzAK3oOu4bd4eCshBIfP1uW"></script>
					<noscript>
						<iframe src="http://www.google.com/recaptcha/api/noscript?k=6Lcd_NwSAAAAAAHTzqzAK3oOu4bd4eCshBIfP1uW" height="300" width="500" frameborder="0"></iframe><br>
						<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
						<input type="hidden" name="recaptcha_response_field" value="manual_challenge" TABINDEX="6">
					</noscript>

					<?php
						//require_once('recaptchalib.php');
						//$publickey = "6Lcd_NwSAAAAAAHTzqzAK3oOu4bd4eCshBIfP1uW"; // you got this from the signup page
						//echo recaptcha_get_html($publickey);
					?>
				</div>

				<input type="submit" TABINDEX="7" id="submit" value="Sign up" class="submit">
			</form>


			<div id="rightContainer">
				

				<img src="https://d2c01jv13s9if1.cloudfront.net/i/9/K/u/9KucM02zHtQQmi4ESUUHxlM2KDA.png" width="358">

				
					<h4>News</h4>
					<p>
						After months of development and blood, sweat and tears it's finally here, 
						the new, awesome arbr.se! We couldn't be more proud of well it turned out. So
						what are you waiting for? Sign up today!
						<br/><br/>
						Don't think we will stop here though, we got plenty of new stuff on the way. 
						Stay tuned and don't forget to tell your friends all about this arbr.se, the only
						URL-shortener you'll ever need.
					</p>
					<h4>Terms</h4>
					<p>
						By registering an account at arbr.se you are agreeing to <a class="fancybox fancybox.iframe" href="http://www.arbr.se/terms.html">these terms</a>. You
						are also selling your soul to us, for free, which means that you are giving
						it to us.
					</p>
			</div>
		</section>

		<?php
			include('../footer.php');
		?>

		<script type="text/javascript" src="signup.js"></script>
		<script type="text/javascript" src="jquery.lockSubmit.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(':submit').lockSubmit({
					submitText: "Please wait"
				});
			});
		</script>
	</body>
</html>