<?php
// This script is for adding new orders

// start session
session_start();

// connect db
require_once "pdo.php";

// utility functions
require_once "util.php";

// cancel order action
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    $_SESSION["error"] = "Action cancelled";
    header("Location: index.php");
    return;
}

// redirect to home if no user in session
if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION["error"] = "You must be logged in to place an order";
  header( 'Location: index.php' ) ;
  $login = 0;
  return;
// else set user id if user is logged in to session
} else {
    $login = 1;
    $user_id = $_SESSION['user_id'];
}

 // inserts order
if ( isset($_POST['order'])) {

  // check for missing values
  if ( isset($_POST['company']) && isset($_POST['amount'])) {

        $c_id = isset($_POST['company']);
        if ($c_id == "") {
          $_SESSION['error'] = "Unable to place order. Try again.";
          header("Location: index.php");
          return;
        }

        // pdo insert
        $stmt = $pdo->prepare('INSERT INTO orders
            (company_id, amount)
            VALUES ( :id, :am)');
        $stmt->execute(array(
            ':id' => $_POST['company'],
            ':am' => $_POST['amount'])
        );

          // redirect with success message
          $_SESSION['success'] = "New Order Added";
          header("Location: index.php");
          return;

    } else {

          $_SESSION['error'] = "Unable to place order.  ";
          header("Location: index.php");
          return;

    }

}

?>
<!DOCTYPE html>
<html>
<head>
<title>Place Order</title>

<?php
require_once "bootstrap.php";
?>

</head>
<body>

  <?php
  $page = 'order';
  require_once "navbar.php";
   ?>

<div class="container">
<h1 class="text-info">Place Order</h1>

<?php

// display if error
if ( isset($_SESSION["error"]) ) {
      echo('<div class="alert alert-danger">'.$_SESSION["error"]."</div>\n");
      unset($_SESSION["error"]);
  }

?>


<div class="row">
  <div class="col-sm-4">
<!-- add order form -->
<form method="post">

  <div class="form-group">
    <label for="Company">Company</label>
    <select name="company" class="form-control">
      <option value="">Select...</option>

      <?php
      $stmt = $pdo->query("SELECT * FROM company order by name");
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      ?>
        <option value=<?php echo(htmlentities($row['company_id']));?>><?php echo(htmlentities($row['name']));?></option>';
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="Amount">Amount</label>
    <input type='number' class="form-control" name='amount' step='5' value='0.00' placeholder='0.00'>
  </div>

  <input type="submit" class="btn btn-info" name="order" value="Place Order"/>
  <input type="submit" class="btn btn-dark" name="cancel" value="Cancel">

</form>

</div> <!-- end coll sm-4 -->
<div class="col-sm-8"></div>
</div>

</div>

<script>

</script>

</body>
</html>
