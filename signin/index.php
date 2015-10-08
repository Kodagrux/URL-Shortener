<?php

	/*

	 ######  ####  ######   ##    ##       #### ##    ## 
	##    ##  ##  ##    ##  ###   ##        ##  ###   ## 
	##        ##  ##        ####  ##        ##  ####  ## 
	 ######   ##  ##   #### ## ## ##        ##  ## ## ## 
	      ##  ##  ##    ##  ##  ####        ##  ##  #### 
	##    ##  ##  ##    ##  ##   ###        ##  ##   ### 
	 ######  ####  ######   ##    ##       #### ##    ## 

	*/

	require_once '../signinCheck.php';

	if($signedin) {
		header("Location: http://arbr.se/profile");
	}

	header('Content-Type: text/html; charset=utf-8');

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
			<span class="message_header"><?=$misc?></span>
		</div>
<?php
		} else if(isset($success)) {
?>
		<div class="message_box message_success">
			<span class="message_header">Welcome <?=$success?>! You are now registred and able to sign in, happy shortening!</span>
		</div>
<?php
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>

		<?php
			$page_title = 'arbr.se | Sign in';
			include('../head.php');
		?>
		<link rel="stylesheet" href="signin.css" media="screen"/>

	</head>
	<body onLoad="self.focus();document.SignIn.uName.focus()">

		<?php
			include('../header.php');
		?>


		<section class="wrapper">

			

			<?php
				printMessages();
			?>

			<div id="topContainer"> 
				<h1>Sign in</h1>
				<h2>
					Market leading design, award winning looks. No wonder people want to get a 
					peice of this handsome baby!
				</h2>
				<p>
					If you don't have an acoount you can <a href="../signup">sign up here</a>
				</p>
			</div>

			

			<form name="SignIn" action="signmein.php" method="post">

				<label>Username or Email:</label>
				<input name ="uName" class="field" TABINDEX="1" type="text" id="uName" maxlength="40" placeholder="Your email or username">

				<label>Password:</label><p class="guide"><a id="forgot" class="fancybox fancybox.iframe " href="http://www.arbr.se/signin/forgot_password.html">Forgot password</a></p>
				<input class="field" TABINDEX="2" type="password" name="pass" id="pass" maxlength="25" placeholder="Your password">

				<input type="submit" TABINDEX="3" id="submit" value="Sign in" class="submit">

			</form>


			<div id="rightContainer">
				
					<h4>News</h4>
					<p>
						After months of development and blood, sweat and tears it's finally here, 
						the new, awesome arbr.se! We couldn't be more proud of well it turned out. So
						what are you waiting for? <a href="../signup">Sign up</a> today!
						<br/><br/>
						Don't think we will stop here though, we got plenty of new stuff on the way. 
						Stay tuned and don't forget to tell your friends all about this arbr.se, the only
						URL-shortener you'll ever need.
					</p>
			</div>


		</section>

		<?php
			include('../footer.php');
		?>
				
		<script type="text/javascript" src="signin.js"></script>
		<script type="text/javascript" src="../signup/jquery.lockSubmit.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(':submit').lockSubmit({
					submitText: "Please wait"
				});
			});

			$("#forgot").fancybox({ 'width': 358, 'height': 360 });
		</script>

	</body>
</html>