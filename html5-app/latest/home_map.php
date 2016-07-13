<?php include('login_process.php');?>
<?php include('header.php');?>

<?php if(!$user){?>
<?php include('login.php');?>
<?php }?>


<?php if($user){?>


<div id="nav_top">
<img src="img/icon_45px.png" id="site_icon" alt="Lobo Events">
<?php if($user){?><a href="settings.php"><img src="img/icon_settings.png" id="settings_icon" alt="Settings"></a><?php }?>
<div class="dropdown">
<span id="dropdownMenu1" data-toggle="dropdown">
    TODAY AT UNM</span>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="min-width:250px;right:40%;">
    <!--<li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=NEXT%203%20DAYS%20AT%20UNM">Next 3 Days</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=THIS%20WEEK%20AT%20UNM">This Week</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=THIS%20MONTH%20AT%20UNM">This Month</a></li>-->
    <!--<li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=ALL%20EVENTS%20AT%20UNM">All Events</a></li>-->
  </ul>
</div>
<div id="dropdown-wide">
<h2>TODAY AT UNM</h2>
  <ul>
    <!--<li><a href="home_map.php?filter_time=NEXT%203%20DAYS%20AT%20UNM">Next 3 Days</a></li>
    <li><a href="home_map.php?filter_time=THIS%20WEEK%20AT%20UNM">This Week</a></li>
    <li><a href="home_map.php?filter_time=THIS%20MONTH%20AT%20UNM">This Month</a></li>-->
    <!--<li><a href="home_map.php?filter_time=ALL%20EVENTS%20AT%20UNM">All Events</a></li>-->
    <?php if($user){?><li><a href="settings.php"><br>My Settings</a></li><?php }?>
  </ul>
</div>

</div><!-- #nav_top -->

<?php include('map.php');?>
<?php }?>
<?php include('footer.php');?>