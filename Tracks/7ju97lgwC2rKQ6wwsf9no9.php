<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../Content/CSS/index.css">
	</head>

	<body>
		<div class="topbar">
			<div class="menu">
					<img src="../Content\Images\Icons\MenuIcon.png">
			</div>

			<a href="../index.php">
				<img class="logo" src="../Content/Logo/Logo.png">
			</a>

			<div class="searchbox">
					<input type="text" placeholder="Search...">
					<img src="../Content\Images\Icons\Search.png">
			</div>

			<div class="auth">
				<button onclick="toggleLoginBox()">Login</button>
				<img src="../Content\Images\Icons\Separator.png">
				<button onclick="myFunction()">Register</button>
			</div>
		</div>

		<div class="metadata">
			<img src="../Content/Images/Albums/7ju97lgwC2rKQ6wwsf9no9.jpg">
			<p>Title: Rain On Me (with Ariana Grande)</p>
			<p>Artist(s): Lady Gaga Ariana Grande </p>
			<p>Album: Chromatica (Track number on album: 4 |  Disc Number: 1)</p>
			<p>Release Date: 2020-05-29</p>
			<p id="demo"></p>
			<button onclick="exportPDF()">Export data as PDF</button>
		</div>

		<div class="comments">
			<h1>Comments</h1>

		<script>
		function toggleLoginBox()
		{
			var show = document.getElementById("loginBox");

			if( show.style.display === "none" )
			{
				show.style.display = "block";
			}
			else
			{
				show.style.display = "none";
			}
		}

		function exportPDF()
		{
			`<?php
				echo "<h2>PHP is Fun!</h2>";

				require('fpdf.php');

				$pdf = new FPDF();
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',16);
				$pdf->Cell(40,10,'Hello World!');
				$pdf->Output("I", "7ju97lgwC2rKQ6wwsf9no9");
			?>`
		}
	</script>

	</body>
</html>