<?php
include('../../../includes/global.php'); include('../../../includes/auth.php'); 

if($_POST) {

	switch ($_POST["action"])
	{
		case "new": 
		
			$password = trim(str_replace("'","",str_replace('"','',$_POST['password'])));
			
			$sql_pwd = "SELECT * FROM users WHERE user_no = '$row[user_no]' AND password = md5('$password')";
			$result_pwd = mysqli_query($connect,$sql_pwd) or die("Couldn't execute query password."); 
			$num_pwd = mysqli_num_rows($result_pwd); $row_pwd = mysqli_fetch_assoc($result_pwd);
			
			if (trim($password) == '') {
				echo '<div class="error_message">Attention! Please enter your password</div>';
				exit();
			} elseif ($num_pwd == 0) { // current password is not correct
				echo '<div class="error_message">Attention! Password is incorrect</div>';
				exit();
			} 
			
			$class_name = trim(addslashes($_POST['class_name']));
			
			if (trim($class_name) == '') {
				echo '<div class="error_message">Attention! Please enter the class name</div>';
				exit();
			}

			/* check if class exists */
			$sql_class_check = "SELECT class_name FROM classes WHERE class_name = '$class_name'";
			$result_class_check = mysqli_query($connect,$sql_class_check) or die(mysqli_error());
			$row_class_check = mysqli_fetch_assoc($result_class_check); $num_class_check = mysqli_num_rows($result_class_check); 

			if ($num_class_check == 1) {
				echo '<div class="error_message">Attention! The class already exists. Enter another class.</div>';
				exit();
			}
			
			// Add class to classes table
			$sql_insert_ann = "INSERT INTO classes (class_name,status,dateposted,postedby,ip,host) VALUES ('$class_name','2','$dateposted','$row[user_no]','$ip','$host')";
			$result_insert_ann = mysqli_query($connect,$sql_insert_ann) or die("Couldn't execute insert query class.");
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " added a new class: " . $class_name;
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
								 
			/* Success feedback */
			echo "<fieldset>";
			echo "<div id='success_page'>";
			echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> New Class Added Successfully!</span></div></div>";
			echo "</div>";
			echo "</fieldset>";
			
		break;
		
		case "update": 

			$class_name = trim(addslashes($_POST['class_name']));
			
			if (trim($class_name) == '') {

				$_SESSION['msg'] = "Attention! Please enter the class name";
				header("Location: $server/app/classes/#table");
				exit();

			}

			/* check if class exists */
			$sql_class_check = "SELECT class_name FROM classes WHERE class_name = '$class_name' AND class_no <> '$_POST[no]'";
			$result_class_check = mysqli_query($connect,$sql_class_check) or die(mysqli_error());
			$row_class_check = mysqli_fetch_assoc($result_class_check); $num_class_check = mysqli_num_rows($result_class_check); 

			if ($num_class_check == 1) {
				$_SESSION['msg'] = "Attention! The class " . $class_name . " already exists. Enter another class.";
				header("Location: $server/app/classes/#table");
				exit();
			}
								
			// Update Class 
			$UpdateRecords_ann = "UPDATE classes SET class_name = '$class_name', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE class_no = '$_POST[no]'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query subject - " . $class_name);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " updated class - " . $class_name;
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
								 
			/* Success feedback */
			$_SESSION['msg'] = "Well done! Class Updated to " . $class_name . " Successfully!";
			header("Location: $server/app/classes/#table");
			exit();
			
		break;
	}
}

if($_GET) {

	switch ($_GET["action"])
	{
		case "disable": 
		
			// Update class
			$UpdateRecords_ann = "UPDATE classes SET status = '0', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE class_no = '$_GET[no]'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query class " . $_GET['name']);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " disabled class " . $_GET['name'];
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
			
			$_SESSION['msg'] = "You have successfully disabled class " . $_GET['name'];
			header("Location: $server/app/classes/#table");
		
		break;
		
		case "enable": 
		
			// Update class
			$UpdateRecords_ann = "UPDATE classes SET status = '2', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE class_no = '$_GET[no]'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query class " . $_GET['name']);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " enbaled class " . $_GET['name'];
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
			
			$_SESSION['msg'] = "You have successfully enabled class " . $_GET['name'];
			header("Location: $server/app/classes/#table");
		
		break;

		case "delete":

			$sql_students = "SELECT * FROM students WHERE class_no = '$_GET[no]'";
			$result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
			$row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);

			if($num_students == 0) {
		
				// Delete Class
				$DeleteRecords_ann = "DELETE FROM classes WHERE class_no = '$_GET[no]'";
				$Delete_ann = mysqli_query($connect,$DeleteRecords_ann) or die("Couldn't execute delete query class " . $_GET['name']);

				// Add log to Activities Table
				$description = $row['first_name'] . " " . $row['last_name'] . " deleted class " . $_GET['name'];
				$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
				$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
				
				$_SESSION['msg'] = "You have successfully deleted class " . $_GET['name'];

			} else {

				// Add log to Activities Table
				$description = $row['first_name'] . " " . $row['last_name'] . " attempted to delete class " . $_GET['name'];
				$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
				$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
				
				$_SESSION['msg'] = "You cannot delete class " . $_GET['name'] . " until all its students are relocated.";

			}
			
			header("Location: $server/app/classes/#table");
		
		break;
	}
}
?>