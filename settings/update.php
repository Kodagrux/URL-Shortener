<?php

	//START SESSION
	session_start();
	require_once '../signinCheck.php';

	if(!$signedin) {
		header("Location: http://www.arbr.se/signin/?misc=" . "To change your settings, you must be signed in!");
	} 

	header('Content-Type: text/html; charset=utf-8');

	//Error string
	$errorString = "";
	$success = 0;


	//REQUIRE FILES
	//require_once '../dbc_class.php';


	//VALIDATION
	$bio = $_POST['bio'];
	$pass2 = $_POST['pass2'];
	$pass = $_POST['pass'];


	//Validating every entry, only format

	if(checkPassword($pass, $pass2)) {
		$success++;
	} else if (($pass == "" && $pass2 == "") || (!isset($pass) && !isset($pass2))) {
		$success++;
	} else {
		$errorString .= "<li>Your password is not correctly formated.</li>";
	}

	if(checkBIO($bio)) {
		$success++;
	} else {
		$errorString .= "<li>Your BIO '" . $bio . "', it sounds fishy...</li>";
	}


	if($success == 2) {

		$dbc = new dbc();

		if($pass != "" && isset($pass)) {
	    	$dbcData = array('pass' => sha1($pass . UNIQE_SALT), 'IDuser' => $IDuser);
	    	$dbc->query("UPDATE Users SET pass = :pass WHERE IDuser = :IDuser", $dbcData);
		} 

    	$dbcData = array('bio' => $bio, 'IDuser' => $IDuser);
    	$dbc->query("UPDATE Users SET bio = :bio WHERE IDuser = :IDuser", $dbcData);

    	session_destroy();
		header("Location: http://www.arbr.se/signin/signmein.php?pass=" . $pass . "&uName=" . $eMail);

	} else {
		header("Location: http://www.arbr.se/settings/?error=" . $errorString);
	}
    /*if($res == 1){
    	header("Location: index.php")
    }
    */

	function checkPassword($pass, $pass2) {
		if($pass == $pass2){
			return preg_match("/^[a-zA-Z0-9_-]{6,25}$/", $pass);
		}
    	return false;
	}

	function checkBIO($fName) {
		if(strlen($fName) < 300){
			return true;
		}
		return false;
	}


?>