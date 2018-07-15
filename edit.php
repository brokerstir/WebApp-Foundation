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


if ( isset($_POST['name']) ) {

    // Data validation should go here (see add.php)
    $sql = "UPDATE company SET name = :name,
            address = :address, city = :city, state = :state, zip = :zip
            WHERE company_id = :company_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':address' => $_POST['address'],
        ':city' => $_POST['city'],
        ':state' => $_POST['state'],
        ':zip' => $_POST['zip'],
        ':company_id' => $_POST['company_id']));
    $_SESSION['success'] = 'Company Updated';
    header( 'Location: index.php' ) ;
    return;
}

/// Guardian: first_name sure that user_id is in session
if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION["error"] = "You must be logged in to edit a company";
  header( 'Location: index.php' ) ;
  $login = 0;
  return;
} else {
    $user_id = $_SESSION['user_id'];
    $login = 1;
}

// Guardian: Make sure that company_id is present
if ( ! isset($_GET['company_id']) ) {
  $_SESSION['error'] = "No company was selected";
  header('Location: index.php');
  return;
} else {
  $company_id = $_GET['company_id'];
}

$stmt = $pdo->prepare("SELECT * FROM company where company_id = :xyz");
$stmt->execute(array(":xyz" => $company_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Sorry, Something Went Wrong';
    header( 'Location: index.php' ) ;
    return;
}

$n = htmlentities($row['name']);
$a = htmlentities($row['address']);
$c = htmlentities($row['city']);
$s = htmlentities($row['state']);
$z = htmlentities($row['zip']);

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
  $page = 'edit';
  require_once "navbar.php";
   ?>

<div class="container">

<h1 class="text-info">Edit Company</h1>

<div class="row">
  <div class="col-sm-8">

    <form method="post">

      <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" value="<?= $n ?>">
      </div>

      <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="address" value="<?= $a ?>">
      </div>

      <div class="form-group">
          <label for="city">City</label>
          <input type="text" class="form-control" name="city" value="<?= $c ?>">
      </div>

      <div class="form-group">
        <label for="state">State</label>
        <select name="state" class="form-control">
        <option value="<?= $s ?>"><?= $s ?></option>
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
      <input type="text" class="form-control" name="zip" value="<?= $z ?>">
    </div>

       <input type="hidden" name="company_id" value="<?= $company_id ?>">
       <button type="submit" class="btn btn-info">Update</button>
       <button type="submit" class="btn btn-dark" name=cancel>Cancel</button>
    </form>

  </div>
  <div class="col-sm-4">

  </div>
</div>

</div>

</body>
</html>
