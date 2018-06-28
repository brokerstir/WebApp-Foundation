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

if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION["error"] = "You must be logged in to place an order";
  header( 'Location: index.php' ) ;
  return;
} else {
    $user_id = $_SESSION['user_id'];
}

if ( isset($_POST['order'])) {

  if ( isset($_POST['company']) && isset($_POST['amount'])) {

        $stmt = $pdo->prepare('INSERT INTO orders
            (company_id, amount)
            VALUES ( :id, :am)');
        $stmt->execute(array(
            ':id' => $_POST['company'],
            ':am' => $_POST['amount'])
        );

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


if ( isset($_SESSION["error"]) ) {
      echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
      unset($_SESSION["error"]);
  }

?>
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