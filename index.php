<?php

		define('DB_SERVER', 'localhost');
   		define('DB_USERNAME', 'root');
  		define('DB_PASSWORD', '');
   		define('DB_DATABASE', 'mum');

	session_start();

	$comment="";

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

        $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

		$t_title = getTrackName($track_id);
		$t_artists = getTrackArtist($track_id);
		$t_t_artists= implode(' , ', $t_artists);
		$t_album = getTrackAlbum($track_id);
		$track_image = getTrackCover($track_id);

		$t_release_date = getTrackReleaseDate($track_id);

		if (file_exists("Content/Images/Albums/".$track_id.'.jpg') == FALSE)
			file_put_contents("Content/Images/Albums/".$track_id.'.jpg', file_get_contents($track_image));
		$sql = "INSERT INTO songs (id,title,artist,album,data, image) 
		VALUES ('$track_id','$t_title','$t_t_artists','$t_album','$t_release_date', '$track_image')";
		if ($db->query($sql) === TRUE) {
  			$ok=1;}
		else $ok=0;
  		$db->close();


		if (file_exists("Tracks/".$track_id.".php") == FALSE)
		{
			$myfile = fopen("Tracks/".$track_id.".php", "w");

			$page_content = "
			<?php
				session_start();
			?>
	<html>
	<head>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../Content/CSS/index.css\">
	</head>

	<body>
		<!--
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
		-->

		<?php  include('../includes/topbar.php'); ?>

		<div class=\"metadata\">
			<img src=\"../Content/Images/Albums/".$track_id.".jpg\">
			<p>Title: ".getTrackName($track_id)."</p>
			<p>Artist(s): ".implode(' , ', $t_artists)."</p>
			<p>Album: ".$t_album." (Track number on album: ".getTrackNumber($track_id)." |  Disc Number: ".getDiscNumber($track_id).")</p>
			<p>Release Date: ".$t_release_date."</p>
		</div>

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
	</script>

	</body>
</html>";

			fwrite($myfile, $page_content);
		}

		$date = DateTime::createFromFormat("Y-m-d", $t_release_date);
		$year = $date->format("Y");

		$track_info = array(
							'artists' => implode(',', $t_artists),
							'album' => $t_album,
							'release_date' => $year,
							'image' => $track_image
		);

		return $track_info;
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

		// $track_artists = "";

		// foreach ($result['artists'] as $artist)
		// {

		// 	$track_artists .= $artist['name']." ";
		// }

		$output = array();

		foreach ($result['artists'] as $artist) {
			array_push($output, $artist['name']);
		}

		return $output;
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

		if(isset($result['album']['release_date'])){
			return $result['album']['release_date'];
		}else{
			return '';
		}

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

		return isset($result['album']['name'])?$result['album']['name']:'';
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
		<style type="text/css">
		.track_item{
			width: 30%;
		    float: left;
		    margin: 30px 1.5%;
		}

		.track_item img{
			max-width: 100%;
			height: auto !important;
		}

		.artistOption,.albumOption,.yearOption{
			text-transform: capitalize;
		}

		#artistFilter,#albumFilter,#yearFilter{
			text-transform: capitalize;
		}
		.filtersTitle{
			color:#fff;
		}
		#noResult{
			color: #fff;
			display: none;
		}
		.filters{
			color: #fff;
		}
		</style>
		<meta charset="UTF-8">
	</head>

	<body>
		<!--<div class="topbar">
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
	-->
		<?php
			include("../includes/topbar.php");
			?>

		<div class="loginBox" id="loginBox">
			<p>Username:</p>
		</div>

		<div class="registerBox" id="registerBox">
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

				$my_id = $track['id'];
	

				?>
				<div class="track_item" data-track_album = "<?php echo $track_info['album']; ?>" data-track_artists="
				<?php echo $track_info['artists']; ?>" data-track_year="<?php echo $track_info['release_date']; ?>">
					<a href="Tracks/<?php echo $track['id']; ?>.php">
						<img src="<?php echo $track['image']; ?>" alt = "<?php echo $track['title']; ?>" width="500">
						</a>
						<div class="downloadForm" >
							<form class="form-inline" method="post" action=<?php echo "scripts/generate_pdf.php?id=".$my_id; ?> > <!-- .$row['my_id']; -->
								<button type="submit" id="pdf" name="generate_pdf" class="btn-btn-primary"><i class="fa fa-pdf" aria-hidden="true"></i>
								Generate PDF</button>
							</form>
		 				</div>
				</div>
				<?php 
 			}?>

 			<p id="noResult">No result</p>
<!-- 			<br style="clear: both">
			<button>View All</button> -->
		</div>

<!-- 		<div class="featured">
			<p>test</p>
		</div> -->

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
		}

	</script>

	</body>
</html>