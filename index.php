<?php
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php";

// check if user is logged in and set binary value to check login
if ( ! isset($_SESSION['user_id']) ) {
    $_SESSION['success'] = "You are logged out";
    $login = 0;
} else {
    $login = 1;
}


?>
<!DOCTYPE html>
<html>
<head>

    <!-- home page for autocrud assignment by dr. chuck at wa4e.com -->
    <title>Company Contact Manager</title>

    <?php require_once "bootstrap.php"; ?>


</head>
<body>

<?php require_once "navbar.php"; ?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="text-info">Company Contact Manager</h1>
    <p>fundamentals of software engineering for business</p>
  </div>
</div>

    <div class="container">



        <?php
        flashMessages();
        greeting();
        ?>

        <h3 class="text-info">Company List</h3>

         <table class="table table-hover">

        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>City</th>
          <th>State</th>
          <th>Zip</th>

          <th>Action</th>
        </tr>

          <?php

          $stmt = $pdo->query("SELECT * FROM company");
          while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['name']));
            echo("</td><td>");
            echo(htmlentities($row['address']));
            echo("</td><td>");
            echo(htmlentities($row['city']));
            echo("</td><td>");
            echo(htmlentities($row['state']));
            echo("</td><td>");
            echo(htmlentities($row['zip']));
            echo("</td><td>");


            echo('<div class="btn-group btn-group-sm">');
                echo('<a href="view.php?company_id='.$row['company_id'].'" class="btn btn-outline-info" role="button">View</a>');
                echo('<a href="edit.php?company_id='.$row['company_id'].'" class="btn btn-outline-warning" role="button">Edit</a>');
              echo('<a href="delete.php?company_id='.$row['company_id'].'" class="btn btn-outline-danger" role="button">Delete</a>');
            echo('</div>');

            echo("</td></tr>\n");
          }
          ?>
        </table>

    </div>

</body>
</html>
