<?php 

if(!isset($_SESSION['authenticate']) || !isset($_SESSION['user_no'])) 
{

	unset($_SESSION['authenticate']); unset($_SESSION['user_no']);
	echo "<meta http-equiv='refresh' content='0;url=".$server."/?pag=".$page."'>"; 
	exit();

}

?>
