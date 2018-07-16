<?php
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php";

if ( ! isset($_SESSION['user_id']) ) {
    $login = 0;
} else {
    $login = 1;
}


?>
<!DOCTYPE html>
<html>
<head>
<title>About CCM</title>
<?php

require_once "bootstrap.php";

?>


</head>
<body>

  <?php
  $page = 'about';
  require_once "navbar.php";
   ?>

<div class="container">


<?php
  flashMessages();
?>

<h1 class="text-info">About CCM</h1>

<div class="row">
  <div class="col-sm-6">

    <h3>General Overview</h3>

    <p>CCM demonstrates the fundamentals of software engineering for business. A business software system should help the business achieve its goals efficiently, and provide intelligence to drive business decisions.</p>

    <p>General features include:</p>

    <ul>

    <li>secure login / logout function</li>
    <li>company and person add and edit pages</li>
    <li>add orders per company</li>
    <li>interactive charts to display order data</li>

    </ul>

  </div> <!-- end coll sm-4 -->

  <div class="col-sm-6">

    <h3>Technical Overview</h3>

    <p>The fundamentals of programming are demomstrated with this system. It is built on the LAMP stack, without a framework, but with the MVC paradigm considered. From this foundation, learning a new language or development framework is not too difficult.</p>

    <p>Technical details include:</p>

    <ul>

    <li>relational database model</li>
    <li>CRUD operations</li>
    <li>pdo access data abstraction layer</li>
    <li>post redirect get pattern</li>
    <li>session variables and flash messages</li>

    </ul>

  </div> <!-- end coll sm-4 -->


</div>

</div>
</body>
</html>
