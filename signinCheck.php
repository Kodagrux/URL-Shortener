<?php
	session_start();
	require_once 'dbc_class.php';
	
	$signedin = false;
	$IDuser;
	$fName;
	$gravatar_nav;
	$eMail;
	$uName;

	if(isset($_SESSION["user"])) {
		$uName = $_SESSION["user"];
		$dbc = new dbc();
		$dbcData = array('uName' => $uName);
		$res = $dbc->query("SELECT * FROM Users WHERE uName = :uName", $dbcData);

		if($res == 1) {
			$signedin = true;
			$temp = $dbc->getResult();
			$eMail = $temp["eMail"];
			$IDuser = $temp["IDuser"];
			$gdefault = "http://www.arbr.se/img/default.jpg";
			$gsize = 20;
			$gravatar_nav = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($temp["eMail"]))) 
				. "?d=" . urlencode($gdefault) . "&s=" . $gsize;
			$fName = utf8_encode($temp["fName"]);

		}
	} 
?>