<?php // Do not put any HTML above this line
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php"; // library of functions

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    $_SESSION["error"] = "Action cancelled";
    header("Location: index.php");
    return;
}


$salt = 'XyZzy12*_';
//$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123
//$secret = 'php123';

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['username']) && isset($_POST['pass']) ) {

    unset($_SESSION["username"]);  // Logout current user

    if ( strlen($_POST['username']) < 1 || strlen($_POST['pass']) < 1 ) { // check if either input is empty

        $_SESSION["error"] = "username and password are required";
        header( 'Location: login.php' ) ;
        return; // returs error message


    } else { // inputs are valid so check if user and pw are correct

        $check = hash('md5', $salt.$_POST['pass']); // defines $check
        $stmt = $pdo->prepare('SELECT user_id, username FROM users
        WHERE username = :un AND password = :pw'); // queries db
        $stmt->execute(array( ':un' => $_POST['username'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // fetches row from db if a match

        if ( $row !== false ) { // there is a user and pw match

            // create session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION["success"] = "You are now logged in";
            $_SESSION["greet"] = "Hello " . $_SESSION['username'];
            // Redirect the browser to index.php
            header("Location: index.php");
            return;

          } else { // there is no user and pw match

            // log the error
            error_log("Login fail ".$_POST['username']);
            $_SESSION["error"] = "Login Failed";
            // Redirect the browser to index.php
            header( 'Location: login.php' ) ;
            return;

        }
    }
} // end if ( isset($_POST['username']) && isset($_POST['pass']) )

// Fall through into the View
?>
<!DOCTYPE html>
<html>

<head>
<?php require_once "bootstrap.php"; ?>
<title>Robert Risk | Resume Profiles</title>
</head>
<body>

<?php
$login = 0;
require_once "navbar.php";
?>

<div class="container">
<h1>Please Log In</h1>
<?php

flashMessages();

?>

<form method="POST">

  <div class="form-group">
      <label for="name">Username</label>
      <input type="text" class="form-control" name="username" id="id_1722">
  </div>

  <div class="form-group">
      <label for="name">Password</label>
      <input type="password" class="form-control" name="pass" id="id_1723">
  </div>

<input type="submit" class="btn btn-info" onclick="return doValidate();" value="Log In">
<input type="submit" class="btn btn-dark" name="cancel" value="Cancel">

</form>

</div>

<script>

function doValidate() {
    console.log('Validating...');
    try {
        un = document.getElementById('id_1722').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating pw="+pw);
        console.log("Validating un="+un);
        if (un == null || un == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}

</script>


</body>

</html>
