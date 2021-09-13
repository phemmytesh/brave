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
			
			$title = trim(addslashes($_POST['title']));
			
			if (trim($title) == '') {
				echo '<div class="error_message">Attention! Please enter the subject title</div>';
				exit();
			}

			/* check if title exists */
			$sql_title_check = "SELECT title FROM subjects WHERE title = '$title'";
			$result_title_check = mysqli_query($connect,$sql_title_check) or die(mysqli_error());
			$row_title_check = mysqli_fetch_assoc($result_title_check); $num_title_check = mysqli_num_rows($result_title_check); 

			if ($num_title_check == 1) {
				echo '<div class="error_message">Attention! The title already exists. Enter another title.</div>';
				exit();
			}

			// Generating Random Subject ID
			function GenerateID() {
				$subjectID = '';
				$salt1 = strtoupper("abcdefghijklmnopqrstuvwxyz");
				$salt2 = "1234567890";
				srand((double)microtime()*1000000);  	
				$i = 0;	
				while ($i < 10) {  // changing for other length
					if($i < 2) {
						$num1 = rand() % strlen($salt1);	
						$tmp1 = substr($salt1, $num1, 1);
						$subjectID = $subjectID . $tmp1;	
					} else {
						$num2 = rand() % strlen($salt2);	
						$tmp2 = substr($salt2, $num2, 1);
						$subjectID = $subjectID . $tmp2;	
					}
					$i++;	
				}
				return $subjectID;
			}
			$subjectID = GenerateID();

			/* check if subjectID exists */
			$sql_subjectID_check = "SELECT subjectID FROM subjects WHERE subjectID = '$subjectID'";
			$result_subjectID_check = mysqli_query($connect,$sql_subjectID_check) or die(mysqli_error());
			$row_subjectID_check = mysqli_fetch_assoc($result_subjectID_check); $num_subjectID_check = mysqli_num_rows($result_subjectID_check); 

			while ($num_subjectID_check == 1) {
				
				$subjectID = GenerateID();

				$sql_subjectID_check = "SELECT subjectID FROM subjects WHERE subjectID = '$subjectID'";
				$result_subjectID_check = mysqli_query($connect,$sql_subjectID_check) or die(mysqli_error());
				$row_subjectID_check = mysqli_fetch_assoc($result_subjectID_check); $num_subjectID_check = mysqli_num_rows($result_subjectID_check); 
					
			}
			
			// Add Subject to subject table
			$sql_insert_ann = "INSERT INTO subjects (subjectID,title,status,dateposted,postedby,ip,host) VALUES ('$subjectID','$title','2','$dateposted','$row[user_no]','$ip','$host')";
			$result_insert_ann = mysqli_query($connect,$sql_insert_ann) or die("Couldn't execute insert query subject.");
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " added a new subject: " . $title;
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
								 
			/* Success feedback */
			echo "<fieldset>";
			echo "<div id='success_page'>";
			echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> New Subject Added Successfully!</span></div></div>";
			echo "</div>";
			echo "</fieldset>";
			
		break;
		
		case "update": 

			$title = trim(addslashes($_POST['title']));
			
			if (trim($title) == '') {

				$_SESSION['msg'] = "Attention! Please enter the subject title";
				header("Location: $server/app/subjects/#table");
				exit();

			}

			/* check if title exists */
			$sql_title_check = "SELECT title FROM subjects WHERE title = '$title' AND subject_no <> '$_POST[no]'";
			$result_title_check = mysqli_query($connect,$sql_title_check) or die(mysqli_error());
			$row_title_check = mysqli_fetch_assoc($result_title_check); $num_title_check = mysqli_num_rows($result_title_check); 

			if ($num_title_check == 1) {
				$_SESSION['msg'] = "Attention! The title " . $title . " already exists. Enter another title.";
				header("Location: $server/app/subjects/#table");
				exit();
			}
								
			// Update Subject 
			$UpdateRecords_ann = "UPDATE subjects SET title = '$title', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE subject_no = '$_POST[no]'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query subject - " . $title);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " updated subject - " . $title;
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
								 
			/* Success feedback */
			$_SESSION['msg'] = "Well done! Subject " . $_POST['id'] . " Updated Successfully!";
			header("Location: $server/app/subjects/#table");
			exit();
			
		break;
	}
}

if($_GET) {

	switch ($_GET["action"])
	{
		case "disable": 
		
			// Update Subject
			$UpdateRecords_ann = "UPDATE subjects SET status = '0', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE subject_no = '$_GET[no]'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query subject " . $_GET['id']);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " disabled subject " . $_GET['id'];
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
			
			$_SESSION['msg'] = "You have successfully disabled subject " . $_GET['id'];
			header("Location: $server/app/subjects/#table");
		
		break;
		
		case "enable": 
		
			// Update Subject
			$UpdateRecords_ann = "UPDATE subjects SET status = '2', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE subject_no = '$_GET[no]'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query subject " . $_GET['id']);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " enabled subject " . $_GET['id'];
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
			
			$_SESSION['msg'] = "You have successfully enabled subject " . $_GET['id'];
			header("Location: $server/app/subjects/#table");
		
		break;

		case "delete": 
		
			// Delete Subject
			$DeleteRecords_ann = "DELETE FROM subjects WHERE subject_no = '$_GET[no]'";
			$Delete_ann = mysqli_query($connect,$DeleteRecords_ann) or die("Couldn't execute delete query subject " . $_GET['id']);

			// Delete Subject reference in student_subjects
			$DeleteRecords = "DELETE FROM student_subjects WHERE subject_no = '$_GET[no]'";
			$Delete = mysqli_query($connect,$DeleteRecords) or die("Couldn't execute delete query student subject " . $_GET['id']);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " deleted subject " . $_GET['id'];
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
			
			$_SESSION['msg'] = "You have successfully deleted subject " . $_GET['id'];
			header("Location: $server/app/subjects/#table");
		
		break;
	}
}
?>