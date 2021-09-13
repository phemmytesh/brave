<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

if($_POST) {

	switch ($_POST["action"])
	{

		case "photo":

			if(isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
			
				$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
				$path = '../../../img/temp/'; // upload to temporary directory
				
				$img = $_FILES['photo']['name'];
				$tmp = $_FILES['photo']['tmp_name'];
				$size = $_FILES['photo']['size'];
				$errorimg = $_FILES['photo']['error'];
				
				if($size > 5000000){
					
				   echo 'heavy_photo';  exit();
				   
				}
				
				if($errorimg > 0){
					
				   echo 'upload_error';  exit();
				   
				}
				
				// get uploaded file's extension
				$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
				
				// can upload same image using rand function - $final_image = rand(1000,1000000).$img;
				$final_image = $img;
				
				// check's valid format
				if(in_array($ext, $valid_extensions)) { 
				
					$path = $path.$final_image;
					
					if(move_uploaded_file($tmp,$path)) {
						
						echo "<img src='$server/img/temp/$final_image' style='height: 50px; border-radius: 10px' />"; exit();
						
					} 
						
				} else {
					
					echo 'invalid_file';  exit();
						
				}
				
			} else {
				
				echo 'no_file';  exit();
				
			}
	
		break;
		
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

			// print_r($_POST); exit();

			$first_name = trim(addslashes($_POST['first_name']));
			$last_name = trim(addslashes($_POST['last_name']));
			$birth_date = (isset($_POST['birth_date']) && trim($_POST['birth_date']) != "") ? date("Y-m-d",strtotime(trim($_POST['birth_date']))) : '';
			$address = trim(addslashes($_POST['address']));
			$full_name = trim(addslashes($_POST['full_name']));
			$contact_phone = trim(addslashes($_POST['contact_phone']));
			$class_no = trim(addslashes($_POST['class_no']));
			$year = trim(addslashes($_POST['year']));
			$subject_no = $_POST['subject_no']; $subjects_no = implode(',',$subject_no);
			
			if (trim($first_name) == '') {

				echo '<div class="error_message">Attention! Please enter the student first name</div>';
				exit();

			} elseif(trim($last_name) == '') {

				echo '<div class="error_message">Attention! Please enter the student last name</div>';
				exit();

			} elseif(trim($birth_date) == '') {

				echo '<div class="error_message">Attention! Please enter the student birthday</div>';
				exit();

			} elseif(trim($address) == '') {

				echo '<div class="error_message">Attention! Please enter the student full address</div>';
				exit();

			} elseif(trim($full_name) == '') {

				echo '<div class="error_message">Attention! Please enter the full name of the student emergency contact person</div>';
				exit();

			} elseif(trim($contact_phone) == '') {

				echo '<div class="error_message">Attention! Please enter the contact phone number of the student emergency contact person</div>';
				exit();

			} elseif(trim($class_no) == '') {

				echo '<div class="error_message">Attention! Please choose a class for the student</div>';
				exit();

			} elseif(empty($subject_no)) {

				echo '<div class="error_message">Attention! Please choose atleast one subject for the student</div>';
				exit();

			}

			// Generating Random Student ID
			function GenerateID() {
				$studentID = '';
				$salt1 = strtoupper("abcdefghijklmnopqrstuvwxyz");
				$salt2 = "1234567890";
				srand((double)microtime()*1000000);  	
				$i = 0;	
				while ($i < 12) {  // changing for other length
					if($i < 4) {
						$num1 = rand() % strlen($salt1);	
						$tmp1 = substr($salt1, $num1, 1);
						$studentID = $studentID . $tmp1;	
					} else {
						$num2 = rand() % strlen($salt2);	
						$tmp2 = substr($salt2, $num2, 1);
						$studentID = $studentID . $tmp2;	
					}
					$i++;	
				}
				return $studentID;
			}
			$studentID = GenerateID();

			/* check if studentID exists */
			$sql_studentID_check = "SELECT studentID FROM students WHERE studentID = '$studentID'";
			$result_studentID_check = mysqli_query($connect,$sql_studentID_check) or die(mysqli_error());
			$row_studentID_check = mysqli_fetch_assoc($result_studentID_check); $num_studentID_check = mysqli_num_rows($result_studentID_check); 

			while ($num_studentID_check == 1) {
				
				$studentID = GenerateID();

				$sql_studentID_check = "SELECT studentID FROM stduents WHERE studentID = '$studentID'";
				$result_studentID_check = mysqli_query($connect,$sql_studentID_check) or die(mysqli_error());
				$row_studentID_check = mysqli_fetch_assoc($result_studentID_check); $num_studentID_check = mysqli_num_rows($result_studentID_check); 
					
			}
			
			// Add student to student table
			$sql_insert_ann = "INSERT INTO students (studentID,class_no,year,first_name,last_name,birth_date,address,full_name,contact_phone,dateposted,postedby,ip,host) VALUES ('$studentID','$class_no','$year','$first_name','$last_name','$birth_date','$address','$full_name','$contact_phone','$dateposted','$row[user_no]','$ip','$host')";
			$result_insert_ann = mysqli_query($connect,$sql_insert_ann) or die("Couldn't execute insert query student.");
			$student_no = mysqli_insert_id($connect);

			// Insert into student_subject table
			foreach($subject_no as $key => $value) {
	
				$sql_insert_subject = "INSERT INTO student_subjects (student_no,subject_no,status,dateposted,postedby,ip,host) VALUES ('$student_no','$value','2','$dateposted','$row[user_no]','$ip','$host')";
				$result_insert_subject = $connect->query($sql_insert_subject) or die('Error with insert student: '.$first_name.', subject: '.$value.' query');
	
			} unset($key); unset($value);

			if($_POST['photo3'] == 'yes') {

				// Add photo in student table
				if($_FILES['photo']['name'] != NULL || $_FILES['photo']['name'] != "") {
				
					$photo = $student_no.'-'.$_FILES['photo']['name'];
					
					$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
					$path = '../../../img/students/'; // upload to student directory
					
					$img = $_FILES['photo']['name'];
					$tmp = $_FILES['photo']['tmp_name'];
					$size = $_FILES['photo']['size'];
					$errorimg = $_FILES['photo']['error'];

					if($size < 5000000 && $errorimg <= 0) {

						// get uploaded file's extension
						$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
						
						// can upload same image using rand function - $final_image = rand(1000,1000000).$img;
						$final_image = $student_no.'-'.$img;

						// check's valid format
						if(in_array($ext, $valid_extensions)) { 
						
							$path = $path.$final_image;
							
							if(move_uploaded_file($tmp,$path)) {
								
								// Update photo inventory in database
								$UpdateRecords = "UPDATE students SET photo = '$photo' WHERE student_no = '$student_no'";
								$Update = $connect->query($UpdateRecords) or die("Error with update student photo query");
								
							}
							
						}

					}
				
				}

			}
				
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " added a new student: " . $first_name . " " . $last_name;
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
								 
			/* Success feedback */
			echo "<fieldset>";
			echo "<div id='success_page'>";
			echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> New Student Added Successfully!</span></div></div>";
			echo "</div>";
			echo "</fieldset>";
			
		break;
		
		case "update":

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

			$student_no = $_POST['student_no'];
			$studentID = $_POST['studentID'];

			$first_name = trim(addslashes($_POST['first_name']));
			$last_name = trim(addslashes($_POST['last_name']));
			$birth_date = (isset($_POST['birth_date']) && trim($_POST['birth_date']) != "") ? date("Y-m-d",strtotime(trim($_POST['birth_date']))) : '';
			$address = trim(addslashes($_POST['address']));
			$full_name = trim(addslashes($_POST['full_name']));
			$contact_phone = trim(addslashes($_POST['contact_phone']));
			$class_no = trim(addslashes($_POST['class_no']));
			$year = trim(addslashes($_POST['year']));
			$subject_no = $_POST['subject_no']; $subjects_no = implode(',',$subject_no);
			$photo = $_POST['photo2'];
			
			if (trim($first_name) == '') {

				echo '<div class="error_message">Attention! Please enter the student first name</div>';
				exit();

			} elseif(trim($last_name) == '') {

				echo '<div class="error_message">Attention! Please enter the student last name</div>';
				exit();

			} elseif(trim($birth_date) == '') {

				echo '<div class="error_message">Attention! Please enter the student birthday</div>';
				exit();

			} elseif(trim($address) == '') {

				echo '<div class="error_message">Attention! Please enter the student full address</div>';
				exit();

			} elseif(trim($full_name) == '') {

				echo '<div class="error_message">Attention! Please enter the full name of the student emergency contact person</div>';
				exit();

			} elseif(trim($contact_phone) == '') {

				echo '<div class="error_message">Attention! Please enter the contact phone number of the student emergency contact person</div>';
				exit();

			} elseif(trim($class_no) == '') {

				echo '<div class="error_message">Attention! Please choose a class for the student</div>';
				exit();

			} elseif(empty($subject_no)) {

				echo '<div class="error_message">Attention! Please choose atleast one subject for the student</div>';
				exit();

			}

			if($_POST['photo3'] == 'yes') {

				// Update photo in student table
				if($_FILES['photo']['name'] != NULL || $_FILES['photo']['name'] != "") {
				
					$photo = $student_no.'-'.$_FILES['photo']['name'];
					
					$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
					$path = '../../../img/students/'; // upload to student directory
					
					$img = $_FILES['photo']['name'];
					$tmp = $_FILES['photo']['tmp_name'];
					$size = $_FILES['photo']['size'];
					$errorimg = $_FILES['photo']['error'];
								
					if($size < 5000000 && $errorimg <= 0) {

						// get uploaded file's extension
						$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
						
						// can upload same image using rand function - $final_image = rand(1000,1000000).$img;
						$final_image = $student_no.'-'.$img;

						// check's valid format
						if(in_array($ext, $valid_extensions)) { 
						
							$path = $path.$final_image;
							move_uploaded_file($tmp,$path);
							
						}

					}
				
				} 

			}

			// Update student 
			$UpdateRecords_ann = "UPDATE students SET class_no = '$class_no', year = '$year', first_name = '$first_name', last_name = '$last_name', birth_date = '$birth_date', address = '$address', full_name = '$full_name', contact_phone = '$contact_phone', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host', photo = '$photo' WHERE student_no = '$student_no'";
			$Update_ann = mysqli_query($connect,$UpdateRecords_ann) or die("Couldn't execute update query student - " . $first_name);
			
			// Update student_subject table
			$sql_student_subjects = "SELECT * FROM student_subjects WHERE student_no = '$student_no'";
			$result_student_subjects = mysqli_query($connect,$sql_student_subjects) or die("Couldn't execute query student subjects");
			$row_student_subjects = mysqli_fetch_assoc($result_student_subjects); $num_student_subjects = mysqli_num_rows($result_student_subjects);
			
			$student_subjects = array();
			
			if($num_student_subjects != 0) {
			
				do { array_push($student_subjects, $row_student_subjects['subject_no']); } while($row_student_subjects = mysqli_fetch_assoc($result_student_subjects));
			
			}

			foreach($subject_no as $key => $value) {
				
				if(!in_array($value, $student_subjects)) {
					
					// Insert new student_subject table
					$sql_insert_subject = "INSERT INTO student_subjects (student_no,subject_no,status,dateposted,postedby,ip,host) VALUES ('$student_no','$value','2','$dateposted','$row[user_no]','$ip','$host')";
					$result_insert_subject = mysqli_query($connect,$sql_insert_subject) or die('Error with insert student: '.$first_name.', subject: '.$value.' query');
						
				}
				
			} unset($key); unset($value);

			foreach($student_subjects as $key => $value) {
				
				if(!in_array($value, $subject_no)) {
					
					// Delete from student_subject table
					$DeleteRecords = "DELETE FROM student_subjects WHERE student_no = '$student_no' AND subject_no = '$value'";
					$Delete = mysqli_query($connect,$DeleteRecords) or die('Error with delete student: '.$first_name.', subject: '.$value.' query');
				
				}
				
			} unset($key); unset($value);
					
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " updated a student: " . $first_name . " " . $last_name;
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
								 
			/* Success feedback */
			echo "<fieldset>";
			echo "<div id='success_page'>";
			echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> Student Updated Successfully!</span></div></div>";
			echo "</div>";
			echo "</fieldset>";
						
		break;
	}
}

if($_GET) {

	switch ($_GET["action"])
	{

		case "delete": 
		
			// Delete Student
			$DeleteRecords_ann = "DELETE FROM students WHERE studentID = '$_GET[id]'";
			$Delete_ann = mysqli_query($connect,$DeleteRecords_ann) or die("Couldn't execute delete query student " . $_GET['id']);
			
			// Add log to Activities Table
			$description = $row['first_name'] . " " . $row['last_name'] . " deleted student " . $_GET['id'];
			$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
			$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
			
			$_SESSION['msg'] = "You have successfully deleted student " . $_GET['id'];
			header("Location: $server/app/students/view_students");
		
		break;
	}
}
?>