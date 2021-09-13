<?php
include('../includes/global.php');

// Update user table
$UpdateRecords = "UPDATE users SET online = '0' WHERE user_no = '$row[user_no]'";
$Update = mysqli_query($connect,$UpdateRecords) or die("Couldn't execute update query offline.");

// Add log to Activities Table
$description = $row['first_name'] . " " . $row['last_name'] . " signed out from " . $host;
	
$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");

unset($_SESSION['authenticate']);
unset($_SESSION['user_no']);
unset($_SESSION['lastlogin_time']);
unset($_SESSION['last_alert']);
unset($_SESSION['red']);

$_SESSION['msg'] = "You have successfully Signed Out!";

header("Location: $server");
exit();

?>