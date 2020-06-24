<?php 

session_start();

define('DB_SERVER', 'localhost');
   		define('DB_USERNAME', 'root');
  		define('DB_PASSWORD', '');
   		define('DB_DATABASE', 'mum');

$page_title = 'Search';

if (isset($_GET['search_query']))
	{
  		$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  		if ($con)
  		{    
    		$SQL = $con->prepare('SELECT * FROM songs WHERE lower(trim(title)) LIKE "%'.strtolower(trim($_GET['search_query'])).'%"');
    		$SQL->execute();
    		$results = $SQL->get_result();
    		print "found";
    	}
    }

require('../includes/top.php');

?>

<link rel="stylesheet" type="text/css" href="../Content/css/index.css">

<?php  include('../includes/topbar.php'); ?>

<div class="firstPageTitle">
	<h2>Search Results:&ensp;</h2>
</div>

<?php 

if ($results->num_rows > 0) {
  while($row = $results->fetch_assoc()) { ?>
  	<a href="../Tracks/<?php echo $row['id']; ?>.php">
	<div class="box" title="<?php echo $row['title'] . ' - ' . $row['artist']; ?>">
		<img src="<?php echo $row['image'] ?>" alt = "<?php echo $row['title'] ?>" width="150" height = "170"/>
	</div>
	</a>
	
<?php 
 }
} 
else { ?>
<p>No result</p>
<?php
} 
?>

<?php require('../includes/bottom.php'); ?>