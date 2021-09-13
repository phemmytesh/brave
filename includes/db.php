<?php

if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {	// Localhost

	$server = "http://" . $_SERVER['HTTP_HOST'] . "/brave";

	$dateposted = date("Y-m-d H:i:s");

	$username = "brave";
	$database = "brave_database";
	$password = "0000";

} elseif($_SERVER['HTTP_HOST'] == 'femi') {	// Local windows remote

	$server = "http://" . $_SERVER['HTTP_HOST'] . "/brave";

	$dateposted = date("Y-m-d H:i:s");

	$username = "brave";
	$database = "brave_database";
	$password = "0000";

} elseif($_SERVER['HTTP_HOST'] == '192.168.1.3') {	// local mac remote

	$server = "http://" . $_SERVER['HTTP_HOST'] . "/brave";

	$dateposted = date("Y-m-d H:i:s");

	$username = "brave";
	$database = "brave_database";
	$password = "0000";

} elseif($_SERVER['HTTP_HOST'] == 'brave.test') {	// virtual host

	$server = "http://" . $_SERVER['HTTP_HOST'];

	$dateposted = date("Y-m-d H:i:s");

	$username = "brave";
	$database = "brave_database";
	$password = "0000";

} elseif($_SERVER['HTTP_HOST'] == 'scandire.com' ) {	// Sandbox

	$server = "http://" . $_SERVER['HTTP_HOST'] . "/brave";

	$dateposted = date("Y-m-d H:i:s");

	$username = "scanflsx_brave";
	$database = "scanflsx_brave_database";
	$password = "";

} else {	// Live

	$server = "https://" . $_SERVER['HTTP_HOST'];

	$dateposted = date("Y-m-d H:i:s");

	$username = "brave";
	$database = "brave_database";
	$password = "0000";

}

$page = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$user_agent = getenv("HTTP_USER_AGENT");

if(strpos($user_agent, "Win") !== FALSE)
	$servername = "localhost";
elseif(strpos($user_agent, "Mac") !== FALSE)
	$servername = "127.0.0.1";

// Create connection
$connect = mysqli_connect($servername, $username, $password, $database);

if(!$connect) {

	echo "<script>";
	echo "alert('Please import the brave_database.sql file into your MySQL database engine first. The README.md file will open in another tab');";
	echo "window.open('http://localhost/brave/README.md', '_blank');";
	echo "</script>";	

}

?>
