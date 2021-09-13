<?php
include('../includes/global.php');

if(!$connect) {

	echo '<div class="error_message">Please import the brave_database.sql file into your mysql database engine</div>';
	exit();

}

if (!$_POST) exit();
	
if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
	
$login = $_POST['email']; $find = '@';
$password = trim(str_replace("'","",str_replace('"','',$_POST['password'])));

if (trim($login) == '') {

	echo '<div class="error_message">Attention! Please enter your email address</div>';
	exit();

}	

function iscontain($login,$find) { 

	$check = strpos($login, $find); 
	if ($check === false) { return 0; } else { return 1; } 

} 
	
if(iscontain($login,$find)) { 

	// Email address verification
	function isEmail($login) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $login));
	}
	
	if (!isEmail($login)) {
		echo '<div class="error_message">Attention! Please enter a valid email address</div>';
		exit();
	} 
	
	$sql_email = "SELECT email FROM users WHERE email = '$login'"; 
	$result_email = mysqli_query($connect,$sql_email) or die("Couldn't execute query email."); 
	$num_email = mysqli_num_rows($result_email); 
	
	if ($num_email == 0)  // email was not found 
	{
		
		echo '<div class="error_message">Attention! Email address was not found. Contact the school admin to create an account.</div>';
		exit();
		
	} 
	
	else // email was found
	
	{ 
	
		if (trim($password) == '') {

			echo '<div class="error_message">Attention! Please enter your password</div>';
			exit();

		}
	
		$sql_pwd = "SELECT * FROM users WHERE email = '$login' AND password = md5('$password')";
		$result_pwd = mysqli_query($connect,$sql_pwd) or die("Couldn't execute query password."); 
		$num_pwd = mysqli_num_rows($result_pwd); $row_pwd = mysqli_fetch_assoc($result_pwd);
		
		if ($num_pwd == 0) { // password is not correct

			echo '<div class="error_message">Attention! Password is incorrect</div>';
			exit();

		}
	
	}	

} 

else {
	
	echo '<div class="error_message">Attention! Please enter a valid email address</div>';
	exit();
	
}  // End (iscontain($email,$find)
					 
$user_no = $row_pwd['user_no'];

if ($row_pwd['status'] == '0') {
	
	echo '<div class="error_message">Attention! Your account is not active. Contact the school admin to activate your account</div>';
	
	// Add log to Activities Table
	$description = $row_pwd['first_name'] . " " . $row_pwd['last_name'] . " tried signing in while account is not active";
	
	$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$user_no','$ip','$host','$dateposted')";
	$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
	
	exit();
	
} elseif ($row_pwd['status'] == '1') {
	
	echo '<div class="error_message">Attention! Your account has been disabled.</div>';
	
	// Add log to Activities Table
	$description = $row_pwd['first_name'] . " " . $row_pwd['last_name'] . " tried signing in while account is disabled";

	$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$user_no','$ip','$host','$dateposted')";
	$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
	
	exit();
		
}

// Record logins
	
$sql_check_log = "SELECT user_no, lastlogin_time FROM user_login WHERE user_no = '$row_pwd[user_no]'";
$result_check_log = mysqli_query($connect,$sql_check_log) or die("Couldn't execute query check log.");
$row_check_log = mysqli_fetch_assoc($result_check_log); $num_check_log = mysqli_num_rows($result_check_log);

if ($num_check_log == 1)
{
	$_SESSION['lastlogin_time'] = $row_check_log['lastlogin_time'];

	$UpdateRecords_log = "UPDATE user_login SET lastlogin_time = '$dateposted', login_count = login_count + 1, ip = '$ip', host = '$host' WHERE user_no = '$row_pwd[user_no]'";
	$Update_log = mysqli_query($connect,$UpdateRecords_log) or die("Couldn't execute update query login.");
	
	$description = $row_pwd['first_name'] . " " . $row_pwd['last_name'] . " signed in from " . $host;
	
}

elseif ($num_check_log == 0)

{
	
	$sql_log = "INSERT INTO user_login (user_no,lastlogin_time,login_count,ip,host) VALUES ('$row_pwd[user_no]','$dateposted','1','$ip','$host')";
	$result_log = mysqli_query($connect,$sql_log) or die("Couldn't execute insert query login.");
	
	$description = $row_pwd['first_name'] . " " . $row_pwd['last_name'] . " signed in for the first time from " . $host;
	
}

$sql_log_time = "INSERT INTO user_logintimes (user_no,login_time,ip,host) VALUES ('$row_pwd[user_no]','$dateposted','$ip','$host')";
$reslt_log_time = mysqli_query($connect,$sql_log_time) or die("Couldn't execute query login time.");
					 
$_SESSION['user_no'] = $user_no;
if(isset($_POST['pag'])) { $_SESSION['pag'] = $_POST['pag']; }
$_SESSION['authenticate'] = "users";

// Update user table
$UpdateRecords = "UPDATE users SET online = '1' WHERE user_no = '$user_no'";
$Update = mysqli_query($connect,$UpdateRecords) or die("Couldn't execute update query online.");

// Add log to Activities Table
$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$user_no','$ip','$host','$dateposted')";
$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
					 
/* Success feedback */
echo "<fieldset>";
echo "<div id='success_page'>";
echo "<p><strong>Sign in successful!</strong> Redirecting...</p>";
echo "</div>";
echo "</fieldset>";

?>