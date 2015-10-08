<?php

	if(($route != "" || $route != NULL) && strlen($route) == 3){
		$dbc = new dbc();
		$dbcData = array('url' => $route);
		$res = $dbc->query("SELECT urlSrc FROM Links WHERE url LIKE BINARY :url", $dbcData);
		if ($res == 1){
			$dump = $dbc->getResult();
			$dbc->query("UPDATE Links SET clicks = clicks + 1 WHERE url LIKE BINARY :url", $dbcData);
			header("Location: " . $dump["urlSrc"]);
		}	
	} else {
		//echo "fail";
		//header("Location: http://www.arbr.se");
	}

?>