<?php
include('../../../../includes/global.php'); include('../../../../includes/auth.php'); 

if (!$_POST) exit;

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
	
$password = trim(str_replace("'","",str_replace('"','',$_POST['password'])));

$sql_pwd = "SELECT * FROM users WHERE user_no = '$row[user_no]' AND password = md5('$password')";
$result_pwd = mysqli_query($connect,$sql_pwd) or die("Couldn't execute query security."); 
$num_pwd = mysqli_num_rows($result_pwd); $row_pwd = mysqli_fetch_assoc($result_pwd);

if (trim($password) == '') {
	echo '<div class="error_message">Attention! Please enter your password</div>';
	exit();
} elseif ($num_pwd == 0) { // current password is not correct
	echo '<div class="error_message">Attention! Password is incorrect</div>';
	exit();
} 

// Phone verification, do not edit.
function isPhone($phone) {
    return(preg_match("/^\+([0-9]{1,4})\)?[-. ]?([0-9]{10})$/", $phone));
}

$first_name = trim(addslashes($_POST['first_name']));
$last_name = trim(addslashes($_POST['last_name']));
$phone = trim($_POST['phone']);

if (trim($first_name) == '') {
	echo '<div class="error_message">Attention! Please enter your first name</div>';
	exit();
} elseif (trim($last_name) == '') {
	echo '<div class="error_message">Attention! Please enter your last name</div>';
	exit();
} elseif (trim($phone) == '') {
	echo '<div class="error_message">Attention! Please enter your phone number</div>';
	exit();
} elseif (trim($phone) != '' && !isPhone($phone)) {
    echo '<div class="error_message">Attention! You have entered an invalid mobile phone number. Example is +2348102112212</div>';
    exit();
}

// Update User details
$UpdateRecords_info = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', phone = '$phone', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE user_no = '$row[user_no]'";
$Update_info = mysqli_query($connect,$UpdateRecords_info) or die("Couldn't execute update user information");

// Add log to Activities Table
$description = $row['first_name'] . " " . $row['last_name'] . " updated profile information";
$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
					 
/* Success feedback */
echo "<fieldset>";
echo "<div id='success_page'>";
echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> You have successful updated your information.</span></div></div>";
echo "</div>";
echo "</fieldset>";

?>