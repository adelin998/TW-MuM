<?php
$ok=5;
if(isset($_POST['regSub'])){

   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'mum');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   $username=trim($_POST['username']);
   $nume=trim($_POST['nume']);
   $prenume=trim($_POST['prenume']);
   $email=$_POST['email'];
   $pass=trim(md5($_POST['pass']));
   $cpass=trim(md5($_POST['cpass']));


  if($pass != $cpass){
      $ok=2;}
  else {
     $select="SELECT * from users where username='$username'";
    $result = mysqli_query($db,$select);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if($count>0){
      $ok=3;}
    else {
      $sql = "INSERT INTO users (username,firstname,lastname,password,image,email)
      VALUES ('$username','$nume','$prenume','$pass','user1.png','$email')";

      if ($db->query($sql) === TRUE) {
          $ok=1;}
      else $ok=0;
      }
  }
  $db->close();
}

if($ok==1){
  header("Location: login.php");
}
   
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <link rel="stylesheet" href="register_style.css">
  <title>Beatdeck</title>

</head>

<body>
	<div class="topbar">

    <a class="logo_link" href="index.php">
      <img src="../Content/Logo/Logo.png" class="logo" alt="Logo" width="140" height="40">
    </a>

			<div class="searchbox">
				<input type="text" placeholder="Search..." style="font-family:'Montserrat'; font-weight:normal;font-size:20px">
				<img src="../Content/Images/Icons/Search.png" class="search_icon" alt="Logo-search" width="25" height="25">
			</div>
	</div>


  <div>
  	<form name="userRegistration" class="regBox" method="post" >
      <h1 style="font-family:'Montserrat'; font-weight:normal;font-size:30px">Register</h1>

          <input type="text" id="username" placeholder="Nume Utilizator" name="username" title="Doar caractere alfanumerice ! Minim 5." pattern="[a-zA-Z0-9]{5,}" required><br>
            <input type="text" id="nume" name="nume" placeholder="Numele Dvs." title="Numele trebuie sa contina doar litere! Minim 3." pattern="[a-zA-Z]{3,}" required><br>
            <input type="text" id="prenume" name="prenume" placeholder="Prenumele Dvs." title="Preumele trebuie sa contina doar litere! Minim 3." pattern="[a-zA-Z]{3,}" required><br>
            <input type="text" id="email" name="email" placeholder="E-mail" 
             pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br>
            <input type="password" id="pass" name="pass" placeholder="Parola" title="Minim 5 caractere de tipul A-Z,a-z,0-9" pattern="[a-zA-Z0-9]{5,}" required><br>
            <input type="password" id="cpass" name="cpass" placeholder="Repeta Parola" title="Introduceti aceeasi parola ca mai sus." pattern="[a-zA-Z0-9]{5,}" required><br>

        <span id='message'></span>

      <input type="submit" name="regSub" value="Register">

         <div class="result"> 
                        <?php if($ok==0){
                         echo "Eroare sql!";
                        } 
                        else
                          if ($ok==2) {
                            echo "Confirmare parola gresita!";
                          }
                          else
                            if ($ok==3) {
                              echo "Acest cont exista deja in baza de date!";
                            }
                      ?>
         </div>

      <div>
        <h1 style="font-family:'Arial'; font-weight:normal;font-size:20px">Already have an account?</h1>
        <a href="login.php" style="font-family:'Nugget Medium';font-weight:normal;font-size:20px; color: #ffffff; text-decoration: none;">Log in.</a>
      </div>
	 </form>

  </div>

  <script>

  var check = function() {
  if (document.getElementById('pass').value ==
    document.getElementById('cpass').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'The passwords don\'t match.';
  }
}

</script>

	</body>
</html>

