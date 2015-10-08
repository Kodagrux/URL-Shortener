<?php

	//START SESSION
	session_start();
	header('Content-Type: text/html; charset=utf-8');

	//Error string
	$errorString = "";
	$success = 0;


	require_once('recaptchalib.php');
	$privatekey = "6Lcd_NwSAAAAAHoX0fKgQcAwYGRIRwMpHmcOXvnR";
	$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], 
		$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
		//echo("<!-- The reCAPTCHA wasn't entered correctly: ". $resp->error . ". -->");
		$errorString .= "<li>- You entered the wrong captcha. Are you a robot?</li>";
	} else {
	// Your code here to handle a successful verification
		$success++;
	}

	//REQUIRE FILES
	require_once '../dbc_class.php';

	//echo $_POST['eMail'];


	//VALIDATION
	$eMail = $_POST['eMail'];
	$fName = $_POST['fName'];
	$uName = $_POST['uName'];
	$pass2 = $_POST['pass2'];
	$pass = $_POST['pass'];


	//Validating every entry, only format
	if(checkEmail($eMail) && $eMail != "") {
		$success++;
		//echo $eMail . "<br/>";
	} 

	if(checkPassword($pass, $pass2) && $pass != "" && $pass2 != "") {
		$success++;
		//echo $pass . "<br/>";
	} else {
		$errorString .= "<li>- Your password is not correctly formated.</li>";
	}

	if(checkFName($fName) && $fName != "") {
		$success++;
		//echo $fName . "<br/>";
	} else {
		$errorString .= "<li>- Your name '" . $fName . "', it sounds fishy...</li>";
	}

	if(checkUName($uName) && $uName != "") {
		$success++;
		//echo $uName . "<br/>";
	} 

	if($success == 5) {
		$dbc = new dbc();
	    $dbcData = array('eMail' => $eMail, 'fName' => utf8_decode($fName), 'uName' => $uName, 'pass' => sha1($pass . UNIQE_SALT));
	    $res = $dbc->query("INSERT INTO Users(eMail, fName, uName, pass) VALUES(:eMail, :fName, :uName, :pass) ", $dbcData);
	    email();
	    redirect();
	} else {
		somethingWrong();
	}
    /*if($res == 1){
    	header("Location: index.php")
    }
    */
	

    function somethingWrong() {
    	global $errorString;
    	header("Location: http://arbr.se/signup/?error=" . $errorString);
    }

    function redirect() {
    	global $errorString, $fName;
    	header("Location: http://arbr.se/signin/?success=" . $fName);
    }

    function checkEmail($eMail) {
    	global $errorString;
		$dbc = new dbc();
		$dbcData = array('eMail' => $eMail);
		$res = $dbc->query("SELECT * FROM Users WHERE eMail = :eMail", $dbcData);
		if ($res > 0) {
			$errorString .= "<li>- The email '" . $eMail . "', is already taken.</li>";
			return false;
		} 

    	if(filter_var($eMail, FILTER_VALIDATE_EMAIL) && strlen($eMail) < 41){
    		if(preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\
    			[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zåäöA-ZÅÄÖ\-0-9]+\.)+[a-zA-Z]{2,}))$/", $eMail)) {
    			return true;
    		}
    	}
    	$errorString .= "<li>- Your email '" . $eMail . "', not correctly formated.</li>";
    	return false;
	}

	function checkPassword($pass, $pass2) {
		if($pass == $pass2){
			return preg_match("/^[a-zA-Z0-9_-]{6,25}$/", $pass);
		}
    	return false;
	}

	function checkFName($fName) {
		if(strlen($fName) > 4 && strlen($fName) < 41){
			return !preg_match("/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i", $fName);
		}
		return false;
	}

	function checkUName($uName) {
		global $errorString;
		$dbc = new dbc();
		$dbcData = array('uName' => $uName);
		$res = $dbc->query("SELECT * FROM Users WHERE uName = :uName", $dbcData);
		if ($res > 0) {
			$errorString .= "<li>- The username '" . $uName . "', is already taken.</li>";
			return false;
		} else if (!preg_match("/^[A-Za-z0-9_-]{5,25}$/", $uName)){
			$errorString .= "<li>- The username '" . $uName . "', is not correctly formated.</li>";
			return false;
		}
		return true;
	}

	function email() {
		global $eMail, $pass, $fName, $uName;

		$subject = "Welcome " . $fName . " to arbr.se!";
	$message = '
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Welcome ' . $fName . ' to arbr.se!</title>
	<style>

	  	html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,
		abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,
		strike,strong,sub,sup,tt,var,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,
		caption,tbody,tfoot,thead { 
			margin:0; padding:0; border:0; outline:0; font-weight:inherit; 
			font-style:inherit; font-size:100%; font-family:inherit; 
			vertical-align:baseline; }
		:focus { outline:0; }
		a:active { outline:none; }
		body {  color:black;  }
		ol,ul { list-style:none; }
		table { border-collapse:separate; border-spacing:0; }
		caption,th,td { text-align:left; font-weight:normal; }
		blockquote:before,blockquote:after,q:before,q:after { content:""; }
		blockquote,q { quotes:"" ""; }
		img { border: none; }

	  	body {
	  		font-family: "Helvetica", sans-serif;
	  		font-size: 14px;
	  		color: #333333;
	  		padding: 3px 2px 0px 2px;
	  	}

	  	a, a:active, a:focus, a:visited {
			color: #4786ed;
		}

		a:hover {
		 	color: #3871cf;
		}

		h2 {
			font-size: 18px;
			margin: 2px 0px 6px 0px;
	  		color: #333333;
	  		font-weight: bold;
		}

	  	.bar {
	  		width: 80%; 
	  		background-color: #333333; 
	  		height: auto;
	  		color: white;
	  		box-shadow: 0px 0px 0px 2px rgba(0,0,0,0.85);
	  		text-shadow: 0px 1px 0px rgba(0,0,0,0.8);
	  	}

	  	.top_bar {
	  		text-align: center; 
	  		font-size: 22px;
	  		font-weight: bold;
	  		border-radius: 3px 3px 0px 0px;
	  		padding: 22px 10% 22px 10%;
	  	}

	  	.bottom_bar {
	  		padding: 20px 10%;
	  		border-radius: 0px 0px 3px 3px;
	  		text-align: left;
	  		overflow: hidden;
	  	}

	  	.content {
	  		padding: 28px 17px;
	  		line-height: 130%;
	  	}

	  	.content p {
	  		text-align: center;
	  		font-style: italic;
	  		font-size: 12px;
	  		margin-top: 5px;
	  	}

	  	ul {
	  		list-style: none;
			text-align: left;
	  	}

	  	li, li a, li a:active, li a:focus, li a:visited {
	  		margin-top: 3px;
	  		text-transform: uppercase;
			font-weight: bold;
			text-decoration: none;
			color: white;
	  	}

	  	li a:hover {
	  		text-decoration: underline;
	  	}

	  	.button {
	  		height: auto;
	  		width: 80%;
			border: none;
			text-align: center;
			margin: 7px 0% 10px 0%;

			-moz-box-shadow:inset 0px 1px 0px 0px #7faaff;
			-webkit-box-shadow:inset 0px 1px 0px 0px #7faaff;
			box-shadow:inset 0px 1px 0px 0px #7faaff;
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #4d91fe), color-stop(1, #4786ed) );
			background:-moz-linear-gradient( center top, #4d91fe 5%, #4786ed 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#4d91fe", endColorstr="#4786ed");
			background-color:#4d91fe;
			-moz-border-radius:6px;
			-webkit-border-radius:6px;
			border-radius: 6px;
			border:1px solid #2f5ab7;
			display: inline-block;
			color: #ffffff;
			font-size:17px;
			font-weight:bold;
			padding: 17px 10% 17px 10%;
			text-decoration:none;
			text-shadow:0px 1px 0px #2f5ab7;
			
		}

		.button:hover {
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #4786ed), color-stop(1, #4d91fe) );
			background:-moz-linear-gradient( center top, #4786ed 5%, #4d91fe 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#4786ed", endColorstr="#4d91fe");
			background-color:#4786ed;
		}
	  	


	</style>

</head>

<body>
	<div class="bar top_bar">
		Welcome ' . $fName . ' to <a href="http://www.arbr.se">arbr.se</a>!
	</div>

	<div class="content">
		Congratulations and celebrations, you are now officially a part of something
		awesome; <a href="http://www.arbr.se">arbr.se</a>, possible the best URL-shortener
		ever created! <a href="http://www.arbr.se">arbr.se</a> provides short links with a
		high focus on statistics. We also focus alot on design, <i>everything</i> must look
		amazing.

		<br/><br/>
		<h2>Your user information:</h2>
		<b>Username</b>: ' . $uName . '<br/>
		<b>Password</b>: ' . $pass . '<br/>
		<br/>
		
		<a href="http://www.arbr.se/signin/signmein.php?uName=' . $uName . '&pass=' . $pass . '">
			<div class="button">
				View your profile
			</div>
		</a>

		<p> 
			If you have any questions about <a href="http://www.arbr.se">arbr.se</a>, feel free to contact me at 
			<a href="mailto:arvidbrane@gmail.com?Subject=arbr.se">arvidbrane@gmail.com</a>. 
			For updates, please <a href="http://www.twitter.com/kodagrux">follow me on Twitter</a>.
		</p>

	</div>

	<div class="bar bottom_bar">	
	
		<ul>
			<li><a href="http://gravatar.com/">Gravatar</a></li>
			<li><a href="http://www.arbr.se/about.html">About arbr.se</a></li>
			<li><a href="http://www.arvidbrane.se">Arvid Bräne</a></li>
			<li><a href="http://www.arbr.se/terms.html">Terms</a></li>
		</ul>
	</div>
  
</body>
</html>
		';


	$headers = "From: arbr.se <donotreply@arbr.se>" . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8';
	mail($eMail, $subject, $message, $headers);
    }


?>



<!DOCTYPE html>
<html>
	<head>

		


		<?php

			$temp = "Faliure :(";

			if($success == 5) {
				$temp = "Welcome!";
			}

			$page_title = 'arbr.se | ' . $temp;
			include('../head.php');
		?>

		<link rel="stylesheet" href="signup.css" media="screen"/>

	</head>
	<body>

		<?php
			include('../header.php');
		?>
		<section class="wrapper">
			<?php
			/*
				if($success == 5) {
					echo "Welcome " . $fName . "!";

				} else {
					if($errorString != "") {
						echo("<br/>You are not registred because <ul>" . $errorString . "</ul>");
					} else {
						echo("I'm sorry, but i have no idea why this didn't work");
					}
				}
				*/
			?>
		</section>
		<?php
			include('../footer.php');
		?>

	</body>
</html>