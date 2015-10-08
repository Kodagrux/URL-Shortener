<?php

	$link = $_POST['link'];
	$link_orginal = $link;

	$allowedChars = array("a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", 
		"l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "V", "w", "W", 
		"x", "X", "y", "Y", "z", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "$", "-", "+", "!", "'", "(", ")");

	$allowedCharsReversed  = array("a" => 1, "A" => 2, "b" => 3, "B" => 4, "c" => 5, "C" => 6, "d" => 7, "D" => 8, "e" => 9, "E" => 10, 
		"f" => 11, "F" => 12, "g" => 13, "G" => 14, "h" => 15, "H" => 16, "i" => 17, "I" => 18, "j" => 19, "J" => 20, "k" => 21, 
		"K" => 22, "l" => 23, "L" => 24, "m" => 25, "M" => 26, "n" => 27, "N" => 28, "o" => 29, "O" => 30, "p" => 31, "P" => 32, 
		"q" => 33, "Q" => 34, "r" => 35, "R" => 36, "s" => 37, "S" => 38, "t" => 39, "T" => 40, "u" => 41, "U" => 42, "v" => 43, 
		"V" => 44, "w" => 45, "W" => 46, "x" => 47, "X" => 48, "y" => 49, "Y" => 50, "z" => 51, "Z" => 52, "0" => 53, "1" => 54, 
		"2" => 55, "3" => 56, "4" => 57, "5" => 58, "6" => 59, "7" => 60, "8" => 61, "9" => 62, "$" => 63, "-" => 64, "+" => 65, 
		"!" => 66, "'" => 67, "(" => 68, ")" => 69);

	require_once 'signinCheck.php';

	if (!$signedin) {
		header("Location: http://arbr.se/signup/?misc=" . "<li>In order to create a link you need to sign up and then sign in</li>");
		exit;
	} else if ($link == null || $link == "") {
		//Empty link
		header("Location: http://arbr.se");
		exit;
	}

	$link = fixLink($link); 
	if($link != false){ 
		//echo $IDuser;
		insertLink($link);

		//echo $link;
	} else {
		//FAIL
		header("Location: http://arbr.se/?error=" . $link_orginal);
		//echo "Something wrong with your link: '" . $link . "'";
	}


	//FUNCTIIONS
	function fixLink($link) {
		if(preg_match("/^(https?:\/\/)?([\da-zåäöA-ZÅÄÖ0-9\.-]+)\.([a-zA-Z0-9\.]{1,6})([\/\w \.-]*)*\/?$/", $link)){
			//correct
			if(strstr($link, "https://") == false && strstr($link, "http://") == false){
				//add http
				$link = "http://" . $link;
			}
			return $link;	
		} else {
			//bad link
			return false;
		}
	}

	function insertLink($link){
		global $IDuser;
		$shortLink = shortenLink();
		$dbc = new dbc();
	    $dbcData = array('link' => $link, 'favicon' => "http://g.etfv.co/" . $link, 'IDuser' => $IDuser, 'url' => $shortLink);
	    $dbc->query("INSERT INTO Links(url, urlSrc, favicon, IDuser) VALUES(:url, :link, :favicon, :IDuser) ", $dbcData);

	    //Update user nrLinks
	    //$dbc = new dbc();
	    //$dbcData = array('IDuser' => $IDuser);
	    //$dbc->query("UPDATE Users SET nrLinks = nrLinks + 1 WHERE IDuser = :IDuser", $dbcData);

	    header("Location: http://arbr.se/profile/?success=" . $shortLink);
	    

	}

	//Convert FROM letters TO numbers
	function decodeLink($temp) {
		global $allowedCharsReversed;

		$nr1 = $allowedCharsReversed[substr($temp["url"], 0, 1)]-1;
		$nr2 = $allowedCharsReversed[substr($temp["url"], 1, 1)]-1;
		$nr3 = $allowedCharsReversed[substr($temp["url"], 2, 1)]-1;

		return $nr1 . "," . $nr2 . "," . $nr3;
	}

	//Convert FROM numbers TO letters 
	function encodeLink($temp) {
		global $allowedChars;
		$short = explode(",", $temp);

		return $allowedChars[$short[0]] . $allowedChars[$short[1]] . $allowedChars[$short[2]];
	}

	//Shortens link
	function shortenLink () {
		$arraySize = 69;
		$short = "";
		
		$dbc = new dbc();
		$res = $dbc->query("SELECT url FROM Links WHERE (SELECT MAX(IDlink) FROM Links) = IDlink");

		if($res != 0) {
			//var_dump($dbc->getResult());
			$res = decodeLink($dbc->getResult());
			//exit;
			$latestURL = explode(",", $res);

			if ($latestURL[2] == 68) {
				$latestURL[2] = "0";
				if ($latestURL[1] == 68) {
					$latestURL[1] = "0";
					if ($latestURL[0] == 68) {
						echo "Slut på URL:er!!!";
						exit;
					} else {
						$latestURL[0]++;
					}
				} else {
					$latestURL[1]++;
				}
			} else {
				$latestURL[2]++;
			}

			$short = $latestURL[0] . "," . $latestURL[1] . "," . $latestURL[2];

		} else {
			$short = "0,0,0";
		}
		return encodeLink($short);
	}

?>