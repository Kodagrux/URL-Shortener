<?php
	
	require_once 'signinCheck.php';

	if(!$signedin) {
		header("Location: /signin");
		exit;
	} 

	$IDlink = $_GET['id'];

	$dbc = new dbc();
	$dbcData = array('IDuser' => $IDuser, 'IDlink' => $IDlink);
	$dbc->query("DELETE FROM Links WHERE IDuser = :IDuser AND IDlink = :IDlink", $dbcData);
	
	header("Location: /profile");

?>