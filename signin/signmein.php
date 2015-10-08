<?php

	//START SESSION
	session_start();
	

	//Error string
	$errorString = "";
	$success = 0;

	//REQUIRE FILES
	require_once '../dbc_class.php';

	//echo $_POST['eMail'];


	//VALIDATION
	$uName = $_POST['uName'];
	$pass = $_POST['pass'];

	if(!isset($uName) && !isset($pass)) {
		$uName = $_GET['uName'];
		$pass = $_GET['pass'];
	}

	//echo $uName;
	//echo $pass;

	$fName = "";

	//echo $uName . $pass;

	//Validating every entry, only format
	if(checkUName($uName) && $uName != "") {
		$success++;
		//echo $eMail . "<br/>";
	} else {
		if(checkEmail($uName) && $uName != "") {
			$success++;
		} else {
			$errorString .= "<li>- Your Username/Password has the wrong format, please try agian</li>";
		}
	}

	if(checkPassword($pass) && $pass != "") {
		$success++;
		//echo $pass . "<br/>";
	} else {
		$errorString .= "<li>- The entred password has the wrong format</li>";
	}

	

	if($success == 2) {
		$dbc = new dbc();
		$dbcData = array('uName' => $uName, 'pass' => sha1($pass . UNIQE_SALT));
		$res = $dbc->query("SELECT * FROM Users WHERE uName = :uName AND pass = :pass", $dbcData);
		if($res == 1) {
			$success++;
			userSignIn($uName);
		} 


		$dbc = new dbc();
		$dbcData = array('uName' => $uName, 'pass' => sha1($pass . UNIQE_SALT));
		$res = $dbc->query("SELECT uName FROM Users WHERE eMail = :uName AND pass = :pass", $dbcData);
		if($res == 1) {
			$success++;
			$uName = $dbc->getResult();
			userSignIn($uName["uName"]);
		} 
		
		$errorString .= "<li>- Wrong password OR the account does not exsist</li>";
			
	}

	if($errorString != ""){
		somethingWrong();
	}

		
	
    /*if($res == 1){
    	header("Location: index.php")
    }
    */
	

    function somethingWrong() {
    	global $errorString;
    	header("Location: http://arbr.se/signin/?error=" . $errorString);
    }

    function userSignIn($temp) {
    	//$uName = utf8_encode($temp["uName"]);
    	//echo "hej";
    	$_SESSION["user"]=$temp;

    	//Cookie
    	//$expire = time()+60*60*24*30; //*60*24*30;
    	//setrawcookie("user", $fName, $expire);
		//setcookie("user", $fName, $expire, "/", "arbr.se");
		//header("Location: http://arbr.se");
    	//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../profile">';
		header("Location: ../profile");
		exit;
    	
    }

    function checkEmail($uName) {
    	global $errorString;

    	if(filter_var($uName, FILTER_VALIDATE_EMAIL) && strlen($uName) < 41){
    		return preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\
    			[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $uName);
    	}
    	return false;
	}

	function checkPassword($pass) {
		return preg_match("/^[a-zA-Z0-9_-]{6,25}$/", $pass);
	}

	function checkUName($uName) {
		return preg_match("/^[A-Za-z0-9_-]{5,25}$/", $uName);
	}

	require_once '../signinCheck.php';

?>

<!DOCTYPE html>
<html>
	<head>

		<?php

			$temp = "Falied to sign in";

			if($success == 3) {
				$temp = "Welcome!";
			}

			$page_title = 'arbr.se | ' . $temp;
			include('../head.php');
		?>

		<link rel="stylesheet" href="signin.css" media="screen"/>

	</head>
	<body>



		<?php
			include('../header.php');
		?>

		<section class="wrapper">
			<?php
				if($success == 3) {
					echo "Welcome " . $uName . "!";
					echo "<br>I can haz cookie: " . $_COOKIE["user"];

				} else {
					if($errorString != "") {
						echo("<br/>You are not loged in because <ul>" . $errorString . "</ul>");
					} else {
						echo("I'm sorry, but i have no idea why this didn't work");
					}
				}
			?>
		</section>

		<?php
			include('../footer.php');
		?>

	</body>
</html>