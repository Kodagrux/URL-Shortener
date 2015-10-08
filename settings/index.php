<?php
	/*
		 ######  ######## ######## ######## #### ##    ##  ######    ######  
		##    ## ##          ##       ##     ##  ###   ## ##    ##  ##    ## 
		##       ##          ##       ##     ##  ####  ## ##        ##       
		 ######  ######      ##       ##     ##  ## ## ## ##   ####  ######  
		      ## ##          ##       ##     ##  ##  #### ##    ##        ## 
		##    ## ##          ##       ##     ##  ##   ### ##    ##  ##    ## 
		 ######  ########    ##       ##    #### ##    ##  ######    ######

	*/

	
	require_once '../signinCheck.php';
	header('Content-Type: text/html; charset=utf-8');
	
	//require_once '../dbc_class.php';
	

	//Check if user is signed in
	if(!$signedin) {
		//header("Location: http://www.arbr.se/signin/?misc=" . "To change your settings, you must be signed in!");
	} 
	
	$error = $_GET["error"];
	$success = $_GET["success"];
	$misc = $_GET["misc"];

	//Databas connection
	$dbc = new dbc();
	$dbcData = array('uName' => $uName);
	$dbc->query("SELECT * FROM Users WHERE uName = :uName", $dbcData);
	$res = $dbc->getResult();

	//Variables
	$uName = $_SESSION["user"];
	$signUp = $res["signUp"];
	//$IDuser = $res["IDuser"];
	$eMail = $res["eMail"];
	$bio = utf8_encode($res["bio"]);


	function printMessages(){

		global $error, $success, $misc;

		if(isset($error)) {
?>
		<div class="message_box message_error">
			<span class="message_header">Error:</span>
			<ul>
				<?=$error?>
			</ul>
		</div>
<?php
		} else if(isset($misc)) {
?>
		<div class="message_box message_misc">
			<span class="message_header">Tip:</span>
			<ul>
				<?=$misc?>
			</ul>
		</div>
<?php
		} else if(isset($success)) {
?>
		<div class="message_box message_success">
			<span class="message_header">Your settings have been updated!</a></span>
		</div>
<?php
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php
			$page_title = 'arbr.se | Settings';
			include('../head.php');
		?>
		<link rel="stylesheet" href="settings.css" media="screen"/>
	</head>
	<body>

		<?php
			include('../header.php');
		?>

		<section class="wrapper">

			<?php
				printMessages();
			?>

			<section class="avatar">
				<?php
					$default = "http://www.arbr.se/img/default.jpg";
					$size = 200;
					$gravatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($eMail))) . "?d=" . urlencode($default) . "&s=" . $size;
				?>
				<div style="background-image: url(<?=$gravatar;?>);" alt="Gravatar" class="profile_pic"></div>
				<h4>Avatar</h4>
				<p>
					arbr.se uses Gravatar's awesome avatar service. To change your profile picture, go to <a href="http://www.gravatar.com">gravatar.com</a>.
				</p>

			</section>

			
			<form name="Settings" action="update.php" method="post">

				<label>Bio:</label><p class="guide"></p>
				<textarea TABINDEX="1" name="bio" id="bio" maxlength="300" rows="0" placeholder="Tell us who you are!"><?=$bio?></textarea>

				<label>Password:</label><p class="guide"></p>
				<input class="field" TABINDEX="2" type="password" name="pass" id="pass" maxlength="25" placeholder="A minimum of 6 characters"/>

				<label>Retype password:</label><p class="guide"></p>
				<input class="field" TABINDEX="3" type="password" name="pass2" id="pass2" maxlength="25" placeholder="Same as above"/>

				<br/>


				<input type="submit" TABINDEX="4" id="submit" value="Update settings" class="submit">
			</form>
			

		</section>

		<?php
			include('../footer.php');
		?>

		<script type="text/javascript" src="settings.js"></script>
		<script type="text/javascript" src="../signup/jquery.lockSubmit.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(':submit').lockSubmit({
					submitText: "Please wait"
				});
			});
		</script>

	</body>
</html>