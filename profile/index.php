<?php

	/*

		########  ########   #######  ######## #### ##       ######## 
		##     ## ##     ## ##     ## ##        ##  ##       ##       
		##     ## ##     ## ##     ## ##        ##  ##       ##       
		########  ########  ##     ## ######    ##  ##       ######   
		##        ##   ##   ##     ## ##        ##  ##       ##       
		##        ##    ##  ##     ## ##        ##  ##       ##       
		##        ##     ##  #######  ##       #### ######## ######## 
	
	*/

	header('Content-Type: text/html; charset=utf-8');
	require_once '../signinCheck.php';
	//require_once '../dbc_class.php';
	

	//Check if user is signed in
	if(!$signedin) {
		header("Location: http://www.arbr.se/signin/?misc="  . "To view your profile, you must be signed in!");
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
	$permissions = $res["permissions"];
	//$nrLinks = $res["nrLinks"];


	//Gravatar
	$default = "http://www.arbr.se/img/default.jpg";
	$size = 170;
	$gravatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($eMail))) . "?d=" . urlencode($default) . "&s=" . $size;



	$createdLinks;
	$dump;
	$res;

	$dbc = new dbc();
	$dbcData = array('IDuser' => $IDuser);
	$res = $dbc->query("SELECT * FROM Links WHERE IDuser = :IDuser", $dbcData);
	$dump = $dbc->getAllResult();



	function printUserInfo() {
		global $fName, $IDuser, $uName, $signUp, $eMail, $bio, $res;
		//if($res > 0) {

			$temp = explode(" ", $signUp);

			echo "<h2>" . $fName . "</h2>";
			//echo $IDuser . "<br/>";
			echo "<span class='profile_headers'>Username: </span>" . $uName . "<br/>";
			
			echo "<span class='profile_headers'>Email: </span>" . $eMail . "<br/>";
			//echo "<span class='profile_headers'>Member since: </span>" . $temp[0] . "<br/>";
			//echo "<span class='profile_headers'>Number of links: </span>" . $res . "<br>";
			if ($bio != null) {
				 echo "<div class='bio'>" . $bio . "</div><br/>";
			}
		//}
	}


	function printLinks() {

		global $res, $dump;
		if (isset($dump)) {
			$i = 0;
			?>
			<table>
				<tr class="listheaders">
					<th class="icon">Icon</th>
					<th class="src">Source</th>
					<th class="short">Shortend</th>
					<th class="clicks">Clicks</th>
					<th class="time">Date</th>
					<th class="edit">Action</th>
				</tr>
			<?php
			while ($res > 0){

				$temp = explode(" ", $dump[$i]["time"]);
				$time = $temp[0];
				$link = "";
				$listitem = "1";
				if($i % 2) {
					$listitem = "2";
				}

				if (strlen($dump[$i]["urlSrc"]) > 50) {
					$link = substr($dump[$i]["urlSrc"], 0, 50-strlen($dump[$i]["urlSrc"])) . "...";
				} else {
					$link = $dump[$i]["urlSrc"];
				}
				echo "<tr class='listitem" . $listitem . "'>"; 
				echo "<td class='icon'><img src='http://g.etfv.co/" . $dump[$i]["urlSrc"] . "?defaulticon=lightpng' height='16' width='16'/></td>";
				echo "<td class='src'><a href='" . $dump[$i]["urlSrc"] . "'>" . $link . "</a></td>";
				echo "<td class='short'><a href='http://www.arbr.se/" . $dump[$i]["url"] . "'>arbr.se/" . $dump[$i]["url"] . "</a></td>";
				echo "<td class='clicks'>" . $dump[$i]["clicks"] . "</td>";
				echo "<td class='time'>" . $time . "</td>";
				echo "<td class='edit'><a href='../deletelink.php?id=". $dump[$i]["IDlink"] ."'>Delete</a> <a href=''>Copy</a></td>";
				echo "</tr>"; 

				$i++;
				$res--;
			}
			echo "</table>";
		} else {
			echo "You have no links :(";
		}
	}

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
			<span class="message_header">The link was shortned:	 <a href="http://www.arbr.se/<?=$success?>">http://www.arbr.se/<?=$success?></a></span>
		</div>
<?php
		}
	}




?>



<!DOCTYPE html>
<html>
	<head>
		<?php
			$page_title = 'arbr.se | ' . $uName;
			include('../head.php');
		?>
		<link rel="stylesheet" href="profile.css" media="screen"/>
	</head>
	<body>

		<?php
			include('../header.php');
		?>

		<section id="photo">
			<section id="profile_info">
				<div style="background-image: url(<?=$gravatar;?>); background-size: 100%;" alt="Gravatar" class="profile_pic"></div><br/>
				<div class="profile_info">
					<?php
						printUserInfo();
					?>
				</div>
			</section>
		</section>

		<section class="wrapper">

			<?php
				printMessages();
			?>

			<section id="links">
				<?php				
					printLinks();	
				?>
			</section>

			<section class="add_new_link">
				<form name="CreateLink" action="../createlink.php" method="post">
					<input name="link" class="field" TABINDEX="1" type="text" id="link" class="link" placeholder="Paste URL here">
					<input type="submit" TABINDEX="2" id="submit" value="Shorten" class="submit">
				</form>
			</section>

		</section>

		<?php
			include('../footer.php');
		?>

		<script type="text/javascript" src="profile.js"></script>
	</body>
</html>


















