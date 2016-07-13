<?php 
include('connect.php');

$regid = $_GET['regid'];
if($regid != ''){setcookie("reg_id",$regid);}

$reg_id = $_COOKIE['reg_id'];
$cookie_id = $_COOKIE['cookie_id'];

$appver = $_GET['ver'];
if($appver != ''){setcookie("app_ver",$appver);}

$app_ver = $_COOKIE['app_ver'];


//CHECK FOR UNIQUE ID STORED IN COOKIE, OR FOR UNIQUE DEVICE ID AS GIVEN BY JAVASCRIPT (BELOW); ONE OF THESE WILL BE STORED IN THE DATABASE TO IDENTIFY THE CALENDAR (DEVICE ID HAS PRIORITY)
if(!$cookie_id && !$reg_id){
//CREATE THE COOKIE WITH UNIQUE, RANDOM ID
//SET $COOKIE_ID VARIABLE

$new_cookie_id = md5(uniqid(rand(), true));
setcookie("cookie_id",$new_cookie_id);
$cookie_id = $new_cookie_id;
}

$user = $_COOKIE['auth_user'];
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Lobo Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">-->
    <meta charset="utf-8">
    <!--<link href='http://fonts.googleapis.com/css?family=Muli:400,400italic' rel='stylesheet' type='text/css'>-->
    <link href='css/fonts.css' rel='stylesheet' type='text/css'>
    <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css">
    <!--<link rel="stylesheet" href="css/jquery-ui.css">-->
    <link href="css/style.css?ver=1.0.13" rel="stylesheet" media="screen">

<meta property="fb:app_id" content="{661878797165543}">
<meta property="fb:admins" content="{ndjamena.marmon}"/>
<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<link href="/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>


<?php $eventid = $_GET['id'];
$event_id = $eventid;?>
<div class="loader"></div>