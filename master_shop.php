<html>
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
  $owner = mysqli_real_escape_string($dbc, trim($_POST['owner']));
  $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
  $address = mysqli_real_escape_string($dbc, trim($_POST['address']));
  $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
  $commission = mysqli_real_escape_string($dbc, trim($_POST['commission']));
  $transport = mysqli_real_escape_string($dbc, trim($_POST['transport']));

  if((!empty($owner))&&(!empty($name))&&(!empty($phone))&&(!empty($transport))&&(!empty($address))&&(!empty($location))&&(!empty($commission))){
    //$query = "SELECT * from shop_master where sname = '$name' and sphone='$phone' and saddress='$address'";
    //$data = mysqli_query($dbc, $query);
    //echo 'executed select <br/>';
    //echo 'New users name'.$username ;
    //echo '<br/>';
    //echo 'New users birthday'.$dob;
    //echo '<br/>';

      $query = "INSERT into shop_master (sname, slocation, sowner, sphone, saddress, scommision, stransport) values('$name', '$location', '$owner', '$phone','$address','$commission', '$transport')";
      //mysqli_query($dbc,$query) or die("Error ");
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Record already exists';
      }
      else{
        echo '<p> Success, Shop added.</p>';
        echo '<a href="master_shop.php">Go back to Modify Markets</a><br />';
      }
      nysqli_close($dbc);

      exit();

    }

  else{
  echo '<p class = "error">Please fill all the fields';
  }
}

if (isset($_POST['update'])){
  $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  $name_fixed = mysqli_real_escape_string($dbc, trim($_POST['shopfixed']));
  $owner = mysqli_real_escape_string($dbc, trim($_POST['owner']));
  $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
  $address = mysqli_real_escape_string($dbc, trim($_POST['address']));
  $address_fixed = mysqli_real_escape_string($dbc, trim($_POST['shopfixed_addr']));
  $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
  $phone_fixed = mysqli_real_escape_string($dbc, trim($_POST['shopfixed_p']));
  $commission = mysqli_real_escape_string($dbc, trim($_POST['commission']));
  $transport = mysqli_real_escape_string($dbc, trim($_POST['transport']));

  if((!empty($owner))&&(!empty($name))&&(!empty($phone))&&(!empty($transport))&&(!empty($address))&&(!empty($location))&&(!empty($commission))){

    $query = "SELECT sid from shop_master where sname='$name_fixed' and saddress='$address_fixed' and sphone='$phone_fixed'";
    $data = mysqli_query($dbc, $query);
    $row2 = mysqli_fetch_array($data);
    $sid = $row2[0];

      $query = "UPDATE shop_master set sname='$name', slocation='$location', sowner='$owner', sphone='$phone', saddress='$address', scommision='$commission', stransport='$transport' where sid=$sid";
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Error, Please try again';
      }
      else{
        echo '<p> Success, Shop Updated.</p><br />';
        echo '<a href="master_shop.php">Go back to Modify Markets</a><br />';
      }
      nysqli_close($dbc);
      exit();
    }
  else{
  echo '<p class = "error">Please fill all the fields';
  }
}

if (isset($_POST['delete'])){
  $name_fixed = mysqli_real_escape_string($dbc, trim($_POST['shopfixed']));
  $address_fixed = mysqli_real_escape_string($dbc, trim($_POST['shopfixed_addr']));
  $phone_fixed = mysqli_real_escape_string($dbc, trim($_POST['shopfixed_p']));

  $query = "SELECT sid from shop_master where sname='$name_fixed' and saddress='$address_fixed' and sphone='$phone_fixed'";
  $data = mysqli_query($dbc, $query);
  $row2 = mysqli_fetch_array($data);
  $sid = $row2[0];

      $query = "DELETE from shop_master where sid=$sid";
      $result = mysqli_query($dbc,$query);
      if(!$result){
        echo 'Error, Please try again';
      }
      else{
        echo '<p> Success, Shop Deleted.</p>';
        echo '<a href="master_shop.php">Go back to Modify Markets</a><br />';
      }
      nysqli_close($dbc);
      exit();

}

