	<!--
	<div class="topbar">
			<div class="topbar-right">
				<a class ="login_register" href="<?php echo '/Proiect-TW/login.php';?>" style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">Login</a>
				<a class ="login_register" href="<?php echo '/Proiect-TW/register.php';?>" style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">Register</a>
			</div>

			<div class="searchbox">
				<form  action="<?php echo '/Proiect-TW/search.php';?>" method="get">
					<input type="text" name="search_query" placeholder="Search..." style="font-family:'Montserrat'; font-weight:normal;font-size:20px">
					<input type="image" src="Content\Images\Icons\search_icon.png" class="search_icon" width="25" height="25">
				</form>
			</div>

			<div class="nowplaying">
				<p style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">No music is currently playing.</p>
			</div>

	</div>
	-->

	<div class="topbar">
			<div class="menu">
					<img src="..\Content\Images\Icons\MenuIcon.png">
			</div>

			<a href="..\Pages\index.php">
				<img class="logo" src="..\Content/Logo/Logo.png">
			</a>

			<div class="searchbox">
				<form  action="<?php echo '/Proiect-TW/Pages/search.php';?>" method="get">
					<input type="text" name="search_query" placeholder="Search...">
					<img src="..\Content\Images\Icons\Search.png">
				</form>
			</div>

			<div class="auth">

				<?php
				if(!isset($_SESSION['logged']))
				{
					?>
					<button style="cursor:pointer" onclick="window.location.href='../Pages/login.php'">Login</button>
					<img src="..\Content\Images\Icons\Separator.png">
					<button style="cursor:pointer" onclick="window.location.href='../Pages/register.php'">Register</button>
				<?php }

				else
				{
					?>
					<button style="cursor:pointer" onclick="window.location.href='../Pages/userProfile.php'"><?php echo $_SESSION['login_user'];?></button>
					<img src="..\Content\Images\Icons\Separator.png">
					<button style="cursor:pointer" onclick="window.location.href='../Pages/logout.php'">Log Out</button>
				<?php } ?>
			</div>
		</div>