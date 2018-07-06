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
  return;
// else set user id if user is logged in to session
} else {
    $user_id = $_SESSION['user_id'];
}

 // inserts order
if ( isset($_POST['order'])) {

  // check for missing values
  if ( isset($_POST['company']) && isset($_POST['amount'])) {

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

    }

}

?>
<!DOCTYPE html>
<html>
<head>
<title>Add Order</title>

<?php
require_once "bootstrap.php";
?>

</head>
<body>
<div class="container">
<h1>Add Order</h1>
<?php

// display if error
if ( isset($_SESSION["error"]) ) {
      echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
      unset($_SESSION["error"]);
  }

?>

<!-- add order form -->
<form method="post">

  <p>Company:<select name="company">
    <option value="">Select...</option>

    <?php
    $stmt = $pdo->query("SELECT * FROM company");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    ?>
      <option value=<?php echo(htmlentities($row['company_id']));?>><?php echo(htmlentities($row['name']));?></option>';
    <?php } ?>
  </select>
  </p>

  <p>Amount:<input type='number' name='amount' step='0.01' value='0.00' placeholder='0.00'></p>

  <p><input type="submit" name="order" value="Add Order"/><input type="submit" name="cancel" value="Cancel"></p>

</form>

</div>

<script>

</script>

</body>
</html>
