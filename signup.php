<html>
<link rel="stylesheet" type="text/css" href="farmer_style.css">
<div class="content">
<?php
//mysqli_query($dbc,$query) or die("Error description: " . mysqli_error($dbc));
  $dbc = mysqli_connect("localhost", "root", "silver", "farmerdatabase");
  if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  if (isset($_POST['submit'])){
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
    $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
    $dob = mysqli_real_escape_string($dbc, trim($_POST['dob']));
    //$username = $_POST{'username'};
    //$password1 = $_POST{'password1'};
    //$password2 = $_POST{'password2'};
    //$name = $_POST{'name'};
    //$phone = $_POST{'phone'};
    //$location = $_POST{'location'};
    //$dob = $_POST{'dob'};




    //&& (!empty($password1))&&(!empty($password2))&&(!empty($name))&&(!empty($phone))&&(!empty($location))&&(!empty($dob))

    if (!empty($username)&&(!empty($password1))&&(!empty($password2))&&(!empty($name))&&(!empty($phone))&&(!empty($location))&&(!empty($dob))){
      //echo 'inside if 2';
      $query = "Select * from farmer_register where username = '$username'";
      $data = mysqli_query($dbc, $query);
      //echo 'executed select <br/>';
      //echo 'New users name'.$username ;
      //echo '<br/>';
      //echo 'New users birthday'.$dob;
      //echo '<br/>';
      if(mysqli_num_rows($data) == 0){

        $query = "INSERT into farmer_register (username, password, fname, flocation,fphoneno,fdob)values('$username',SHA('$password1'),'$name','$location','$phone','$dob')";
        mysqli_query($dbc,$query) or die("Error ");

        echo '<p> Success, Your account has been created. <a href="editprofile.php">Edit your profile</a>.</p>';
        echo ''.$dob;
        nysqli_close($dbc);

        exit();
      }
      else {
        echo '<p class="error"> An account already exists for this username, please try another username </p>';
        $username="";
      }
    }
    else {
      echo '<p class="error"> Please enter data in all fields</p>';
    }
  }
  mysqli_close($dbc);
?>
</div>








<div class="content">


    <p> Please enter the following details to signup </p>

       <div class="form-style-5">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <fieldset>
        <legend style="color:black;">Registration Info</legend>
        <label for="username"> Username: </label>
        <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username ?>"/><br />
        <label for="password1"> Password: </label>
        <input type="password" id="password1" name="password1" /><br />
        <label for="password2"> Retype Password: </label>
        <input type="password" id="password2" name="password2" /><br />
        <label for="name">Name: </label>
        <input type="text" id="name" name="name" /><br />
        <label for="location">Location: </label>
        <input type="text" id="location" name="location" /><br />
        <label for="dob">Date of Birth: </label>
        <input type="date" id="dob" name="dob" /><br />
        <label for="phone">Mobile number: </label>
        <input type="tel" pattern="[0-9]{10}" id="phone" name="phone" /><br />

      </fieldset>
      <input type="submit" name="submit" value="Sign up">

    </form>
  </div>
</div>
     </html>
