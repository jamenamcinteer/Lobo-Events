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
    MY EVENTS &#9660;</span>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="min-width:250px;right:40%;">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="calendar.php">All Events</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="calendar_my.php">My Events</a></li>
  </ul>
</div>
<div id="dropdown-wide">
<h2>MY EVENTS</h2>
&#9660;
  <ul>
    <li><a href="calendar.php">All Events</a></li>
    <li><a href="calendar_my.php">My Events</a></li>
    <?php if($user){?><li><a href="settings.php"><br>My Settings</a></li><?php }?>
  </ul>
</div>

</div><!-- #nav_top -->

<div id="content" style="margin-top:45px;">


<div style="margin-top:-10px;padding:20px;padding-bottom:120px;">
<h1>My Calendar of Saved Dates</h1>
<?php if($user == 'NONE'){?><div class="nonandroid">This feature is disabled for non-registered users. Would you like to <a href="index.php?cmd=REGNOW">register now</a> (cookies must be enabled)?</div><?php }?>
<style type="text/css">
.ui-datepicker {
	width:100% !important;
}
</style>
  <div id="datepicker"></div>
  <div id="event_info"></div>
  <input type="hidden" name="device_id" id="device_id">
</div>  
  

  
  
  
</div>

<?php $nav_bottom_page = 'calendar';$calendar_page = 'my';?>
<?php }?>
<?php include('footer.php')?>