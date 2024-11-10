<html>
<div class="content">
<?php
$error_msg = "";
$dbc = mysqli_connect("localhost", "root", "silver", "farmerdatabase");
if (!isset($_COOKIE['fid'])){
  if (isset($_POST['submit'])){


    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

    if (!empty($username) && !empty($password)){
      $query = "select username,fid from farmer_register where username='$username' and password = SHA('$password')";
      $data = mysqli_query($dbc, $query);

      if (mysqli_num_rows($data) == 1){
        $row = mysqli_fetch_array($data);
        setcookie('fid', $row['fid']);
        setcookie('username', $row['username']);
        if($row['username']=="Admin"){
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/master.php';
          header('Location: ' . $home_url);
        }
        else{
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }

      }
      else{
        $error_msg = "Sorry, You have entered invalid username or password.";
        echo '<a style="color:white;" href="signup.php">Not a registered user? Please register here</a><br />';
        echo $error_msg;
      }
    }
    else{
      $error_msg = "Sorry, You must enter username and password to login.";
      echo $error_msg;
      echo '<br /><a href="signup.php">Not a registered user? Please register here</a><br />';

    }
  }
}

 ?>
</div>

  <head>
    <link rel="stylesheet" type="text/css" href="farmer_style.css">
    <title>Farmer sales management</title>
  </head>
  <body>
    <div class="content">
    <h3>Farmer Log In</h3>

       <div class="form-style-5">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <fieldset>
        <legend style="color:black;">Log in</legend>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>"/><br />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"/>
      </fieldset>
      <input type="submit" name="submit" value="Log In"/>

    </form>
  </div>
</div>
  </body>
</html>
