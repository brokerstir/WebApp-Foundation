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

    <style>
    table, tr, th, td {
       border: 1px solid black;
    }
    </style>

</head>
<body>

    <div class="container">

        <h1>Company Contact Manager</h1>

        <?php
        flashMessages();
        greeting();
        ?>


        <?php if ($login == 0) { ?>

          <p>
            <a href="login.php">Please Log In</a>
          </p>

          <!-- admin / secret123 -->

          <p>
            <a href="add.php">Add New Company</a>
          </p>

        <?php } else { ?>

          <p>
            <a href="add.php">Add New Company</a>
          </p>

          <p>
            <a href="order.php">Add New Order</a>
          </p>

          <p>
            <a href="logout.php">Log Out</a>
          </p>

        <?php } ?>

        <h3>Company List</h3>

        <table>

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
            echo('<a href="view.php?company_id='.$row['company_id'].'">View</a> / ');
            echo('<a href="edit.php?company_id='.$row['company_id'].'">Edit</a> / ');
            echo('<a href="delete.php?company_id='.$row['company_id'].'">Delete</a>');
            echo("</td></tr>\n");
          }
          ?>
        </table>

    </div>

</body>
</html>
