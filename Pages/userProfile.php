<?php

session_start();

$page_title = 'Profile';

require('../includes/top.php');

 if(!isset($_SESSION['id_user'])){
 	header('Location: login.php');
 }else{
	 $user_id = $_SESSION['id_user'];
 }

$user_id = 1;//presupunem ca s logat 


/* modificare informatii user */
if(isset($_POST['changeInfo'])){

	$image_sql = '';
	if(isset($_FILES["image"]) && $_FILES["image"]['size'] != 0){
		$image = $_FILES["image"];
		if(uploadImage($image)){
			$image_sql = ', image="'.$image['name'].'"';
		}
	}

	$sql = 'UPDATE users set username="'.$_POST['username'].'", firstname="'.$_POST['firstname'].'",
	 lastname="'.$_POST['lastname'].'",  email="'.$_POST['email'].'"
	'.$image_sql.' where user_id = "'.$user_id.'"';

	if(!query($sql)){
		echo "Error";
		die();
	}
}

/* end modificare informatii user */


/* afisare informatii user */
$query = query('SELECT * from users where user_id = "'.$user_id.'"');

$user = $query->fetch_assoc();

if(file_exists(USERS_IMAGES.$user['image'])){
	$image = USERS_IMAGES.$user['image'];
}else{
	$image = '..\Content\Images\Users\default.png';//imagine default, asta trebuie sa o schimbi
	// $image = 'Content\Images\Icons\profile.png';
}
/* end afisare informatii user */

?>

<link rel="stylesheet" type="text/css" href="../Content/CSS/index.css">
<link rel="stylesheet" type="text/css" href="../Content/CSS/userProfile.css">

<?php  include('../includes/topbar.php'); ?>
<!-- <?php  include('includes/sidebar.php'); ?> -->

<div class="userBox">
	<form method="post" enctype="multipart/form-data">

		<div class="imgUser">
			<img src="<?php echo $image; ?>" style="border-radius: 50%;" width="80%"><br>
			<input type="file"  name="image">
		</div>

		<div class="contentUser">
			Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required/><br/>
			Firstname: <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" required/><br/>
			Lastname: <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required/><br/>
			E-mail: <input type="email" name="email" value="<?php echo $user['email']; ?>" required/><br/>
			<input type="submit" class="btnModifica" name="changeInfo" value="Modifica"></button>		
		</div>

	</form>
</div>

<?php require('../includes/bottom.php'); ?>

<?php

function uploadImage($image){

	$target_file = USERS_IMAGES . basename($image["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	$check = getimagesize($image["tmp_name"]);
	if($check !== false) {
		// echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($target_file)) {
	  echo "Sorry, file already exists.";
	  $uploadOk = 0;
	}

	// Check file size
	if ($image["size"] > 500000) {
	  echo "Sorry, your file is too large.";
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	  $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	  echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($image["tmp_name"], $target_file)) {
	    // echo "The file ". basename( $image["name"]). " has been uploaded.";
	    return true;
	  } else {
	    echo "Sorry, there was an error uploading your file.";
	  }
	}
	return false;
}

 ?>
