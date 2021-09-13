<?php
session_start();

ob_start();

error_reporting(0);

include('db.php');

$pos1 = strpos($_SERVER['HTTP_USER_AGENT'], '(')+1;
$pos2 = strpos($_SERVER['HTTP_USER_AGENT'], ')')-$pos1;

$ip = $_SERVER['REMOTE_ADDR'];
$host = substr($_SERVER['HTTP_USER_AGENT'], $pos1, $pos2);

$currentFile = $_SERVER["PHP_SELF"];

$parts = Explode('/', $currentFile);
$filename1 = $parts[count($parts) - 1];
$filename2 = $parts[count($parts) - 2];

if(isset($parts[count($parts) - 3])) {

	$filename3 = $parts[count($parts) - 3];

}

if(isset($parts[count($parts) - 4])) {

	$filename4 = $parts[count($parts) - 4];

}

if(isset($_SESSION['authenticate'])) {
	
	$sql = "SELECT * FROM users WHERE user_no = '$_SESSION[user_no]'";
	$result = mysqli_query($connect,$sql) or die("Couldn't execute query user.");
	$row = mysqli_fetch_assoc($result);
		
}

?>
