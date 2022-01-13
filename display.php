<?php
// Including the config.php file while execution of this PHP file.
include("config.php");

// Including the insert.php file while execution of this PHP file.
// Note: This file would be needed to be included only once (initially) as later on it would just duplicate just the values whenever this file is been executed.
// include("insert.php");
?>

<!-- Defining standard Doctype template needed for an HTML file -->
<!DOCTYPE html>
<html lang="en">

<!-- Defining Head for the html which includes the meta details needed to been provided to the browser for better efficiency of the page -->
<head>
  <!-- The below 3 meta tags always must come first in the head and any other head content must come after these tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Providing a Title to the webpage -->
  <title>Parallel Word Search</title>

  <!-- Bootstrap Linking -->
  <link href="bootstrap.min.css" rel="stylesheet">

  <!-- Internal CSS for the page -->
  <style type="text/css">
    /* body tag */
    body {
      background-color: #383838;
      color: white;
      font-family: sans-serif;
    }

    /* Table and its header,rows and columns  */
    table,
    th,
    td,
    tr {
      border-color: white;
      background-color: black;
      color: white;
    }

    /* Navbar tag */
    .navbar {
      background-color: black;
    }

    /* Navbar Brand name */
    .navbar-brand {
      font-size: 1.8em;
    }

    /* Navbar text */
    .nav-text {
      color: green;
    }

    /* Top Container Properties */
    #topContainer {
      height: 400px;
      width: 100%;
      background-size: cover;
    }

    /* Top Row Properties */
    #topRow {
      margin-top: 100px;
      text-align: center;
    }

    /* Colour for Lead tag */
    .lead {
      color: white;
    }

    /* Top Row H1 Properties */
    #topRow h1 {
      font-size: 300%;
    }

    /* Bold Properties */
    .bold {
      font-weight: bold;
    }

    /* Button tag Properties */
    .btn {
      background-color: white;
      color: black;
    }

    /* Margin top tag Properties */
    .marginTop {
      margin-top: 30px;
    }

    /* Center Properties */
    .center {
      text-align: center;
    }

    /* Title tag Properties */
    .title {
      margin-top: 100px;
      font-size: 300%;
    }

    /* Footer Properties */
    #footer {
      background-color: white;
      padding-top: 70px;
      width: 100%;
    }

    /* Bottom Margin Properties */
    .marginBottom {
      margin-bottom: 30px;
    }

    /* Image Properties */
    .appstoreImage {
      width: 250px;
    }
  </style>

  <!-- Concluding the head for the page -->
</head>

<!-- Defining Body for the page -->
<body>
  <!-- Creating a Navigation Bar for the Webpage -->
  <div class="navbar navbar-default navbar-fixed-top">

    <!-- Using a Container from Bootstrap -->
    <div class="container">

      <!-- Defining Header for the Navbar, in case of Mobile port view-->
      <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Defining Navigation Bar Text -->
        <a class="navbar-brand nav-text">ParallelSearch</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="nav-text"><a href="#topContainer">Home</a></li>
          <li class="nav-text"><a href="#result">Results</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Defining a Container class to have the contents for searching Word -->
  <div class="container contentContainer" id="topContainer">

    <!-- Creating a row in this container  -->
    <div class="row">

      <!-- Creating an item with col-md-6 -->
      <div class="col-md-6 col-md-offset-3" id="topRow">

        <!-- Guiding/branding content for the website  -->
        <h1 class="marginTop lead">Parallel Word Search</h1>
        <p class="lead">Search for information across articles parallelly.</p>
        <p class="bold marginTop lead">Interested? Check it out!</p>

        <!-- Creating a form to get the Word Search Input field -->
        <form class="marginTop" action="display.php" method="GET">
          <div class="input-group">
            <span class="input-group-addon">></span>
            <input type="text" placeholder="Enter search query..." class="form-control" name="query" />
          </div>

          <!-- Creating a submit button to send the word to be searched to display.php -->
          <input type="submit" class="btn btn-lg marginTop" value="Search">
        </form>
      </div>
    </div>
  </div>

  <!-- Creating a Container for displaying the Results Header -->
  <div class="container contentContainer" id="result">
    <div class="row" class="center">
      <h1 class="center title">Search Results</h1>
    </div>

    <!-- PHP Script to make a query to the MYSQL query to get the count of word in each Article -->
    <?php
    // Creating a query variable to make a GET query to the database
    $query = $_GET['query'];

    // Creating a raw_results variable to make a query to check if the word exists in the database
    $raw_results = mysqli_query($con, "SELECT * FROM list WHERE string = '$query' LIMIT 1");

    // If it does not exist then display No results found
    if(mysqli_num_rows($raw_results)==0)
        echo "<br><br>No Results Found";

    // Else, get document wise word count
    else
    {
        // Storing values of word in a,b,c,d,e for each of the five document.
        while($row=mysqli_fetch_array($raw_results)){
            $a = $row['1'];
            $b = $row['2'];
            $c = $row['3'];
            $d = $row['4'];
            $e = $row['5'];

            // Storing each value found in arr2 with their respective article name
            $arr2=array();
            $arr = array("Article 1"=>$a,"Article 2"=>$b,"Article 3"=>$c,"Article 4"=>$d,"Article 5"=>$e);
            arsort($arr);
            foreach (array_slice($arr,0,5) as $key =>$value) {
              array_push($arr2, $key);
              array_push($arr2,$value);
            }
    ?>

    <!-- Creating a Container for displaying the results -->
    <div class="container">
      <br><br><br>

      <!-- Creating a table to show the results in a well designed manner -->
      <table class="table">
        <thead>

          <!-- Defining the header for the table -->
          <tr>
            <th>Rank</th>
            <th>Document</th>
            <th>Frequency</th>
          </tr>
        </thead>

        <!-- Showing the contents of the arr2 array which are values of the word count in each document. -->
        <tbody>
          <tr>
            <td>1</td>
            <!-- Article 1 -->
            <td><?php echo $arr2[0];?></td>

            <!-- Count of the searched word in Article 1 -->
            <td><?php echo $arr2[1];?></td>
          </tr>
          <tr>
            <td>2</td>
            <!-- Article 2 -->
            <td><?php echo $arr2[2];?></td>

            <!-- Count of the searched word in Article 2 -->
            <td><?php echo $arr2[3];?></td>
          </tr>
          <tr>
            <td>3</td>
            <!-- Article 3 -->
            <td><?php echo $arr2[4];?></td>

            <!-- Count of the searched word in Article 3 -->
            <td><?php echo $arr2[5];?></td>
          </tr>
          <tr>
            <td>4</td>
            <!-- Article 4 -->
            <td><?php echo $arr2[6];?></td>

            <!-- Count of the searched word in Article 4 -->
            <td><?php echo $arr2[7];?></td>
          </tr>
          <tr>
            <td>5</td>
            <!-- Article 5 -->
            <td><?php echo $arr2[8];?></td>

            <!-- Count of the searched word in Article 5 -->
            <td><?php echo $arr2[9];?></td>
          </tr>
        </tbody>

        <!-- Closing the table -->
      </table>
    </div>

    <!-- Closing the else and while loops from the PHP script earlier -->
    <?php
    }
  }
?>
  </div>
  </div>

  <!-- jQuery Linking-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <!-- Including JavaScript for this page -->
  <script type="text/javascript">
    $(".contentContainer").css("min-height", $(window).height());
  </script>

<!-- Closing the body tag -->
</body>

<!-- Closing the HTML document -->
</html>
