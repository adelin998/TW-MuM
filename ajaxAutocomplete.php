<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'mum');

if (isset($_GET['keyword']))
	{
  		$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  		if ($con)
  		{    
    		$SQL = $con->prepare('SELECT title FROM songs WHERE lower(trim(title)) LIKE "%'.strtolower(trim($_GET['keyword'])).'%"');
    		$SQL->execute();
    		$results = $SQL->get_result();
    	}

    	$output = array();

    	if ($results->num_rows > 0)
    	{
  			while($row = $results->fetch_assoc())
  			{ 
  				array_push($output, $row['title']);
  			} 
  		}

  		echo json_encode(array("results" => $output));
    }
