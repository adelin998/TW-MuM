	<div class="topbar">
			<div class="topbar-right">
				<a class ="login_register" href="<?php echo ROOT_URL.'login.php';?>" style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">Login</a>
				<a class ="login_register" href="<?php echo ROOT_URL.'register.php';?>" style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">Register</a>
			</div>

			<div class="searchbox">
				<form  action="<?php echo ROOT_URL.'search.php';?>" method="get">
					<input type="text" name="search_query" placeholder="Search..." style="font-family:'Montserrat'; font-weight:normal;font-size:20px">
					<input type="image" src="Content\Images\Icons\search_icon.png" class="search_icon" width="25" height="25">
				</form>
			</div>

			<div class="nowplaying">
				<p style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">No music is currently playing.</p>
			</div>

	</div>