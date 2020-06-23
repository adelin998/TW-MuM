<?php

//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "mum";

// Create connection
#$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
//if ($conn->connect_error) {
//  die("Connection to database failed: " . $conn->connect_error);
//}


function query($query){

	$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mum";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
  die("Connection to database failed: " . $conn->connect_error);
}

	#global $conn;
	$result = $conn->query($query);
	$conn->close();
	return $result;
}
