<?php include('header.php');?>
<?php $filter_time = $_GET['filter_time'];if($filter_time == '')$filter_time = 'NEXT 3 DAYS AT UNM';?>


<div id="nav_top">
<img src="img/icon_45px.png" id="site_icon" alt="Lobo Events">
<div class="dropdown">
<span id="dropdownMenu1" data-toggle="dropdown">
    <?php echo $filter_time;?> &#9660;</span>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="min-width:250px;right:40%;">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=NEXT%203%20DAYS%20AT%20UNM">Next 3 Days</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=THIS%20WEEK%20AT%20UNM">This Week</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=THIS%20MONTH%20AT%20UNM">This Month</a></li>
    <!--<li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?filter_time=ALL%20EVENTS%20AT%20UNM">All Events</a></li>-->
  </ul>
</div>
<div id="dropdown-wide">
<h2><?php echo $filter_time;?></h2>
&#9660;
  <ul>
    <li><a href="home_map.php?filter_time=NEXT%203%20DAYS%20AT%20UNM">Next 3 Days</a></li>
    <li><a href="home_map.php?filter_time=THIS%20WEEK%20AT%20UNM">This Week</a></li>
    <li><a href="home_map.php?filter_time=THIS%20MONTH%20AT%20UNM">This Month</a></li>
    <!--<li><a href="home_map.php?filter_time=ALL%20EVENTS%20AT%20UNM">All Events</a></li>-->
  </ul>
</div>

</div><!-- #nav_top -->

<?php include('map_directions.php');?>

<?php include('footer.php');?>