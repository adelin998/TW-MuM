<?php

	session_start();

	require('fpdf/fpdf.php');
	
	$uname = "";
	$pword = "";
	$email = "";
	$errorMessage = "";

	$comment="";

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
  		require 'configure.php';

  		$uname = $_POST['username'];
  		$pword = $_POST['password'];
  		$email = $_POST['email'];

  		$database = "mum";

  		$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

  		if ($db_found)
  		{    
    		$SQL = $db_found->prepare('SELECT * FROM users WHERE Username = ?');
    		$SQL->bind_param('s', $uname);
    		$SQL->execute();
    		$result = $SQL->get_result();
    		print "found";

    		if ($result->num_rows > 0)
    		{
      			$errorMessage = "Username already taken.";
    		}

    		else
    		{
      			$hash = md5( rand(0,1000) );
      			$phash = password_hash($pword, PASSWORD_DEFAULT);
      			$SQL = $db_found->prepare("INSERT INTO users (Username, Password, Email, Hash) VALUES (?, ?, ?, $hash)");
      			$SQL->bind_param('ss', $uname, $phash);
      			$SQL->execute();

      			header ("Location: index.php");
    		}
    	}

    	else
    	{
    		$errorMessage = "Database Not Found";
 		}
 	}

	function regenerateToken()
	{
		$refresh_token = 'AQDuPpO6UcCWvUHym0ix6sM3JCNc1Q2yK-dlxqwDepL-RgPfTZ3Lp43dSmg5NhcrpE3uADEUUYMufT-PJKRMRuoV4OyYWVgahSFCmLEPl9WqlydAyJqPfJ3gIPfXHbhfYMw';

		$client_code = 'ZjY4NGUwNjJmOWU5NGU2NmE1MmU5ZGE1OWVlMjVkMDQ6YjgwOTgxNjA3NzI4NDczOGFiMzc1ZDM4ZmQyZjIyYzU=';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=".$refresh_token);
		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();
		$headers[] = 'Authorization: Basic '.$client_code;
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);

		if (curl_errno($ch))
		{
	    	echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);

		$result = json_decode($result, true);

		return $result['access_token'];
	}

	function getPlaylistTracks($playlist_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/playlists/'.$playlist_id.'/tracks';
		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		$tracks = array();

		foreach ($result['items'] as $item)
		{
			$title = $item['track']['name'];

			$artists = array();

			$id = $item['track']['id'];

			foreach ($item['track']['artists'] as $artist)
			{
			array_push($artists, $artist['name']);
			}

			$duration = (int)$item['track']['duration_ms']/1000;

			$image = getTrackCover($id);

			array_push($tracks, array( 'id' => $id, 'title' => $title, 'artists' => $artists, 'duration' => $duration,'image' => $image ) );
		}

		return $tracks;
	}

	function createTrackPage($track_id)
	{
		if (file_exists("Content/Images/Albums/".$track_id.'.jpg') == FALSE)
			file_put_contents("Content/Images/Albums/".$track_id.'.jpg', file_get_contents(getTrackCover($track_id)));

		if (file_exists("Tracks/".$track_id.".php") == FALSE)
		{
			$myfile = fopen("Tracks/".$track_id.".php", "w");

			$page_content = "<html>
	<head>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../Content/CSS/index.css\">
	</head>

	<body>
		<div class=\"topbar\">
			<div class=\"menu\">
					<img src=\"../Content\Images\Icons\MenuIcon.png\">
			</div>

			<a href=\"../index.php\">
				<img class=\"logo\" src=\"../Content/Logo/Logo.png\">
			</a>

			<div class=\"searchbox\">
					<input type=\"text\" placeholder=\"Search...\">
					<img src=\"../Content\Images\Icons\Search.png\">
			</div>

			<div class=\"auth\">
				<button onclick=\"toggleLoginBox()\">Login</button>
				<img src=\"../Content\Images\Icons\Separator.png\">
				<button onclick=\"myFunction()\">Register</button>
			</div>
		</div>

		<div class=\"metadata\">
			<img src=\"../Content/Images/Albums/".$track_id.".jpg\">
			<p>Title: ".getTrackName($track_id)."</p>
			<p>Artist(s): ".getTrackArtist($track_id)."</p>
			<p>Album: ".getTrackAlbum($track_id)." (Track number on album: ".getTrackNumber($track_id)." |  Disc Number: ".getDiscNumber($track_id).")</p>
			<p>Release Date: ".getTrackReleaseDate($track_id)."</p>
			<p id=\"demo\"></p>
			<button onclick=\"exportPDF()\">Export data as PDF</button>
		</div>

		<div class=\"comments\">
			<h1>Comments</h1>

		<script>
		function toggleLoginBox()
		{
			var show = document.getElementById(\"loginBox\");

			if( show.style.display === \"none\" )
			{
				show.style.display = \"block\";
			}
			else
			{
				show.style.display = \"none\";
			}
		}

		function exportPDF()
		{
			`<?php
				echo \"<h2>PHP is Fun!</h2>\";

				require('fpdf.php');

				\$pdf = new FPDF();
				\$pdf->AddPage();
				\$pdf->SetFont('Arial','B',16);
				\$pdf->Cell(40,10,'Hello World!');
				\$pdf->Output(\"I\", \"".$track_id."\");
			?>`
		}
	</script>

	</body>
</html>";

			fwrite($myfile, $page_content);
		}
	}

	function getTrackName($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		return $result['name'];
	}

	function getTrackArtist($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		$track_artists = "";

		foreach ($result['artists'] as $artist)
		{

			$track_artists .= $artist['name']." ";
		}

		return $track_artists;
	}

	function getTrackReleaseDate($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		return $result['album']['release_date'];
	}

	function getTrackAlbum($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		return $result['album']['name'];
	}

	function getTrackNumber($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		return $result['track_number'];
	}

	function getDiscNumber($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		return $result['disc_number'];
	}

	function getTrackCover($track_id)
	{
		global $access_token;

		$url = 'https://api.spotify.com/v1/tracks/'.$track_id;

		$authorization = "Authorization: Bearer ".$access_token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result, true);

		$images = '';

		foreach ($result['album']['images'] as $image)
		{
			$image = $image['url'];
			break;
		}

		return $image;
	}

	$access_token = regenerateToken();

	$playlist_id = '37i9dQZEVXbMDoHDwVN2tF';

	$tracks = getPlaylistTracks($playlist_id);

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Content/CSS/index.css">
	</head>

	<body>
		<div class="topbar">
			<div class="menu">
					<img src="Content\Images\Icons\MenuIcon.png">
			</div>

			<a href="index.php">
				<img class="logo" src="Content/Logo/Logo.png">
			</a>

			<div class="searchbox">
					<input type="text" placeholder="Search...">
					<img src="Content\Images\Icons\Search.png">
			</div>

			<div class="auth">
				<button onclick="toggleLoginBox()">Login</button>
				<img src="Content\Images\Icons\Separator.png">
				<button onclick="toggleRegisterBox()">Register</button>
			</div>
		</div>

		<div class="loginBox" id="loginBox">
			<p>Username:</p>
		</div>

		<div class="registerBox" id="registerBox">
			<form name="userRegistration" class="regBox" method="post" action="">
				<div class="block">
          			<input type="text" name="username" placeholder="Username" value="<?PHP print $uname;?>">
          			<label style="font-family:'Montserrat'; font-weight:normal;font-size:20px; color:#ffffff"><?PHP print $errorMessage;?></label>
        		</div>

        		<div>
          			<input type="text" name="email" placeholder="E-mail" value="<?PHP print $email;?>">
        		</div>

        		<div>
          			<input id="password" type="password" name="password" placeholder="Password" value="<?PHP print $pword;?>" onkeyup='check();'>
        		</div>

        		<div>
          			<input id="confirm_password" type="password" name="" placeholder="Repeat password" onkeyup='check();'>
        		</div>

        		<span id='message'></span>

        		<input type="submit" name="" value="Register">

        		<div>
        			<h1 style="font-family:'Arial'; font-weight:normal;font-size:20px">Already have an account?</h1>
        			<button onclick="toggleLoginBox()" style="font-family:'Nugget Medium';font-weight:normal;font-size:20px; color: #ffffff; text-decoration: none;">Log in.</button>
      			</div>
      		</form>
		</div>

		<div class="fadein">
			<h1>The top 50 tracks now</h1>
		</div>

		<h2 class="filtersTitle">Filters:</h2>

		<div class="filters">
			Album: <select id="albumFilter" onchange="filter()">
				<option value="">Any</option>
			</select>

			Artist: <select id="artistFilter" onchange="filter()">
				<option value="">Any</option>
			</select>

			Year: <select id="yearFilter" onchange="filter()">
				<option value="">Any</option>
			</select>
		</div>

		<div class="showcase">
			<!--
			<a href="Tracks/rockstar.php">
				<img src="Content/Images/Albums/Rockstar.jpg">
			</a>
			<img src="Content/Images/Albums/Blinding-Lights.jpg">
			<img src="Content/Images/Albums/Roses.jpg">
		-->

			<?php

			// $showcase_array = array_slice($tracks, 0, 3);
			$showcase_array = $tracks;

			foreach($showcase_array as $track)
			{
				
				$track_info = createTrackPage($track['id']);

				?>
				<div class="track_item" data-track_album = "<?php echo $track_info['album']; ?>" data-track_artists="
				<?php echo $track_info['artists']; ?>" data-track_year="<?php echo $track_info['release_date']; ?>">
					<a href="Tracks/<?php echo $track['id']; ?>.php">
						<img src="<?php echo $track['image']; ?>" alt = "<?php echo $track['title']; ?>" width="500">
					</a>
				</div>
				<?php 
 			}?>

 			<p id="noResult">No result</p>
<!-- 			<br style="clear: both">
			<button>View All</button> -->
		</div>



	<script>
		function toggleLoginBox()
		{
			var loginShow = document.getElementById("loginBox");
			var registerShow = document.getElementById("registerBox");

			if( loginShow.style.display === "none" )
			{
				registerShow.style.display = "none";
				loginShow.style.display = "block";
			}
			else
			{
				loginShow.style.display = "none";
			}
		}

		function toggleRegisterBox()
		{
			var loginShow = document.getElementById("loginBox");
			var registerShow = document.getElementById("registerBox");

			if(registerShow.style.display === "none")
			{
				loginShow.style.display = "none";
				registerShow.style.display = "block";
			}
			else
			{
				registerShow.style.display = "none";
			}
		}

		var tracks_items = document.getElementsByClassName('track_item');

		var albumFilter = document.getElementById('albumFilter');

		var artistFilter = document.getElementById('artistFilter');
		
		var yearFilter = document.getElementById('yearFilter');

		var optionsAlbum = [];
		var optionsArtists = [];
		var optionsYear = [];

		for(let i=0; i<tracks_items.length; i++){
			let album = tracks_items[i].dataset.track_album.toLowerCase().trim();
			let artists = tracks_items[i].dataset.track_artists.split(',');
			let year = tracks_items[i].dataset.track_year;

			for(let j=0; j<artists.length; j++){
				let artist = artists[j].toLowerCase().trim();

				if(!optionsArtists.includes(artist)){
					optionsArtists.push(artist);
				}
			}

			if(!optionsAlbum.includes(album)){
				optionsAlbum.push(album);
			}

			if(!optionsYear.includes(year)){
				optionsYear.push(year);
			}
		}


		for(let i=0; i<optionsAlbum.length; i++){
			albumFilter.innerHTML += `<option class="albumOption" value="${optionsAlbum[i]}">${optionsAlbum[i]}</option>`;
		}

		for(let i=0; i<optionsArtists.length; i++){
			artistFilter.innerHTML += `<option class="artistOption" value="${optionsArtists[i]}">${optionsArtists[i]}</option>`;
		}

		optionsYear.sort();

		for(let i=0; i<optionsYear.length; i++){
			yearFilter.innerHTML += `<option class="yearOption" value="${optionsYear[i]}">${optionsYear[i]}</option>`;
		}

		function filter(){
			let tracks = document.getElementsByClassName('track_item');

			let visibleTracks = 0;

			for(let i=0; i<tracks.length; i++){

				let t_album = tracks[i].dataset.track_album.toLowerCase().trim();
				let t_year = tracks[i].dataset.track_year;
				let t_artists = tracks[i].dataset.track_artists.split(',');

				if((yearFilter.value == '' || (yearFilter.value != '' && yearFilter.value == t_year))
				  && (albumFilter.value == '' || (albumFilter.value != "" && albumFilter.value == t_album)) 
				  && (artistFilter.value == '' || (artistFilter.value != '' && artistInArray(t_artists, artistFilter.value) == 1))){
					tracks[i].style.display = "block";
					visibleTracks++;
				}
				else{
					tracks[i].style.display = "none";
				}

				if(visibleTracks == 0){
					document.getElementById('noResult').style.display = 'block';
				}else{
					document.getElementById('noResult').style.display = 'none';
				}
			}
		}

		function artistInArray(array, artist){
			let ok = 0;
			artist = artist.toLowerCase().trim();

			for(let i=0; i<array.length; i++){
				if(artist == array[i].toLowerCase().trim()){
					ok = 1;
					break;
				}
			}

			return ok;
	</script>

	</body>
</html>