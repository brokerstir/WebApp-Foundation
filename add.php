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

// security check if user is logged in
if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION["error"] = "You must be logged in to add a company";
  header( 'Location: index.php' ) ;
  $login = 0;
  return;
} else {
    $user_id = $_SESSION['user_id'];
    $login = 1;
}

if ( isset($_POST['add'])) {

  if ( isset($_POST['name']) && isset($_POST['address'])
       && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip'])) {

        $stmt = $pdo->prepare('INSERT INTO company
            (name, address, city, state, zip)
            VALUES ( :nm, :ad, :cy, :st, :zp)');
        $stmt->execute(array(
            ':nm' => $_POST['name'],
            ':ad' => $_POST['address'],
            ':cy' => $_POST['city'],
            ':st' => $_POST['state'],
            ':zp' => $_POST['zip'])
        );

          $_SESSION['success'] = "New Company Added";
          header("Location: index.php");
          return;

    }


}

?>
<!DOCTYPE html>
<html>
<head>
<title>Add Company</title>

<?php
require_once "bootstrap.php";
?>

</head>
<body>

<?php
$page = 'add';
require_once "navbar.php";
 ?>

<div class="container">
<h1 class="text-info">Add Company</h1>
<?php


if ( isset($_SESSION["error"]) ) {
      echo('<div class="alert alert-danger">'.$_SESSION["error"]."</div>\n");
      unset($_SESSION["error"]);
  }

?>

<div class="row">
  <div class="col-sm-8">

    <form method="post">

      <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name">
      </div>

      <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="address">
      </div>

      <div class="form-group">
          <label for="city">City</label>
          <input type="text" class="form-control" name="city">
      </div>

      <div class="form-group">
        <label for="state">State</label>
        <select name="state" class="form-control">
        <option value="">Select...</option>
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District Of Columbia</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
        <option value="IA">Iowa</option>
        <option value="KS">Kansas</option>
        <option value="KY">Kentucky</option>
        <option value="LA">Louisiana</option>
        <option value="ME">Maine</option>
        <option value="MD">Maryland</option>
        <option value="MA">Massachusetts</option>
        <option value="MI">Michigan</option>
        <option value="MN">Minnesota</option>
        <option value="MS">Mississippi</option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
        <option value="ND">North Dakota</option>
        <option value="OH">Ohio</option>
        <option value="OK">Oklahoma</option>
        <option value="OR">Oregon</option>
        <option value="PA">Pennsylvania</option>
        <option value="RI">Rhode Island</option>
        <option value="SC">South Carolina</option>
        <option value="SD">South Dakota</option>
        <option value="TN">Tennessee</option>
        <option value="TX">Texas</option>
        <option value="UT">Utah</option>
        <option value="VT">Vermont</option>
        <option value="VA">Virginia</option>
        <option value="WA">Washington</option>
        <option value="WV">West Virginia</option>
        <option value="WI">Wisconsin</option>
        <option value="WY">Wyoming</option>
      </select>
    </div>

    <div class="form-group">
      <label for="zip">Zip Code</label>
      <input type="text" class="form-control" name="zip">
    </div>
       <button type="submit" class="btn btn-info" name=add>Add Company</button>
       <button type="submit" class="btn btn-dark" name=cancel>Cancel</button>
    </form>

  </div> <!-- end coll sm-8 -->
  <div class="col-sm-4"></div>
</div>



</div>

<script>

</script>

</body>
</html>
