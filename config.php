<?php
//This turns on the output buffering in php
ob_start();

// A PHP Session is been intinalized and started 
session_start();

// Setting time zone to "GMT +5:30"
$timezone = date_default_timezone_set("Asia/Kolkata");

//Creating a connection variable "con" with msqli_connect()
$con = mysqli_connect("localhost","root","","pagerank");

// If any errors while establishing a connecting displaying them
if(mysqli_connect_errno()) 
echo "Failed to connect ".mysqli_connect_errno();
?>
