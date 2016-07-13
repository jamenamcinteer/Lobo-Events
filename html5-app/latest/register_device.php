<?php
include('connect.php');
$device_id ="'".$_REQUEST['device_id']."'";
$reg_id ="'".$_REQUEST['reg_id']."'";
$q = "insert into gcm(device_id,reg_id) values($device_id,$reg_id)";
$execute=mysql_query($q);
?>