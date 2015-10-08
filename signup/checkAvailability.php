<?php

	$uName = $_GET["q"];

	require_once '../dbc_class.php';

	$dbc = new dbc();
	$dbcData = array('uName' => $uName);
	$res = $dbc->query("SELECT * FROM Users WHERE uName = :uName", $dbcData);



	if ($res != 0) {
		echo "0";
	} else {
		echo "1";
	}

?>