<?php
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    $_SESSION["error"] = "Action cancelled";
    header("Location: index.php");
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION['error'] = "You must be logged in to delete a company";
  header('Location: index.php');
  $login = 0;
  return;
} else {
    $login = 1;
}

// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['company_id']) ) {
  $_SESSION['error'] = "Sorry, something went wrong";
  header('Location: index.php');
  return;
} else {
  $company_id = $_GET['company_id'];
}

if ( isset($_POST['delete']) && isset($_POST['company']) ) {

    $sql = "DELETE FROM company WHERE company_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $company_id));
    $_SESSION['success'] = 'Company deleted';
    header( 'Location: index.php' ) ;
    return;
}

$stmt = $pdo->prepare("SELECT * FROM company where company_id = :xyz");
$stmt->execute(array(":xyz" => $company_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Company not found';
    header( 'Location: index.php' ) ;
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Company</title>
<?php

require_once "bootstrap.php";

?>
</head>
<body>

  <?php
  $page = 'delete';
  require_once "navbar.php";
   ?>

<div class="container">

<h1 class="text-info">Delete Company</h1>

<h3>Please confirm: Delete profile for <?= htmlentities($row['name']) ?></h3>

<form onsubmit="return confirm('Are you sure you want to delete this company? This action can't be undone. If yes, click OK.');" method="post">
<input type="hidden" name="company" value="<?= $row['company_id'] ?>">
<input type="submit" class="btn btn-danger" value="Delete" name="delete">

</form>
</br>

<form method="post">
<input type="submit" class="btn btn-dark" name="cancel" value="Cancel">
</form>

</div>
</body>



</html>
