<?php
	
	/*
	
		 ######  ########    ###    ########  ######## 
		##    ##    ##      ## ##   ##     ##    ##    
		##          ##     ##   ##  ##     ##    ##    
		 ######     ##    ##     ## ########     ##    
		      ##    ##    ######### ##   ##      ##    
		##    ##    ##    ##     ## ##    ##     ##    
		 ######     ##    ##     ## ##     ##    ##    


	http://patorjk.com/software/taag/
	*/
	$route = $_GET["_route_"];
	require_once 'signinCheck.php';
	require_once 'redirect.php';
	header('Content-Type: text/html; charset=utf-8');

	$error = $_GET["error"];
	$success = $_GET["success"];
	$misc = $_GET["misc"];


	function printMessages(){

		global $error, $success, $misc;

		if(isset($error)) {
?>
			<div class="message_box message_error">
				<span class="message_header">The link '<?=$error?>' is not a valid link</span>
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
				<span class="message_header">Welcome <?=$success?>! You are now registred and able to sign in, happy shortening!</span>
			</div>
<?php
		}
	}


?>

<!DOCTYPE html>
<html>
	<head>

		<?php
			$page_title = 'arbr.se | URL-shortener';
			include('head.php');
		?>
		<link rel="stylesheet" href="index.css" media="screen"/>

	</head>
	<body>

		<?php
			
			include('header.php');
			//echo "I can haz cookie: " . $_COOKIE["user"];
		?>
		
		
		

		<section id="photo" class="hidden">

			<div id="url_box" class="hidden">
				<form name="CreateLink" action="createlink.php" method="post">

					<input name="link" class="field" TABINDEX="1" type="text" id="link" class="link" placeholder="Paste URL here">

					<input type="submit" TABINDEX="2" id="submit" value="Shorten" class="submit">

				</form>
				<?php
			if(isset($error) || isset($misc) || isset($success)){
				echo "<div class='start_feedback'>";
				printMessages();
				echo "</div>";
			}	
		?>
				
			</div>
			<div class="photo_info hidden">
				<p class="photo_info">
					This picture is brought to you by <a href="http://www.flickr.com/photos/ashleyherrin/6227571565/in/photostream">ashleyherrin</a>
				</p>
			</div>
		</section>
			
		<section class="wrapper hidden">

			<?php

			/*
			if (isset($_COOKIE["user"]))
			  echo "Welcome " . $_COOKIE["user"] . "!<br>";
			else
			  echo "Welcome guest!<br>";
			*/

			?>

			<h1 class="header1 hidden">
				Most possibly the best URL-shortener in the whole wide world. Fo realz yo.
			</h1>


			<section class="about">
				<div class="about_info_safe about_info hidden">
					<img src="img/safe.png" alt="" class="about_info_img">
					<h3>Saftey</h3>
					<p class="about_info_dscription">
						With us <i>all</i> your links are secure. Your links, your statistics. Feel
						like a link is beeing missused by someone else? No worries, just re-shorten it 
						and you'll be back and running in no time! 
					</p>
				</div>
				<div class="about_info_stats about_info hidden">
					<img src="img/stats.png" alt="" class="about_info_img">
					<h3>Statistics</h3>
					<p class="about_info_dscription">
						Not only are the statistics precise, but they are also saved safley on our servers 
						till the end of time (or you know, until we shut down)! No more hassel, just
						pure fun! 
					</p>
				</div>
				<div class="about_info_short about_info hidden">
					<img src="img/short.png" alt="" class="about_info_img">
					<h3>Short links</h3>
					<p class="about_info_dscription">
						You know how you want to get short links when you shorten a link? Well we have that!
						We don't have any of that 7-characters-long-URL-identifier. Our links are <i>short</i>, 
						really short; just 3 characters!
					</p>
				</div>
			</section>

			<section class="signup">
				<h1 class="header2 hidden">
					Sound too good too be true? What are you waiting for, 
					sign up today and give arbr.se a chance to blow your mind!
				</h1>
				<a href="http://www.arbr.se/signup" class="button hidden">
					<div class="button">
						This sounds fantastic, sign me up!
					</div>
				</a>
			</section>




		</section>

		<?php
			include('footer.php');
		?>
		
		<script type="text/javascript" src="index.js"></script>
		<script type="text/javascript" src="signup/jquery.lockSubmit.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(':submit').lockSubmit({
					submitText: "Please wait"
				});
			});
		</script>

	</body>
</html>