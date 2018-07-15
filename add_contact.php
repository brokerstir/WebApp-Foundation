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
  $login = 0;
  return;
} else {
    $user_id = $_SESSION['user_id'];
    $login = 1;
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

  <?php
  $page = 'add_contact';
  require_once "navbar.php";
   ?>

  <div class="container">
  <h1 class="text-info">Add Company Contact</h1>

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

<div class="row">
  <div class="col-sm-8">

<form method="post">

  <h3>Contact Person:</h3>

  <div class="form-group">
    <label for="Salutation">Salutation</label>
    <input type="text" class="form-control" name="salutation">
  </div>

  <div class="form-group">
    <label for="First Name">First Name</label>
    <input type="text" class="form-control" name="first_name">
  </div>

  <div class="form-group">
    <label for="Last Name">Last Name</label>
    <input type="text" class="form-control" name="last_name">
  </div>

  <div class="form-group">
    <label for="Email">Email</label>
    <input type="text" class="form-control" name="email">
  </div>


  <input type="hidden" name="company_id" value="<?= $company_id ?>">

   <button type="submit" class="btn btn-info" name=add>Add Contact</button>
   <button type="submit" class="btn btn-dark" name=cancel>Cancel</button>
  
</form>

</div> <!-- end coll sm-8 -->
<div class="col-sm-4"></div>

</div>

</div>

</body>
</html>
