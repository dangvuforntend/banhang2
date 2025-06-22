<?php 
$sever="localhost";
$username="root";
$pass="";
$database="test";
$conn=mysqli_connect($sever,$username,$pass,$database);
mysqli_query($conn, "SET NAMES 'utf8'");

?>