$query = "select sname from shop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$shop_options = "";
while($row = mysqli_fetch_array($data)){
  $shop_options = $shop_options."<option>$row[0]</option>";
}
$query = "select saddress from shop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$shop_options_addr = "";
while($row = mysqli_fetch_array($data)){
  $shop_options_addr = $shop_options_addr."<option>$row[0]</option>";
}
$query = "select sphone from shop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$shop_options_p = "";
while($row = mysqli_fetch_array($data)){
  $shop_options_p = $shop_options_p."<option>$row[0]</option>";
}
mysqli_close($dbc);
 ?>
</div>
   <head>
     <link rel="stylesheet" type="text/css" href="farmer_style.css">
     <title>Update Market database</title>
   </head>
   <body>
   <div class="content">
    <div class="form-style-5">

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color:black;">Insert Market</legend>

         <label for="name">Shop Name: </label>
         <input type="text" id="name" name="name" /><br />

         <label for="owner">Owner Name: </label>
         <input type="text" id="owner" name="owner" /><br />
         <label for="phone">Mobile number: </label>
         <input type="tel" pattern="[0-9]{10}" id="phone" name="phone" /><br />

         <label for="location">Location: </label>
         <input type="text" id="location" name="location" /><br />
         <label for="address">Shop Address: </label>
         <input type="text" id="address" name="address" /><br />

         <label for="commission">Shop Comission %: </label>
         <input type="text" id="commission" name="commission" /><br />
         <label for="transport">Shop Transport charge (per unit): </label>
         <input type="text" id="transport" name="transport" /><br />

       </fieldset>
       <input type="submit" name="submit" value="Add shop">

     </form>

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color:black;">Update Market</legend>

         <label for="shopfixed"> Existing shop: </label>
         <select name="shopfixed">
           <?php echo $shop_options; ?>
         </select><br />
         <label for="shopfixed_addr"> Existing shop address: </label>
         <select name="shopfixed_addr">
           <?php echo $shop_options_addr; ?>
         </select><br />
         <label for="shopfixed_p"> Existing shop Contact no.: </label>
         <select name="shopfixed_p">
           <?php echo $shop_options_p; ?>
         </select><br />
         <p style="color:black;">Updated fields</p><br />
         <label for="name">Shop Name: </label>
         <input type="text" id="name" name="name" /><br />

         <label for="owner">Owner Name: </label>
         <input type="text" id="owner" name="owner" /><br />
         <label for="phone">Mobile number: </label>
         <input type="tel" pattern="[0-9]{10}" id="phone" name="phone" /><br />

         <label for="location">Location: </label>
         <input type="text" id="location" name="location" /><br />
         <label for="address">Shop Address: </label>
         <input type="text" id="address" name="address" /><br />

         <label for="commission">Shop Comission %: </label>
         <input type="text" id="commission" name="commission" /><br />
         <label for="transport">Shop Transport charge (per unit): </label>
         <input type="text" id="transport" name="transport" /><br />

       </fieldset>
       <input type="submit" name="update" value="Update shop">

     </form>


          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
              <legend style="color:black;">Delete Market</legend>

              <label for="shopfixed"> Shop: </label>
              <select name="shopfixed">
                <?php echo $shop_options; ?>
              </select><br />
              <label for="shopfixed_addr"> Shop address: </label>
              <select name="shopfixed_addr">
                <?php echo $shop_options_addr; ?>
              </select><br />
              <label for="shopfixed_p"> Shop Contact no.: </label>
              <select name="shopfixed_p">
                <?php echo $shop_options_p; ?>
              </select><br />
            </fieldset>
            <input type="submit" name="delete" value="Delete shop">

          </form>
</div>
</div>
   </body>
 </html>
