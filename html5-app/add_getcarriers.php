<?php
include('connect.php');


$display_carriers;
$result = mysql_query("SELECT * FROM gateway ORDER BY carrier ASC");
while($row = mysql_fetch_array($result)){


//echo $startdate1;
$db_carrier = $row['carrier'];
$display_carriers .= '"' . $db_carrier . '",';

//'12/27/2013',

echo "<option value='$db_carrier'>$db_carrier</option>";


}
$display_carriers = substr($display_carriers, 0, -1);
//echo $display_carriers;
?>