
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
<?php
if (isset($_POST['submit'])){
  //$billno = mysqli_real_escape_string($dbc, trim($_POST['billno']));
  $bdate_f = mysqli_real_escape_string($dbc, trim($_POST['bdate_f']));
  $bdate_t = mysqli_real_escape_string($dbc, trim($_POST['bdate_t']));
  $crop = mysqli_real_escape_string($dbc, trim($_POST['crop']));
  $shop = mysqli_real_escape_string($dbc, trim($_POST['shop']));
  $uid = $_COOKIE['fid'];
  //echo '   '.$uid.'  ';
//DATES GIVEN 4 COMBINATIONS
  if(!empty($bdate_f)&&(!empty($bdate_t))){
    if (($crop=="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale between '$bdate_f' and '$bdate_t' and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all';
    }
    elseif(($shop !="Alls")&&($crop=="Allc")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from   produce_register p, sales_register b, crop_master c, shop_master s where  p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale between   '$bdate_f' and '$bdate_t' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all crop';
    }
    elseif(($crop !="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale between '$bdate_f' and '$bdate_t' and cname='$crop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all shop';
    }
    elseif(($crop !="Allc")&&($shop!="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale between '$bdate_f' and '$bdate_t' and cname='$crop' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo ' in selected ';
    }
  }
//DATES NOT GIVEN 4 COMBINATIONS
  elseif(empty($bdate_f)&&(empty($bdate_t))){
    if (($crop=="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all';
    }
    elseif(($shop !="Alls")&&($crop=="Allc")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from   produce_register p, sales_register b, crop_master c, shop_master s where  p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all crop';
    }
    elseif(($crop !="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and cname='$crop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all shop';
    }
    elseif(($crop !="Allc")&&($shop!="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and cname='$crop' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo ' in selected ';
    }
  }
//ONLY FROM DATE GIVEN
  elseif(!empty($bdate_f)&&(empty($bdate_t))){
    if (($crop=="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale >='$bdate_f' and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all';
    }
    elseif(($shop !="Alls")&&($crop=="Allc")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from   produce_register p, sales_register b, crop_master c, shop_master s where  p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale >='$bdate_f' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all crop';
    }
    elseif(($crop !="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale >='$bdate_f' and cname='$crop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all shop';
    }
    elseif(($crop !="Allc")&&($shop!="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale >='$bdate_f' and cname='$crop' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo ' in selected ';
    }
  }
//ONLY TO DATE GIVEN
//ONLY FROM DATE GIVEN
  elseif(empty($bdate_f)&&(!empty($bdate_t))){
    if (($crop=="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale <='$bdate_t' and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all';
    }
    elseif(($shop !="Alls")&&($crop=="Allc")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from   produce_register p, sales_register b, crop_master c, shop_master s where  p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale <='$bdate_t' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all crop';
    }
    elseif(($crop !="Allc")&&($shop=="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale <='$bdate_t' and cname='$crop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo 'in all shop';
    }
    elseif(($crop !="Allc")&&($shop!="Alls")){
      $query = "SELECT p.quantity, b.rate, c.cname, s.sname, date_sale from produce_register p, sales_register b, crop_master c, shop_master s where p.pid=b.s_pid and c.cid=p.p_cid and s_sid=s.sid and date_sale <='$bdate_t' and cname='$crop' and sname='$shop'and p.p_fid='$uid'";
      $data = mysqli_query($dbc,$query) or die(mysql_error());
      //echo ' in selected ';
    }
  }


}
?>
<table "table-fill">
  <thead>
    <caption style="color: white;">Bill summary</caption>
    <tr>
      <th>Bill date</th>
      <th>Crop</th>
      <th>Shop</th>
      <th>Quantity(kg)</th>
      <th>Rate(per kg)</th>
      <th>Total</th>
      <th>Unit(kg)</th>
      <th>Transport Charges</th>
      <th>Shop Comission</th>
      <th>Total Comission</th>
      <th>NET</th>
    </tr>
  </thead>
  <tbody class="table-hover">
    <?php
      $data_points = array();
      $dp = array();
      $array_crop = array();
      $array_rate = array();
      while($row = mysqli_fetch_array($data))
        $rows[] = $row;
      foreach ($rows as $row) {
  //while($row = mysqli_fetch_array($data)){

        $quantity = (float) $row[0];
        $rate = (float) $row[1];
        $d_shop = $row[3];
        $d_crop = $row[2];
        $d_date = $row[4];
        //echo '  '.$d_shop;

        $query = "SELECT cunitquantity from units_master where uid in (select cunitid from crop_master where cname='$d_crop')";
        $data = mysqli_query($dbc,$query) or die(mysql_error());
        $row = mysqli_fetch_array($data);
        $unit = (float) $row["cunitquantity"];

        $query = "SELECT stransport, scommision from shop_master where   sname='$d_shop'";
        $data = mysqli_query($dbc,$query) or die(mysql_error());
        $row = mysqli_fetch_array($data);
        $tcost_unit = (float) $row["stransport"];
        $scomm_p = (float) $row["scommision"];

    //echo 'Harvested quantity is '.$quantity.'<br/>';
    //echo 'Price per kg is '.$rate.'<br/>';
    //echo '1 unit consists of is '.$unit.'<br/>';
    //echo 'Transport cost per unit is '.$tcost_unit.'<br/>';
    //echo 'Commission percentage '.$scomm_p.'<br/>';
    //echo 'Total income '.$quantity*$rate.'<br/>';

        //$query = "CALL price($quantity,$rate, $scomm_p,$tcost_unit,$unit, @total, @tcost, @scost, @comm, @net)";
        $query = 'CALL price(?,?,?,?,?, @total, @tcost, @scost, @comm, @net)';
        $call = mysqli_prepare($dbc,$query);
        mysqli_stmt_bind_param($call, 'iiiii',$quantity,$rate, $scomm_p,$tcost_unit,$unit);
        mysqli_stmt_execute($call);

        $query = 'SELECT @total, @tcost, @scost, @comm, @net';
        $data = mysqli_query($dbc, $query) or die(mysql_error());
        $row = mysqli_fetch_assoc($data);



      //  echo ' '.$row['@total'] . " - " . + $row['@tcost']. " - " . + $row['@scost']. " - " . + $row['@comm']. " - " . + $row['@net'];
        //echo '<br />';

        $total = $row['@total'] ;
        //$n = $quantity/$unit;
        $tcost = $row['@tcost'];
        $scost = $row['@scost'];
        $comm = $row['@comm'];
        $net =$row['@net'];

        //$total = (float) $quantity*$rate;
        //$n = $quantity/$unit;
        //$tcost = $n*$tcost_unit;
        //$scost = $scomm_p*$total*0.01;
        //$comm = $scost+$tcost;
        //$net =$total-$comm;
        //$point = array("y" => $net, "label" => $d_crop);
        array_push($data_points, array($d_crop,$rate));
        $values = array ($d_crop => $net);
        array_push($dp,$values);

        $ac = $d_crop;
        array_push($array_crop,$ac);
        $ar = $rate;
        array_push($array_rate,$ar);

        //echo ' '.$dataPoints.' '.+$point.'---';


        echo
        "<tr>
          <td>{$d_date}</td>
          <td>{$d_crop}</td>
          <td>{$d_shop}</td>
          <td>{$quantity}</td>
          <td>{$rate}</td>
          <td>{$total}</td>
          <td>{$unit}</td>
          <td>{$tcost}</td>
          <td>{$scost}</td>
          <td>{$comm}</td>
          <td>{$net}</td>
        </tr>\n";

  }

//echo json_encode($data_points, JSON_NUMERIC_CHECK);

//echo $data_points;
////for ($i=0; $i <count($dp) ; $i++) {
  // code...
  ////echo $data_points[$i][0];
  ////echo "<br />";
  ////echo $data_points[$i][1];
  //foreach($dp[$i] as $key => $value)
  //{
  //  echo $key." has the value". $value;
  //}
//}

//for ($i=0; $i <count($array_crop) ; $i++) {
  // code...

//foreach($array_crop[$i] as $value){
//    echo $value . "[crop]<br>";
//}
//foreach($array_rate[$i] as $value){
//    echo $value . "[rate]<br>";
//}}

//echo $dp[0][1];
//echo $dp[1][1];
//echo json_encode($dp);

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
        <legend>Bill details</legend>

        <label for="bdate_f">Date on bill (From): </label>
        <input type="date" id="bdate_f" name="bdate_f" /><br />
        <label for="bdate_t">Date on bill (To): </label>
        <input type="date" id="bdate_t" name="bdate_t" /><br />

        <label for="crop"> Crop Variety: </label>
        <select name="crop">
          <option value="Allc">All</option>
          <?php echo $crop_options; ?>
        </select><br />

        <label for="shop"> Shop name: </label>
        <select name="shop">
          <option value="Alls">All</option>
          <?php echo $shop_options; ?>
        </select><br />


      </fieldset>
      <input type="submit" name="submit" value="Calculate">

    </form>
  </div>
</div>


  </body>
</html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="chart.js"></script>
  </head>
  <body>
    <canvas id="myChart" width="200" height="200" style="backgroundColor = #e6fff9;"></canvas>
    <script type="text/javascript">
      Chart.defaults.global.defaultFontColor = 'white';
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
          labels: <?php echo json_encode($array_crop); ?> ,
          xAxisID: "Crop Variety",
          yAxisID: "Rate per kg (Rs.)",
          datasets: [{
              categoryPercentage: 0.5,
              barPercentage: 0.5,
              barThickness: 8,


              label: 'Crop price',
              backgroundColor: 'rgb(5,143,3)',
              borderColor: 'rgb(140, 3, 17)',
              data: <?php echo json_encode($array_rate); ?>
            }]
          },


          // Configuration options go here
          options: {
            responsive: true,
            chartArea: {
        backgroundColor: 'rgb(10,10,10)'
    },
            maintainAspectRatio: false,
            title: {
              display: true,
              text: 'Comparing prices of crops sold'
            },
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
          }
        }
        });

    </script>

  </body>
</html>
