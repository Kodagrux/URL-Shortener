<?php
	session_start();
	session_destroy();
	setcookie("user", $_COOKIE["user"], time()-3600, "/", "arbr.se");
	header("Location: http://arbr.se");
?>