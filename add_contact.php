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


/// Guardian: check that user_id is in session
if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION["error"] = "You must be logged in to add contacts";
  header( 'Location: index.php' ) ;
  return;
} else {
    $user_id = $_SESSION['user_id'];
}

// Guardian: Make sure that company_id is present
if ( ! isset($_GET['company_id']) ) {
  $_SESSION['error'] = "Sorry, something went wrong";
  header('Location: index.php');
  return;
} else {
  $company_id = $_GET['company_id'];
}

$stmt = $pdo->prepare("SELECT * FROM company where company_id = :xyz");
$stmt->execute(array(":xyz" => $company_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Sorry, something went wrong';
    header( 'Location: index.php' ) ;
    return;
}

if ( isset($_POST['add'])) {

  if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['salutation'])  && isset($_POST['company_id']) && isset($_POST['email'])) { // checks if all values are set

         $cd = $_POST['company_id'];
         $stmt = $pdo->prepare('INSERT INTO users
             (company_id, salutation, first_name, last_name, email, type)
             VALUES ( :cd, :sa, :fn, :sn, :em, :tp)');
         $stmt->execute(array(

             ':cd' => $_POST['company_id'],
             ':sa' => $_POST['salutation'],
             ':fn' => $_POST['first_name'],
             ':sn' => $_POST['last_name'],
             ':em' => $_POST['email'],
             ':tp' => 0)

         );

           $_SESSION['success'] = "New contact person added";
           header("Location: view.php?company_id=$cd");
           return;

           // for testing purpose
           // user: admin / pw: secret123

    }


}


?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Company</title>
<?php

require_once "bootstrap.php";

?>
</head>
<body>

  <div class="container">
  <h1>Add Company Contact Person</h1>

  <?php
    flashMessages();
  ?>

    <?php

    $stmt = $pdo->query("SELECT * FROM company Where company_id = $company_id");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      echo "<h3>";
      echo "Company: " . (htmlentities($row['name']));
      echo "</h3>";
      echo "<p>" . (htmlentities($row['address'])) . ", " . (htmlentities($row['city'])) . ", " . (htmlentities($row['state'])) . "  " . (htmlentities($row['zip'])) . "</p>";
    }
?>


<form method="post">

  <h3>Contact Person:</h3>
  Salutation <input type="text" name="salutation"><br/>
  First Name <input type="text" name="first_name"><br/>
  Last Name <input type="text" name="last_name"><br/>
  Email <input type="text" name="email"><br/>

  <input type="hidden" name="company_id" value="<?= $company_id ?>">

  <p><input type="submit" name="add" value="Add Contact"/><input type="submit" name="cancel" value="Cancel"></p>

</form>

</body>
</html>
