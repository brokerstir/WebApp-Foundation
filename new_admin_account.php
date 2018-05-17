<?php // Do not put any HTML above this line
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    $_SESSION["error"] = "Action cancelled";
    header("Location: index.php");
    return;
}


$salt = 'XyZzy12*_';

if ( isset($_POST['add'])) {

  if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['username'])  && isset($_POST['pass']) && isset($_POST['email'])) { // checks if all values are set

         $hashed = hash('md5', $salt.$_POST['pass']); // hashes password

         $stmt = $pdo->prepare('INSERT INTO users
             (first_name, last_name, username, email, password, type)
             VALUES ( :fn, :sn, :un, :em, :pw, :tp)');
         $stmt->execute(array(

             ':fn' => $_POST['first_name'],
             ':sn' => $_POST['last_name'],
             ':un' => $_POST['username'],
             ':em' => $_POST['email'],
             ':pw' => $hashed,
             ':tp' => 1)

         );

           $_SESSION['success'] = "New Admin User Added";
           header("Location: index.php");
           return;

           // for testing purpose
           // user: admin / pw: secret123

    }


}


// Fall through into the View
?>
<!DOCTYPE html>
<html>

<head>
<?php require_once "bootstrap.php"; ?>
<title>Robert Risk | New User</title>
</head>
<body>
<div class="container">
<h1>Add New User Account</h1>
<?php

flashMessages();

?>
<form method="POST">

First Name <input type="text" name="first_name"><br/>
Last Name <input type="text" name="last_name"><br/>
User Name <input type="text" name="username"><br/>
User Email <input type="text" name="email" id="id_1722"><br/>
Password <input type="password" name="pass" id="id_1723"><br/>

<p><input type="submit" name="add" value="Add User"/><input type="submit" name="cancel" value="Cancel"></p>

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
