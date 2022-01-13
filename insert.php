<?php 

//Statement to include the config.php file while running this file.
 include('config.php'); 

//Creating a variable to store the word "Lakhs" from the document dictionary
  $var="Lakhs";  

//SQL command to insert the count of the word "Lakhs" into the Article1 file from which it was found
 $query = "INSERT INTO `list`(`string`,`1`,`2`,`3`,`4`,`5`)VALUES ('".$var."',1,0,0,0,0);";  

//Executing the query with mysqli_query() and providing the connection variable from config.php
 mysqli_query($con,$query); 

//The C++ file generates similar commands for all the words parsed from the article files and then makes SQL queries to store them in the database.
?>