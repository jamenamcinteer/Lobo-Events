<?php
/*unset($_COOKIE['auth_user']);
setcookie('auth_user', null, -1, '/');*/
            
if($_GET['cmd'] == 'NOAUTH'){setcookie("auth_user",'NONE');header("Location:index.php");}
if($_GET['cmd'] == 'REGNOW'){unset($_COOKIE['auth_user']);setcookie('auth_user', null, -1, '/');}?>
<?php
include('connect.php');
function db_clean($string){//SANITIZE DATA FOR DB
	$string = trim($string);
	$string = stripslashes($string);
	$string = mysql_real_escape_string($string);
	return $string;
}

if(isset($_POST['submitLogin'])){
$reg_id = $_COOKIE['reg_id'];
$app_ver = $_COOKIE['app_ver'];

	$email = db_clean($_POST['email']);
	$password = db_clean($_POST['password']);
	$device_name = db_clean($_POST['device_name']);
	$device_version = db_clean($_POST['device_version']);
	
	$error;
	
	if(!$email || !$password){$error = 'Please fill out all fields.';}
	if($device_version != '' && $device_name == ''){$error = 'Please fill out all fields.';}
	
	if(!$error){
	$result = mysql_query("SELECT id, email, password FROM users WHERE email = '$email' LIMIT 1");
	while ($row = mysql_fetch_assoc($result)) {
	$user_id = $row['id'];
	    if($row['password'] != $password){$error = 'Wrong password.';}
	    if($row['password'] == $password){
	    	setcookie("auth_user",$email);
	    	if($device_name){
	    	$insert = mysql_query("INSERT INTO user_devices (reg_id, device_name, device_version, user_id, app_version) VALUES ('$reg_id','$device_name','$device_version','$user_id','$app_ver')");
	    	}
	    }
	}
	if(!$user_id){
	$insert = mysql_query("INSERT INTO users (email, password) VALUES ('$email','$password')");
	setcookie("auth_user",$email);
		if($device_name){
			$resultB = mysql_query("SELECT id FROM users WHERE email = '$email' ORDER BY id DESC LIMIT 1");
			if($resultB){
			while ($rowB = mysql_fetch_assoc($resultB)) {
			$user_id = $rowB['id'];
			$device_version = 'Android ' . $device_version;
			$insert = mysql_query("INSERT INTO user_devices (reg_id, device_name, device_version, user_id, app_version) VALUES ('$reg_id','$device_name','$device_version','$user_id','$app_ver')");
			}
			}
		}
	}
	}
	if(!$error){$user = $email;header("Location:index.php");}
}
?>