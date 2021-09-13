<?php
include('../../../../includes/global.php'); include('../../../../includes/auth.php'); 

if (!$_POST) exit();
	
if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
	
$opassword = trim(str_replace("'","",str_replace('"','',$_POST['opassword'])));
$password =  trim(str_replace("'","",str_replace('"','',$_POST['password'])));
$cpassword =  trim(str_replace("'","",str_replace('"','',$_POST['cpassword'])));

$sql_pwd = "SELECT * FROM users WHERE user_no = '$row[user_no]' AND password = md5('$opassword')";
$result_pwd = mysqli_query($connect,$sql_pwd) or die("Couldn't execute query password."); 
$num_pwd = mysqli_num_rows($result_pwd); $row_pwd = mysqli_fetch_assoc($result_pwd);

if (trim($opassword) == '') {
	echo '<div class="error_message">Attention! Please enter your current password</div>';
	exit();
} elseif ($num_pwd == 0) { // current password is not correct
	echo '<div class="error_message">Attention! Current password is incorrect</div>';
	exit();
} elseif (trim($password) == '') {
	echo '<div class="error_message">Attention! Please enter your new password</div>';
	exit();
} elseif (trim($password) != trim($cpassword)) {
	echo '<div class="error_message">Attention! Your new password does not match</div>';
	exit();
}

$pwd =	md5($password);

$UpdateRecords_pwd = "UPDATE users SET password = '$pwd', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE user_no = '$row[user_no]'";
$Update_pwd = mysqli_query($connect,$UpdateRecords_pwd) or die("Couldn't execute update query password.");

// Add log to Activities Table
$description = $row['first_name'] . " " . $row['last_name'] . " just updated password";
$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
					 
/* Success feedback */
echo "<fieldset>";
echo "<div id='success_page'>";
echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> You have successful changed your user password.</span></div></div>";
echo "</div>";
echo "</fieldset>";
?>