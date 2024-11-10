<?php
require_once('connectvaes.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<div class="topnav">
  <?php
  if (!isset($_COOKIE['fid'])){
    echo 'Please <a href="login.php">log in</a> to access this page';}
  else{
    echo '<a href="index.php">Home';
    echo '<a href="logout.php">Log Out (' . $_COOKIE['username'] . ')</a>';

  }
?>
</div>
<?php
if (isset($_POST['submit'])){
  $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
  $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
  $dob = mysqli_real_escape_string($dbc, trim($_POST['dob']));
  $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
?>
<div class="content">
  <?php

  if((!empty($password))&&(!empty($name))&&(!empty($phone))&&(!empty($location))&&(!empty($dob))){
    $query = "UPDATE farmer_register set fname='$name', flocation='$location', fphoneno = '$phone', password = SHA('$password'), fdob = '$dob' where fid = '" . $_COOKIE['fid'] ."'";
    echo 'Update successful';
    mysqli_query($dbc,$query) or die("Error description: " . mysqli_error($dbc));
    }

  else{
  echo '<p class = "error">Please enter all the profile data';
  }
}
//else {
//  $query = "SELECT fname,flocation, fphoneno, fdob from //farmer_register where fid = '" . $_COOKIE['fid'] ."'";
//  $data = mysqli_query($dbc, $query);
//  $row = mysqli_fetch_array($data);
//  if($row != NULL){
//    $name = $row['fname'];
//    $location = $row['flocation'];
//    $phone= $row['fphoneno'];
//    $dob= $row['fdob'];
//  }
//  else {
//    echo '<p class="error">There was a problem accessing your //profile.</p>';
//  }

mysqli_close($dbc);
 ?>
 </div>
 <!DOCTYPE html>
 <html lang="en">
   <head>
     <link rel="stylesheet" type="text/css" href="farmer_style.css">
     <title></title>
   </head>
   <body>
       <div class="content">
          <div class="form-style-5">
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color:black;">Edit Info</legend>
         <label for="password"> Password: </label>
         <input type="password" id="password" name="password" /><br />
         <label for="name">Name: </label>
         <input type="text" id="name" name="name" /><br />
         <label for="location">Location: </label>
         <input type="text" id="location" name="location" /><br />
         <label for="dob">Date of Birth: </label>
         <input type="date" id="dob" name="dob" /><br />
         <label for="phone">Mobile number: </label>
         <input type="tel" pattern="[0-9]{10}" id="phone" name="phone" /><br />
       </fieldset>
       <input type="submit" name="submit" value="Update profile">

     </form>
   </div>
   </div>
   </body>
 </html>
