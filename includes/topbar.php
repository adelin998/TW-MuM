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

	<style type="text/css">

		.searchbox
		{
			position: relative;
		}

		.autosuggest
		{
			display: none;

			position: absolute;
			top: 50px;
			left: 38px;
			background: #b4f5ff;
			min-width: 305px;
			border: 1px solid;
			border-radius: 10px;
			max-width: 400px;
			padding: 6px;
			box-sizing: border-box;
		}

		.autoCompleteResult
		{
			cursor: pointer;

		}

		.autoCompleteResult:hover
		{
			background: #fff;
		}

	</style>


	<div class="topbar">
			<div class="menu">
					<img src="..\Content\Images\Icons\MenuIcon.png">
			</div>

			<a href="..\Pages\index.php">
				<img class="logo" src="..\Content/Logo/Logo.png">
			</a>

			<div class="searchbox">
				<form  id="search_form" action="<?php echo '../Pages/search.php';?>" method="get">
					<input autocomplete="off" id="site_search" type="text" name="search_query" placeholder="Search..." onkeyup="autoComplete(this.value)">
					<img src="..\Content\Images\Icons\Search.png">
				</form>

				<div class="autosuggest">
					
				</div>

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

		<script type="text/javascript">
			var autoCompleteDiv = document.getElementsByClassName('autosuggest')[0];

			function autoComplete(keyword)
			{
				autoCompleteDiv.innerHTML = "";

				if(keyword == "")
				{
					autoCompleteDiv.style.display = "none";
					return;
				}

				var xhttp = new XMLHttpRequest();

  				xhttp.onreadystatechange = function() 
  				{
    				if (this.readyState == 4 && this.status == 200) 
    				{

    			 		let data = JSON.parse(this.responseText);

    			 		for(let i = 0; i < data['results'].length; i++)
    			 		{
    			 			autoCompleteDiv.innerHTML += `<p class="autoCompleteResult">${data['results'][i]}</p>`;
    			 		}

    			 		if(data['results'].length > 0)
    			 			autoCompleteDiv.style.display = "block";
    			 		else
    			 			autoCompleteDiv.style.display = "none";

    			 		let autoCompleteResults = document.getElementsByClassName('autoCompleteResult');

    			 		for(let i = 0; i < autoCompleteResults.length; i++)
    			 		{
    			 			autoCompleteResults[i].addEventListener('click', function ()
    			 			{ 
    			 				document.getElementById('site_search').value = autoCompleteResults[i].innerHTML;
    			 				document.getElementById('search_form').submit();
    			 			});
    			 		}
    				}
  				};

  				xhttp.open("GET", "http://localhost:8080/proiect/ajaxAutocomplete.php?keyword="+keyword, true);
  				xhttp.send();
			}

			document.addEventListener("click", (evt) => {
    		const autosuggestDiv = document.getElementsByClassName("autosuggest")[0];
    		let targetElement = evt.target; 

    		do
    		{
        		if (targetElement == autosuggestDiv)
        		{
            	return;
        		}

       		 	targetElement = targetElement.parentNode;
   			} while (targetElement);

    		autosuggestDiv.style.display = "none";
    		autosuggestDiv.innerHTML = "";
			});


		</script>