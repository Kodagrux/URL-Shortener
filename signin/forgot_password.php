<?php
	//echo "hej";

	//REQUIRE FILES
	require_once '../dbc_class.php';

	$eMail = $_POST['eMail'];
	$errorString;
	if(!isset($eMail)) {
		$eMail = $_GET['eMail'];
	}


	if(checkEmail($eMail)) {
		$dbc = new dbc();
		$dbcData = array('eMail' => $eMail);
		$res = $dbc->query("SELECT * FROM Users WHERE eMail = :eMail", $dbcData);

		if($res == 1){
			$pass = generatePassword();
			$temp = $dbc->getResult();
			$uName = $temp["uName"];
			$fName = $temp["fName"];
			$dbcData = array('eMail' => $eMail, 'pass' => sha1($pass . UNIQE_SALT));
			$dbc->query("UPDATE Users SET pass = :pass WHERE eMail = :eMail", $dbcData);
			email($pass, $eMail, $uName, $fName);

		} else {
			$errorString .= "<li>- You are not a part of arbr.se, but be sure to sign up!</li>";
		}

	} else {
		$errorString .= "<li>- Your Username/Password has the wrong format, please try agian</li>";
	}


	





	function checkEmail($eMail) {
    	global $errorString;

    	if(filter_var($eMail, FILTER_VALIDATE_EMAIL) && strlen($eMail) < 41){
    		return preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\
    			[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $eMail);
    	}
    	return false;
	}

	function generatePassword() {

		$allowedChars = array("a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", 
			"l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "V", "w", "W", 
			"x", "X", "y", "Y", "z", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");

		$password = "";

		for ($i = 0; $i < 10; $i++) { 
			$password .= $allowedChars[rand(0, sizeof($allowedChars))];
		}

		return $password;
	}

	function email($pass, $eMail, $uName, $fName) {

		$subject = "Forgot password at arbr.se";
		$message = '
				<!DOCTYPE html>
				<html>
				<head>
					<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
					<title>So you forgot your password? No worries!</title>
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
						Forgot password? No worries!
					</div>

					<div class="content">
						A little bird told me you forgot your password at <a href="http://www.arbr.se">arbr.se</a>, 
						is this true? No worries, your password has been changed! It is highly recommended that you 
						change your password to something you will remembre.

						<br/><br/>
						<h2>Your user information:</h2>
						<b>Username</b>: ' . $uName . '<br/>
						<b><u>New</u> password</b>: ' . $pass . '<br/>
						<br/>
						
						<a href="http://www.arbr.se/signin/signmein.php?uName=' . $uName . '&pass=' . $pass . '">
							<div class="button">
								Sign in now!
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
		<meta http-equiv="content-type" content="text/html; charset=utf-8"></meta>

		<title>abr.se | Forgot password</title>

		<link rel="stylesheet" href="http://www.arbr.se/stylesheet.css" media="screen"/>
		<link rel="stylesheet" href="signin.css" media="screen"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	</head>
	<body>
		<?php
			if ($errorString != "") {
				echo("<br/>Your password was no reset because: <ul>" . $errorString . "</ul>");
			} else {
				echo("Password sent! :)");
			}
			
		?>
	</body>
</html>