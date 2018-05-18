<?php
// If the user requested logout
if ( isset($_POST['logout']) ) {
    header('Location: Logout.php');
    return;
}

function flashMessages() {
  if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

  if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
}

function greeting() {
  if ( isset($_SESSION['greet']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['greet'])."</p>\n");
    unset($_SESSION['greet']);
}

}

// this is library code so no closing php tag at end
