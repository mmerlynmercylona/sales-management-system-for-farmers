<html>
<head>
  <link rel="stylesheet" type="text/css" href="farmer_style.css">
  <div class="content">
  <title>Modify Unit database</title>
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
<div class="topnav">
<?php

if (isset($_POST['submit'])){
  $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  $quantity = mysqli_real_escape_string($dbc, trim($_POST['quantity']));

  if((!empty($name))&&(!empty($quantity))){

      $query = "INSERT into units_master (unit, cunitquantity) values('$name', '$quantity')";
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Record already exists';
      }
      else{
        echo '<p> Success, Unit added.</p>';
        echo '<a href="master_unit.php">Go back to Modify Units</a><br />';
      }
      nysqli_close($dbc);
      exit();
    }
  else{
  echo '<p class = "error">Please fill all the fields';
  }
}

if (isset($_POST['update'])){
  $uname = mysqli_real_escape_string($dbc, trim($_POST['unitfixed']));
  $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  $quantity = mysqli_real_escape_string($dbc, trim($_POST['quantity']));

  if((!empty($name))&&(!empty($quantity))){

      $query = "SELECT uid from units_master where unit='$uname'";
      $data = mysqli_query($dbc,$query);
      $row1 = mysqli_fetch_array($data);
      $uid = $row1[0];
      //update units_master set unit='merry go', cunitquantity=11 where uid = 6;
      $query = "UPDATE units_master set unit='$name', cunitquantity=$quantity where uid=$uid";
      $result = mysqli_query($dbc, $query);
      if(!$result){
        echo 'Error, Please try again';
      }
      else{
        echo '<p> Success, Unit Updated.</p>';
        echo '<a href="master_unit.php">Go back to Modify Units</a><br />';
      }
      nysqli_close($dbc);
      exit();
    }
  else{
  echo '<p class = "error">Please fill all the fields';
  }
}

if (isset($_POST['delete'])){
  $uname = mysqli_real_escape_string($dbc, trim($_POST['unitfixed']));
  $query = "SELECT uid from units_master where unit='$uname'";
  $data = mysqli_query($dbc,$query);
  $row1 = mysqli_fetch_array($data);
  $uid = $row1[0];

      $query = "DELETE from units_master where uid=$uid";
      $result = mysqli_query($dbc, $query);
      if(!$result){
        echo 'Error, Please try again';
      }
      else{
        echo '<p> Success, Unit Deleted.</p>';
        echo '<a href="master_unit.php">Go back to Modify Units</a><br />';
      }
      nysqli_close($dbc);
      exit();
}
$query = "SELECT unit from units_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$unit_options = "";
while($row = mysqli_fetch_array($data)){
  $unit_options = $unit_options."<option>$row[0]</option>";
}

mysqli_close($dbc);
 ?>
 </div>
</div>



       <div class="form-style-5">
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend>Insert Unit</legend>

         <label for="name">Unit Name: </label>
         <input type="text" id="name" name="name" /><br />

         <label for="quantity">Unit Quantity: </label>
         <input type="text" id="quantity" name="quantity" /><br />

       </fieldset>
       <input type="submit" name="submit" value="Add unit">

     </form>

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend>Update Unit</legend>
         <label for="unitfixed"> Existing Unit: </label>
         <select name="unitfixed">
           <?php echo $unit_options; ?>
         </select><br />

         <label for="name">Unit Name: </label>
         <input type="text" id="name" name="name" /><br />

         <label for="quantity">Unit Quantity: </label>
         <input type="text" id="quantity" name="quantity" /><br />

       </fieldset>
       <input type="submit" name="update" value="Update unit">

     </form>

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend>Delete Unit</legend>
         <label for="unit"> Unit name: </label>
         <select name="unitfixed">
           <?php echo $unit_options; ?>
         </select><br />

       </fieldset>
       <input type="submit" name="delete" value="Delete unit">

     </form>
</div>
</div>
   </body>
 </html>
