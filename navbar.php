<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand text-info" href="#"><strong>CCM</strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">


      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Dropdown link
       </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         <a class="dropdown-item" href="#">Action</a>
         <a class="dropdown-item" href="#">Another action</a>
         <a class="dropdown-item" href="#">Something else here</a>
       </div>
     </li>

      <li class="nav-item <?php if ($page == 'add') { ?> active <?php } ?>">
        <a class="nav-link" href="add.php">Add Company</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="order.php">Place Order</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <?php if ($login == 0) { ?>
      <li class="nav-item">
        <a class="nav-link" href="Login.php">Login</a>
      </li>
      <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
      <?php } ?>
    </ul>

  </div>
</nav>
