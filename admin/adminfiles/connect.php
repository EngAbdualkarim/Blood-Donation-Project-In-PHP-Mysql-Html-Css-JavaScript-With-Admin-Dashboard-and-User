<?php

$hostname = "localhost:3307";  
$username = "root";  
$password = ""; 
$database = "blood_donation";  

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>