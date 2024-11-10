<html>
<head>
  <link rel="stylesheet" type="text/css" href="farmer_style.css">
  <title>Admin Farmer sales manager</title>
</head>
<body>
  <div class="content">
  <h2>Farmer sales manager Admin</h2>
  <div class="topnav">
  <?php
  $dbc = mysqli_connect("localhost", "root", "silver", "farmerdatabase");

  if (isset($_COOKIE['username'])) {
    echo '<a href="master_shop.php">Modify Markets</a>';
    echo '<a href="master_unit.php">Modify Units</a>';
    echo '<a href="master_crop.php">Modify Crops</a>';

    //echo '<a href="editprofile.php">Edit Profile</a>';
    echo '<a href="logout.php">Log Out (' . $_COOKIE['username'] . ')</a>';
  }
  else {
    echo '<a href="login.php">Log In</a>';
    echo '<a href="signup.php">Sign Up</a>';
  }

  mysqli_close($dbc);

  ?>
</div>
</div>
</body>

</html>
