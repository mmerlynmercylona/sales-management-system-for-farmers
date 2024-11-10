<html>
<head>
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <title>Farmer sales manager</title>
</head>
<body>
  <?php
  $dbc = mysqli_connect("localhost", "root", "silver", "farmerdatabase");
  //if (isset($_COOKIE['username'])){
  //  echo <a href="logout.php">Log Out (' .$_COOKIE['username'] . ')</a>;
  //}
  //else{
  //  echo <a href="login.php">Log In </a><br />;
  //  echo <a href="signup.php">Sign up </a><br />;
  //}
  ?>
  <div class="topnav">
  <?php
  if (isset($_COOKIE['username'])) {
    echo '<a href="price.php">Calculate price</a>';
    echo '<a href="billentry.php">Enter bill details</a>';
    echo '<a href="recommend.php">Recommend price</a>';
    echo '<a href="editprofile.php">Edit Profile</a>';
    echo '<a href="logout.php">Log Out (' . $_COOKIE['username'] . ')</a>';
  }
  else {
    echo '<a href="login.php">Log In</a>';
    echo '<a href="signup.php">Sign Up</a>';
  }

  mysqli_close($dbc);
  //echo 'At home farmer'

  ?>
  </div>

  <div class="content">
    <h2>Farmer sales manager</h2>

    <p>Please select your choice.</p>
  </div>

</body>

</html>
