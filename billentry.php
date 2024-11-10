<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <link rel="stylesheet" type="text/css" href="farmer_style.css">
<?php
require_once('connectvaes.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<div class="topnav">
<?php
if (!isset($_COOKIE['fid'])){
  echo '<p class="login"> Please <a href="login.php">log in</a> to access this page';}
else{
  $query = "select fname from farmer_register where fid='" . $_COOKIE['fid'] ."'";
  $data = mysqli_query($dbc,$query) or die(mysql_error());
  $row = mysqli_fetch_array($data);
  $farmer_name = $row[0];
  echo('<p><a href="index.php">Home</a></p>');
  echo '<a href="logout.php">Log Out (' . $_COOKIE['username'] . ')</a>';
  //echo '<p>"Welcome ".$farmer_name.</p>';
}
?>
</div>
<div class="content">
<?php

if (isset($_POST['submit'])){
  $crop = mysqli_real_escape_string($dbc, trim($_POST['crop']));
  $shop = mysqli_real_escape_string($dbc, trim($_POST['shop']));
  $hdate = mysqli_real_escape_string($dbc, trim($_POST['hdate']));
  $sdate = mysqli_real_escape_string($dbc, trim($_POST['sdate']));
  $bdate = mysqli_real_escape_string($dbc, trim($_POST['bdate']));
  $quantity = mysqli_real_escape_string($dbc, trim($_POST['quantity']));
  $rate = mysqli_real_escape_string($dbc, trim($_POST['rate']));

  if((!empty($crop))&&(!empty($shop))&&(!empty($bdate))&&(!empty($rate))&&(!empty($hdate))&&(!empty($quantity))&&(!empty($sdate))){
    $query = "SELECT cid from crop_master where cname='$crop'";
    $data = mysqli_query($dbc,$query) or die(mysql_error());
    $row = mysqli_fetch_array($data);
    $cid = $row["cid"];
    $query = "INSERT into produce_register (p_fid, p_cid, date_harvested, quantity, date_shipped) values('" . $_COOKIE['fid'] ."','$cid','$hdate','$quantity','$sdate')";
    mysqli_query($dbc,$query) or die(mysql_error());


    $query = "SELECT pid from produce_register where p_fid='". $_COOKIE['fid'] ."' and p_cid='$cid' and date_harvested='$hdate' and quantity='$quantity' and date_shipped='$sdate'";
    $data = mysqli_query($dbc,$query) or die(mysql_error());
    $row = mysqli_fetch_array($data);
    $pid = $row["pid"];

    $query = "SELECT sid from shop_master where sname='$shop'";
    $data = mysqli_query($dbc,$query) or die(mysql_error());
    $row = mysqli_fetch_array($data);
    $sid = $row["sid"];

    $query = "INSERT into sales_register (s_pid, s_sid, date_sale, rate) values('$pid','$sid','$bdate','$rate')";
    mysqli_query($dbc,$query) or die(mysql_error());
    echo '<p> Success, Your bill details is entered. <a href="price.php">Check amount earned</a>.</p>';

    $query = "SELECT max(rate),avg(rate) FROM sales_register where MONTH(date_sale) = MONTH('$bdate') and  YEAR(date_sale)<2020 and s_pid in (select pid from produce_register where p_cid='$cid' and p_fid='". $_COOKIE['fid'] ."')";
    $data = mysqli_query($dbc,$query) or die(mysql_error());
    $row = mysqli_fetch_array($data);
    //'<p>"Welcome ".$farmer_name.</p>';
    $mp = $row[0];
    $ap = $row[1];
    //echo $row["max(rate)"];
    echo "Average price of this crop last year at this month is: ".$ap;
    echo "<br />";
    echo "Maximum price of this crop last year at this month is: ".$mp;
  }
  else {
    echo '<p> Please fill all details </p>';
  }

}

$query = "select sname from shop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$shop_options = "";
while($row = mysqli_fetch_array($data)){
  $shop_options = $shop_options."<option>$row[0]</option>";
}

$query = "select cname from crop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$crop_options = "";
while($row = mysqli_fetch_array($data)){
  $crop_options = $crop_options."<option>$row[0]</option>";
}


mysqli_close($dbc);
 ?>
</div>




     <meta charset="utf-8">
     <title>Bill entry</title>
   </head>
   <body>
       <div class="content">
         <div class="form-style-5">
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <fieldset>
         <legend style="color: black;">Enter bill details</legend>
         <label for="shop"> Shop name: </label>
         <select name="shop">
           <?php echo $shop_options; ?>
         </select><br />

         <label for="crop"> Crop Variety: </label>
         <select name="crop">
           <?php echo $crop_options; ?>
         </select><br />

         <label for="hdate">Date of Harvest: </label>
         <input type="date" id="hdate" name="hdate" /><br />
         <label for="sdate">Date of shipment: </label>
         <input type="date" id="sdate" name="sdate" /><br />
         <label for="bdate">Date on bill: </label>
         <input type="date" id="bdate" name="bdate" /><br />

         <label for="quantity">Quantity (In Kg): </label>
         <input type="text" id="quantity" name="quantity" /><br />
         <label for="rate">Rate (INR): </label>
         <input type="text" id="rate" name="rate" /><br />




       </fieldset>
       <input type="submit" name="submit" value="Submit bill">

     </form>
   </div>
   </div>
   </body>
 </html>
