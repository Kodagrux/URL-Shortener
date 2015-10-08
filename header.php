<script type="text/javascript" src="http://arbr.se/jquery.js"></script>
<script type="text/javascript" src="http://arbr.se/nav.js"></script>
<header>
	<nav>
		<span id="left">
			<div class="start"><a href="http://arbr.se"><div>arbr.se</div></a></div>
		</span>
		<span id="right"> 
			<?php 
				if($signedin) {
			?>
				<div id="dropdown">
					<ul>
						<li class="mi-1"><a href="http://arbr.se/profile">
							<div><img src="<?=$gravatar_nav; ?>" alt="<?=$fName; ?>" class="nav_profile_pic"/><?=$fName?></div>
						</a></li>
						<li class="mi-2"><a href="http://arbr.se/settings">
							<div><img src="http://www.arbr.se/img/settings.png" alt="Settings" class="nav_misc_pic"/>Settings</div>
						</a></li>
						<li class="mi-3"><a href="http://arbr.se/logout.php">
							<div><img src="http://www.arbr.se/img/signout.png" alt="Sign out" class="nav_misc_pic"/>Sign out</div>
						</a></li>
					</ul>
				</div> 
				
			<?php 
				} else {
			?>
				<div id="signup"><a href='http://arbr.se/signup'><div>Sign up</div></a></div>
				<div id="signin"><a href='http://arbr.se/signin'><div>Sign in</div></a></div>
			<?php 
				}
			?>

		</span>
	</nav>
</header>


