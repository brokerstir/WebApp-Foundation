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
<div class="container">
<h1>View Company Information</h1>

<?php
  flashMessages();
?>

  <?php

  $count = 0;
  $stmt = $pdo->query("SELECT * FROM company
                          LEFT JOIN users on company.company_id = users.company_id
                          Where company.company_id = $company_id");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    if ($count == 0) {
      echo "<h3>";
      echo(htmlentities($row['name']));
      echo "</h3>";
      echo "<p>" . (htmlentities($row['address'])) . ", " . (htmlentities($row['city'])) . ", " . (htmlentities($row['state'])) . "  " . (htmlentities($row['zip'])) . "</p>";
      echo "</br>";
    }
    echo(htmlentities($row['first_name']));
    echo "</br>";
    $count += 1;
  }

  echo "</br>";

  echo "<p>";
  echo('<a href="edit.php?company_id='.$company_id.'">Edit Company</a> ');
  echo("</p>");

  echo "<p>";
  echo('<a href="add_contact.php?company_id='.$company_id.'">Add Company Contact</a> ');
  echo("</p>");
  ?>

  <p><a href="index.php">Home Page</a></p>
  <p><a href="logout.php">Logout</a></p>

</div>
</body>
</html>
