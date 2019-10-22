<?php
$hostname="awssprbotcom.csigzgfx7gdl.us-east-1.rds.amazonaws.com";
$username = "awssprbotcom";
$password = "Bd92U5LCg9L4";
$dbname = "sprbqktz_ptheme";
 
//Connect to the database
$connection =mysqli_connect($hostname, $username, $password, $dbname);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error($connection));
}
?>