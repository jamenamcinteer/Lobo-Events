$(window).load(function() {
	$(".loader").fadeOut("slow");
});

$(document).ready(function() {
	$('.dropdown-toggle').dropdown();
	$('#mobile').keyup(function () {     
	  this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	$(function() {
	    $( "#datepicker, #dateFrom, #dateTo" ).datepicker();
	  });
	
	
	
	//AFTER SUBMIT, CHECK THAT FIELDS ARE FILLED OUT
	$("#form_login").submit(function(){		
		var valid = 0;
		
		$('#email').css('border-color','#CCC');
		$('#password').css('border-color','#CCC');
		$('#device_version').css('border-color','#CCC');
				
		//ALL FIELDS MUST BE FILLED OUT
		var email = $.trim($('#email').val());
		var password = $.trim($('#password').val());
		var device_name = $.trim($('#device_name').val());
		var device_version = $.trim($('#device_version').val());
		
		if(email == ''){valid = 1;$('#email').css('border-color','red');}
		if(password == ''){valid = 2;$('#password').css('border-color','red');}
		if(device_version != '' && device_name == ''){valid = 3;$('#device_name').css('border-color','red');}
		
		var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
 		var validEmail = emailRegex.test(email);
		if (!validEmail) {valid = 4;} 
		
	   
	   
	   if(valid > 0){$("html, body").animate({ scrollTop: 0 }, "slow");$('#blank_fields').show('slow','swing');return false;}

		if(valid <= 0){
			var formElems = document.getElementsByTagName('INPUT');
			for (var i = 0; i , formElems.length; i++)
			{  
			   if (formElems[i].type == 'checkbox')
			   { 
				  formElems[i].disabled = false;
			   }
			}
			return true;
			}
			
   		});
  
});

function getAndroidVersion(ua) {
    var ua = ua || navigator.userAgent; 
    var match = ua.match(/Android\s([0-9\.]*)/);
    return match ? match[1] : false;
};


var androidVersion = getAndroidVersion();
	
	var elem = document.getElementById("device_version");
	elem.value = androidVersion;