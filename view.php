<?php
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php";

if ( ! isset($_SESSION['user_id']) ) {
    $login = 0;
} else {
    $login = 1;
}


// Guardian: Make sure that company_id is present
if ( ! isset($_GET['company_id']) ) {
  $_SESSION['error'] = "No company was selected";
  header('Location: index.php');
  return;
} else {
  $company_id = $_GET['company_id'];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>View Company</title>
<?php

require_once "bootstrap.php";

?>

<style>
table, tr, th, td {
   border: 1px solid black;
}
</style>


</head>
<body>

  <?php
  $page = 'view';
  require_once "navbar.php";
   ?>

<div class="container">


<?php
  flashMessages();
?>

<h1 class="text-info">View Company</h1>

  <?php

  $count = 0;
  $stmt = $pdo->query("SELECT * FROM company
                          LEFT JOIN users on company.company_id = users.company_id
                          Where company.company_id = $company_id order by last_name");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    if ($count == 0) {
      echo "<p><strong>";
      echo(htmlentities($row['name']));
      echo "</br></strong>";
      echo (htmlentities($row['address'])) . ", " . (htmlentities($row['city'])) . ", " . (htmlentities($row['state'])) . "  " . (htmlentities($row['zip']));
      echo "</br></p></br>";

      echo "<strong>";
      echo('Contacts:');
      echo "</strong></br>";
    }

    echo(htmlentities($row['first_name'] . " " . $row['last_name']));
    echo "</br>";
    $count += 1;
  }

  echo "</br>";

  echo('<a href="edit.php?company_id='.$company_id.'" class="btn btn-outline-warning" role="button">Edit Company</a> ');
  echo('<a href="add_contact.php?company_id='.$company_id.'" class="btn btn-outline-info" role="button">Add Company Contact</a> ');

  ?>


</div>
</body>
</html>
