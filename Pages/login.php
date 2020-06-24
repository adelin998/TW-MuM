<?php
session_start();
$ok=-1;
// if( isset($_SESSION['logged']) && $_SESSION['logged']==true){
   //   header('Location: index.php');
  //  } 
   // else 
      if(isset($_POST['logSub'])){

   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'mum');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   $myusername = trim(mysqli_real_escape_string($db,$_POST['username']));
   $mypassword = md5(mysqli_real_escape_string($db,$_POST['password'])); 

   $sql = "SELECT * FROM users WHERE username = '$myusername' and password= '$mypassword'";
   $result = mysqli_query($db,$sql);
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   $count = mysqli_num_rows($result);
   $result->free();

   if($count == 1) {
         $res=mysqli_query($db,$sql);
         $id=$res->fetch_assoc();
         $_SESSION['logged']=true;
         $_SESSION['login_user'] = $myusername;
         $_SESSION['id_user']=(int)($id['user_id']);
         $ok=1;
         header('Location: userProfile.php');
     }else{
      $ok=0;
     }
     

   $db->close();
 }

?>

<html>
<head>
<style>

@font-face {
font-family: 'Nugget Medium';
font-style: normal;
font-weight: normal;
src: local('Nugget Medium'), url('NuggetMed.woff') format('woff');
}

body {
	font-family: myFirstFont;
	width: 90%;
	padding-top: 50px;
	padding-left: 200px;
	margin-left: auto;
	margin-right: auto;
	margin-top: 40px;
	min-height: 500px;
	background-image: linear-gradient(to left, #333333, #111111);
	overflow-x: hidden;

}

h2 {
	color: #ffffff;
}

div.box {
	background-color: lightgrey;
	width: 205px;
	height: 205px;
	border-radius: 10px;
	float: left;
	margin-left: 1%;
	margin-right: 1%;
	margin-bottom: 50px;
}

div.box img {
	 width: 100%;
  	 height: 100%;
  	 border-radius: 10px;
}

div.box:hover img {
  opacity: 0.2;
}

.sidebar {
	height: 100%;
	width: 160px;
	position: fixed;
	z-index: 1;
	top: 0;
	left: 0;
	background-color: linear-gradient(#111111, #333333);
	padding-top: 5px;
}

.sidebar-menu {
  padding-top: 45px;
  padding-left: 15px;
  text-decoration: none;
  font-size: 25px;
  color: #ffffff;
  display: block;

  opacity: 0.5;
  -webkit-transition: opacity 0.3s ease-in-out;
  -moz-transition: opacity 0.3s ease-in-out;
  transition: opacity 0.3s ease-in-out;
}

.sidebar img {
	padding-left: 20px;
}

.sidebar a:hover {

	opacity: 1.0;
	-webkit-transition: opacity 0.3s ease-in-out;
	-moz-transition: opacity 0.3s ease-in-out;
    transition: opacity 0.3s ease-in-out;
}

.bottom {
	position: absolute;
	bottom: 20px;
	font-size: 15px;
    color: #818181;
    margin-left: 15px;
}

.topbar {
	height: 70px;
	width:100%;
	position:fixed;
	z-index: 1;
	top: 0;
	left: 0;
	background-color: transparent;
	overflow: hidden;
}

.topbar a {
  float: left;
  padding: 10px;
  text-decoration: none;
  font-size: 25px;
}

.topbar a:hover {
  color: #f1f1f1;
}

.topbar-right {
	float: right;
	padding-top: 5px;
	margin-right: 10px;
}

.topbar p {
	float: left;
  font-size: 25px;
  color: #ffffff;
}

.topbar input[type=text] {
  width: 300px;
  float: left;
  margin-left: 200px;
  padding: 6px;
  border: none;
  margin-top: 16px;
  font-size: 17px;
  border-radius: 5px;
}

.nowplaying {
	float: left;
  margin-left: 250px;
  padding: 6px;
  border: none;
  margin-top: 16px;
  font-size: 17px;
  border-radius: 5px;
}

@media screen and (max-width: 600px) {
  .topnav a, .topnav input[type=text] {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;
  }
}

.main {
  margin-left: 160px;
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}

.logo {
	padding: 10px;
	margin-left: -8px;

	opacity: 1;
	-webkit-transition: opacity 0.5s ease-in-out;
	-moz-transition: opacity 0.5s ease-in-out;
    transition: opacity 0.5s ease-in-out;
}

.logo:hover {
	opacity: 0.5;
	-webkit-transition: opacity 0.5s ease-in-out;
	-moz-transition: opacity 0.5s ease-in-out;
    transition: opacity 0.5s ease-in-out;
}

.logo_link {
	display: inline-block;
	position: relative;
	z-index: 1;
	padding: 5px;
	margin: -5px;
}

.search_icon {
	padding-top: 20px;
	margin-left: -35px;
}

.login_register {
	color: #ffffff;
}

.loginBox{
  width: 600px;
  height: 450px;
  padding: 40px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  background: #191919;
  text-align: center;
  border-radius: 20px;
}
.loginBox h1{
  color: white;
  text-transform: uppercase;
  font-size: 40px;
  font-weight: 300;
}
.loginBox input[type = "text"],.loginBox input[type = "password"]{
  background: none;
  display: block;
  margin: 30px auto;
  text-align: center;
  font-size: 20px;
  border: 3px solid #3498db;
  padding: 12px 10px;
  width: 200px;
  outline: none;
  color: white;
  border-radius: 24px;
  transition: 0.25s;
}
.loginBox input[type = "text"]:focus{
  width: 320px;
  border-color: white;
}

.loginBox input[type = "password"]:focus{
  width: 320px;
  border-color: white;
}

.loginBox input[type = "submit"]{
  background: none;
  display: block;
  margin: 40px auto;
  text-align: center;
  font-size: 20px;
  border: 3px solid #3498db;
  padding: 9px 40px;
  color: white;
  border-radius: 24px;
  transition: 0.25s;
  cursor: pointer;
}
.loginBox input[type = "submit"]:hover{
  background: #3498db;
}

.result{
  width:100%;
  height: 30px;
  color:red;
  text-align: center;
}

</style>

</head>

<body>
	<div class="topbar">
  <a class="logo_link" href="index.php">
      <img src="..\Content\Logo\Logo.png" class="logo" alt="Logo" width="140" height="40">
    </a>
			<div class="searchbox">
				<input type="text" placeholder="Search..." style="font-family:'Montserrat'; font-weight:normal;font-size:20px">
				<img src="..\Content\Images\Icons\Search.png" class="search_icon" width="25" height="25">
			</div>

			<div class="nowplaying">
				<p style="font-family:'Nugget Medium';font-weight:normal;font-size:23px">No music is currently playing.</p>
			</div>

	</div>


	<form class="loginBox" method="post" >
  <h1 style="font-family:'Montserrat'; font-weight:normal;font-size:30px">Login</h1>
  <input type="text" name="username" placeholder="Username" >
  <input type="password" name="password" placeholder="Password">
  <input type="submit" name="logSub" value="Login">

   <div class="result"> 
                        <?php 
                          if($ok==0){
                            echo "Date incorecte!";}
                      ?>
         </div>

  <div>
    <h1 style="font-family:'Arial'; font-weight:normal;font-size:20px">Don't have an account?</h1>
    <a href="register.php" style="font-family:'Nugget Medium';font-weight:normal;font-size:20px; color: #ffffff; text-decoration: none;">Sign up.</a>
  </div>
	</form>

	</body>
  </html>