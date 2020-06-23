<?php session_start();
 if($_SESSION['adminLog']==false || !isset($_SESSION['adminLog'])){
     header("Location: index.php");
 }

   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'mum');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   $sql="SELECT * from users";
   $res = $db->query($sql);


   if(isset($_POST['delApp'])){
       $idB=$_POST['delApp'];
   $sqlBlock="DELETE from users where user_id='$idB'";

   if($db->query($sqlBlock)){
   $sql2="SELECT * from users";
   $res->free();

   $res = $db->query($sql2);
   }
    

    }
 
 ?>


 <!DOCTYPE html>
     
     <html>

     <style >

     	body {
	background-image: linear-gradient(to left, #333333, #111111);

}

     	.sectionAdministrator{
    min-height: 550px;
	width:90%;
	 margin:0 auto;
	 margin-top: 50px;
	margin-bottom: 100px;
	float:center;
}

.centerAdministrator{
    width:100%;
	float:left;
	color:#fff;
	border-radius: 8px;
	background: #111b2b;
	padding-bottom: 80px;
	min-height: 650px;
}

.secTitle{
    width: 100%;
	text-align: center;
	font-size: 30px;
	margin-bottom: 100px;
	margin-top:50px;
}

.buttonDelete2{
    background: #FF0000;
	cursor:pointer;
	border: 1px #fff;
	border-radius: 3px;
	font-size: 14px;
	box-sizing: border-box;
	font-family:Gadugi;
	padding-top:5px;
	padding-bottom:5px;
	padding-left:7px;
	padding-right:7px;
	letter-spacing:0.5px;
	color: #fff;
	margin: 0 auto;
}

table {
    font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 90%;
	margin: 0 auto;
	margin-top: -2.7%;
}

td, th {
	border: 1px solid #dddddd;
	text-align: center;
	padding: 8px;
}

table#t01 tr:nth-child(odd) {
	background-color: #white;
}

table#t01 tr:nth-child(even) {
	background-color: #ccc;
	color:black;
}

table#t01 th {
	background-color: black;
	color: white;
}

td#op{
	background-color: black;
}

.menuTitle{
	float: left;
	margin: 0px;
	margin-top: 0px;
	color: #fff;
	font-size: 22px;
	margin-right: 15px;
	margin-left: 10px;
}

.topnav {
	overflow: hidden;
	background: #111b2b;
	height: 46px;
}

.topnav a {
	float: left;
	display: block;
	color: #fff;
	font-family:Gadugi;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
	font-size: 16px;
}
.topnav a:hover {
	transition-duration: 0.5s;
	color: #4699f2;
}
.topnav a.active {
	background-color: #2196F3;
	color: white;
}
     	


     </style>
     
	 <head>
     
	 <meta charset="utf-8"/>
	 
	 <!--
	 <title>Online Software Repository</title>
     
	 <link rel="stylesheet" type="text/css" href="../css/style.css"/> 
	 
	 <link rel='icon' href="../img/fav.png">
     -->
	 </head>
     
	 <body>


<!-- Bara de navigare -->
			 <nav>
			   <div class="topnav">

			   	<p class="menuTitle"><img src="../Content/Logo/Logo.png" width="150px" height="40px" style="margin-bottom: -6px;">  </p>

		  <a href="logout.php" style="border-radius:5px;padding-top: 4px;height:13px;float: right;margin-right: 30px;margin-top: 7px;background: #e8353b;"><img src="../Content/images/Icons/logout.png" width="25px" height="22px" style="margin-bottom: -5px;"> Log out</a>
		
		</div> 
			 </nav>
 	<!-- Sfarsit bara de navigare -->

	 <section class="sectionAdministrator">
	 	<div class="centerAdministrator">
	 		<div class="secTitle">
	 			<h2>Apps</h2>
	 		</div>

			<table id="t01">
					  <tr>
               
			  	<th>ID</th>
			  	<th>User</th>
			    <th>First Name</th>
			    <th>Last Name</th>
			    <th>Email</th>
			  </tr>

        <?php  while($row = $res->fetch_assoc()) {  ?>

			  <tr >
			    
			    <td><?php echo $row['user_id']; ?></td>
			    <td><?php echo $row['username'];  ?></td>
			    <td><?php echo $row['firstname']; ?></td>
			    <td><?php echo $row['lastname']; ?></td>
			    <td><?php echo $row['email']; ?></td>

			    <td id="op" style="width: 180px">
                   
                   <form method="post">
                	 <button class="buttonDelete2" type="submit"  name="delApp" value=<?php echo $row['user_id'] ; ?> >Delete</button>
                   </form>


                </td>

            

			  </tr>

           <?php
            }
           ?>
			</table>
	
	
	 	</div>
	</section>
	

	
     </body>

     </html>