<?php
// If the user requested logout
if ( isset($_POST['logout']) ) {
    header('Location: Logout.php');
    return;
}

function flashMessages() {
  if ( isset($_SESSION['success']) ) {
    echo('<div class="alert alert-success">'.htmlentities($_SESSION['success'])."</div>\n");
    unset($_SESSION['success']);
}

  if ( isset($_SESSION['error']) ) {
    echo('<div class="alert alert-danger">'.htmlentities($_SESSION['error'])."</div>\n");
    unset($_SESSION['error']);
}
}

function greeting() {
  if ( isset($_SESSION['greet']) ) {
    echo('<div class="alert alert-success">'.htmlentities($_SESSION['greet'])."</div>\n");
    unset($_SESSION['greet']);
}

}

// this is library code so no closing php tag at end
