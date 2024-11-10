<html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="farmer_style.css">
    <title>Modify Crop database</title>
  </head>
  <body>
<div class="topnav">
<?php
require_once('connectvaes.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!isset($_COOKIE['fid'])){
  echo '<p class="login"> Please <a href="login.php">log in</a> to access this page';}
else{
  //echo('<p class="login">You are logged in as ' . $_COOKIE['username'] . '.<a href="logout.php">Log out</a>.</p>');
  echo('<p><a href="master.php">Home</a></p>');
  echo '<a href="logout.php">Log Out (' . $_COOKIE['username'] . ')</a>';
}
?>
</div>
<div class="content">
  <?php

if (isset($_POST['submit'])){
  $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  $unit = mysqli_real_escape_string($dbc, trim($_POST['unit']));


  if((!empty($name))&&(!empty($unit))){
    $query = "SELECT uid from units_master where unit='$unit'";
    $data = mysqli_query($dbc, $query);
    $row1 = mysqli_fetch_array($data);
    $uid = $row1[0];
    $query = "SELECT * from crop_master where cname = '$name' and cunitid='$uid'";
    $data = mysqli_query($dbc, $query);

    //if(mysqli_num_rows($data) == 0){

      $query = "INSERT into crop_master (cname, cunitid) values('$name', '$uid')";
      //mysqli_query($dbc,$query) or die(mysql_error());
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Record already exists';
      }
      else{
        echo '<p> Success, Crop added.</p>';
        echo '<a href="master_crop.php">Go back to Modify Crops</a><br />';
      }



      mysqli_close($dbc);

      exit();
    //}
    //else {
      //echo '<p class="error"> Crop already exists, please try another</p>';
    }//}

  else{
  echo '<p class = "error">Please fill all the fields';
  }
}

if (isset($_POST['update'])){
  $cname = mysqli_real_escape_string($dbc, trim($_POST['cropfixed']));
  $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  $unit = mysqli_real_escape_string($dbc, trim($_POST['unit']));


  if((!empty($name))&&(!empty($unit))){
    $query = "SELECT uid from units_master where unit='$unit'";
    $data = mysqli_query($dbc, $query);
    $row1 = mysqli_fetch_array($data);
    $uid = $row1[0];
    $query = "SELECT cid from crop_master where cname = '$cname'";
    $data = mysqli_query($dbc, $query);
    $row2 = mysqli_fetch_array($data);
    $cid = $row2[0];

    //if(mysqli_num_rows($data) == 0){

      $query = "UPDATE crop_master set cname='$name', cunitid='$uid' where cid=$cid";
      //mysqli_query($dbc,$query) or die(mysql_error());
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Error, please try again';
      }
      else{
        echo '<p> Success, Crop Updated.</p>';
        echo '<a href="master_crop.php">Go back to Modify Crops</a><br />';
      }
      mysqli_close($dbc);
      exit();
    }
  else{
  echo '<p class = "error">Please fill all the fields';
  }
}

if (isset($_POST['delete'])){
  $cname = mysqli_real_escape_string($dbc, trim($_POST['cropfixed']));

    $query = "SELECT cid from crop_master where cname = '$cname'";
    $data = mysqli_query($dbc, $query);
    $row2 = mysqli_fetch_array($data);
    $cid = $row2[0];

      $query = "DELETE from crop_master where cid=$cid";
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Error, please try again';
      }
      else{
        echo '<p> Success, Crop Deleted.</p>';
        echo '<a href="master_crop.php">Go back to Modify Crops</a><br />';
      }
      mysqli_close($dbc);
      exit();
    }




$query = "SELECT unit from units_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$unit_options = "";
while($row = mysqli_fetch_array($data)){
  $unit_options = $unit_options."<option>$row[0]</option>";
}

$query = "select cname from crop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$crop_options = "";
while($row = mysqli_fetch_array($data)){
  $crop_options = $crop_options."<option>$row[0]</option>";
}
mysqli_close($dbc);
 ?>

     <div class="content">
      <div class="form-style-5">
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color:black;">Crop Insert</legend>

         <label for="name">Crop Name: </label>
         <input type="text" id="name" name="name" /><br />

         <label for="unit"> Unit type: </label>
         <select name="unit">
           <?php echo $unit_options; ?>
         </select><br />

       </fieldset>
       <input type="submit" name="submit" value="Add crop">

     </form>

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color:black;">Crop Update</legend>


         <label for="cropfixed"> Existing crop: </label>
         <select name="cropfixed">
           <?php echo $crop_options; ?>
         </select><br />
         <label for="unit"> Unit type: </label>
         <select name="unit">
           <?php echo $unit_options; ?>
         </select><br />
         <label for="name">Updated Crop Name: </label>
         <input type="text" id="name" name="name" /><br />

       </fieldset>
       <input type="submit" name="update" value="Update crop">

     </form>

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color:black;">Crop Delete</legend>


         <label for="cropfixed"> Existing crop: </label>
         <select name="cropfixed">
           <?php echo $crop_options; ?>
         </select><br />

       </fieldset>
       <input type="submit" name="delete" value="Delete crop">

     </form>
   </div>
 </div>
   </body>
 </html>
