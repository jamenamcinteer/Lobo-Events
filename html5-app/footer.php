<?php if($user){?>
<div id="nav_bottom">
<div id="nav_bottom_shadow"></div>
<div id="nav_bottom_bg">
<div class="nav_bottom_link" style="border-right:1px solid #A7A9AC;">
	<a href="index.php">
	<?php if($nav_bottom_page == 'list')echo '<img src="img/nav_bottom_list_over.png" alt="List">';else echo '<img src="img/nav_bottom_list.png" alt="List">';?>
	</a>
</div>
<div class="nav_bottom_link" style="border-right:1px solid #A7A9AC;">
	<a href="home_map.php">
	<?php if($nav_bottom_page == 'map')echo '<img src="img/nav_bottom_map_over.png" alt="Map">';else echo '<img src="img/nav_bottom_map.png" alt="Map">';?>
	</a>
</div>
<div class="nav_bottom_link">
	<a href="calendar.php">
	<?php if($nav_bottom_page == 'calendar')echo '<img src="img/nav_bottom_calendar_over.png" alt="Calendar">';else echo '<img src="img/nav_bottom_calendar.png" alt="Calendar">';?>
	</a>
</div>
</div>

</div> 
<?php }?>
    <script src="js/jquery.js"></script>   
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js?ver=1.0.4"></script>
    
    <?php if($calendar_page == 'all'){?><script type="text/javascript">
    var datesArray=[<?php include('calendar_getdates.php');?>]
    var device_id = $('#device_id').val();
	  $(function() {
	    $( "#datepicker" ).datepicker({
			 inline: true,
			 beforeShowDay: function (date) {
				var theday = (date.getMonth()+1) +'/'+ 
							date.getDate()+ '/' + 
							date.getFullYear();
					return [true,$.inArray(theday, datesArray) >=0?"specialDate":''];
				},
			onSelect: function(dateText, inst) {
			        var date = $(this).val();
			        var time = $('#time').val();
			        //$("#start").val(date + time.toString(' HH:mm').toString());
			        $('#event_info').html('<center><img src="img/334.GIF" style="padding:20px;width:45px;" alt="Loading..."></center>');

				   $.post("ajax_calendar.php", { enter_date: date, enter_device: device_id },
				   function(data) {
				     	$('#event_info').html(data);
				   	});
				   	
    				
    				}
		});
	  });
    </script><?php } ?>
   <?php if($calendar_page == 'my'){?><script type="text/javascript">
    var datesArray=[<?php include('calendar_my_getdates.php');?>]
    var device_id = $('#device_id').val();
	  $(function() {
	    $( "#datepicker" ).datepicker({
			 inline: true,
			 beforeShowDay: function (date) {
				var theday = (date.getMonth()+1) +'/'+ 
							date.getDate()+ '/' + 
							date.getFullYear();
					return [true,$.inArray(theday, datesArray) >=0?"specialDate":''];
				},
			onSelect: function(dateText, inst) {
			        var date = $(this).val();
			        var time = $('#time').val();
			        //$("#start").val(date + time.toString(' HH:mm').toString());
			        $('#event_info').html('<center><img src="img/334.GIF" style="padding:20px;width:45px;" alt="Loading"></center>');

				   $.post("ajax_calendar_my.php", { enter_date: date, enter_device: device_id },
				   function(data) {
				     	$('#event_info').html(data);
				   	});
				   	
    				
    				}
		});
	  });
    </script><?php }?>
    
    <!--<script type="text/javascript">
	var androidId = window.android.getAndroidId();
	var deviceId = window.android.getDeviceId();
	
	var elem = document.getElementById("device_id");
	elem.value = deviceId;
    </script>-->
</body>
</html>