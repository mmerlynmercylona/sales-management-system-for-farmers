<html>
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

  //echo "Welcome ".$farmer_name.;
  echo('<a href="index.php">Home </a>');
  echo '<a href="logout.php">Log Out (' . $_COOKIE['username'] . ')</a>';
}
?>
</div>
<table "table-fill" align="center">
  <thead>
    <caption style="color: white;">Reference Prices</caption>
    <tr>
      <th>Date</th>
      <th>Crop</th>
      <th>Maximum price</th>
      <th>Minimum Price</th>
      <th>Average Price</th>
    </tr>
  </thead>
  <tbody class="table-hover">

<?php
if (isset($_POST['submit'])){
  $crop = mysqli_real_escape_string($dbc, trim($_POST['crop']));
  $date = mysqli_real_escape_string($dbc, trim($_POST['date']));
  $uid = $_COOKIE['fid'];
  //echo '   '.$uid.'  ';
//DATES GIVEN 4 COMBINATIONS
}


$query = 'CALL rate_rec(?,?,@msg1, @avg1, @max1, @min1)';
$call = mysqli_prepare($dbc,$query);
mysqli_stmt_bind_param($call, 'ss',$date,$crop);
mysqli_stmt_execute($call);

$query = 'SELECT @msg1, @avg1, @max1, @min1';
$data = mysqli_query($dbc, $query) or die(mysql_error());
$row = mysqli_fetch_assoc($data);



//  echo ' '.$row['@total'] . " - " . + $row['@tcost']. " - " . + $row['@scost']. " - " . + $row['@comm']. " - " . + $row['@net'];
//echo '<br />';

$msg = $row['@msg1'] ;
//echo $msg;
//$n = $quantity/$unit;
$max = $row['@max1'];
$min = $row['@min1'];
$avg = $row['@avg1'];
//$net =$row['@net'];
echo
"<tr>
  <td>{$date}</td>
  <td>{$crop}</td>
  <td>{$max}</td>
  <td>{$min}</td>
  <td>{$avg}</td>
</tr>\n";


$query = "select cname from crop_master";
$data = mysqli_query($dbc,$query) or die(mysql_error());
$crop_options = "";
while($row = mysqli_fetch_array($data)){
  $crop_options = $crop_options."<option>$row[0]</option>";
}
mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" type="text/css" href="farmer_style.css">
    <meta charset="utf-8">
    <title>Price calculation</title>
  </head>
  <body>
    <div class="content">
    <p style="font-size:15px;">Select required filters. (For all bills leave dates empty)</p>

      <div class="form-style-5">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <fieldset>
        <legend>Recommend details</legend>

        <label for="date">Date of sale: </label>
        <input type="date" id="date" name="date" /><br />

        <label for="crop"> Crop Variety: </label>
        <select name="crop">
          <?php echo $crop_options; ?>
        </select><br />


      </fieldset>
      <input type="submit" name="submit" value="Recommend">

    </form>
  </div>
</div>


  </body>
</html>
