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

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: Logout.php');
    return;
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

<script>
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
</script>

</head>
<body>
<div class="container">
<h1>View Company Information</h1>

<?php
  flashMessages();
?>

  <?php

  $stmt = $pdo->query("SELECT * FROM company Where company_id = $company_id");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<h3>";
    echo(htmlentities($row['name']));
    echo("</h3>");
  }

  echo "<p>";
  echo('<a href="edit.php?company_id='.$company_id.'">Edit</a> ');
  echo("</p>");
  ?>


  <p><a href="add.php">Add New</a></p>
  <p><a href="index.php">Home Page</a></p>
  <p><a href="logout.php">Logout</a></p>

</div>
</body>
</html>
