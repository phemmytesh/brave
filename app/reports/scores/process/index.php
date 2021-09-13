<?php
include('../../../../includes/global.php'); include('../../../../includes/auth.php');

if(!$_POST) exit();

// print_r($_POST); exit();
// echo $_POST['iv7']; exit();

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
		
$sql_student = "SELECT * FROM students WHERE student_no = '$student_no'";
$result_student = mysqli_query($connect,$sql_student) or die("Couldn't execute query student");
$row_student = mysqli_fetch_assoc($result_student); $num_student = mysqli_num_rows($result_student);

$i = 1;
		
foreach(array_keys($_POST) as $key => $value) {
			
    if($key > 0 && $value != 'password') {
				
		if(substr($value, 0, 2) == 'st') { // Student Subjects 
				
		    $ss_no = (int)str_replace('st','',$value);

			if($_POST[$value] != '' && is_numeric($_POST[$value])) {
										
				$UpdateRecords = "UPDATE student_subjects SET score = '$_POST[$value]', dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE ss_no = '$ss_no'";

			} else {

				$UpdateRecords = "UPDATE student_subjects SET score = NULL, dateupdated = '$dateposted', editedby = '$row[user_no]', ip = '$ip', host = '$host' WHERE ss_no = '$ss_no'";
				
			}

			// Update Student Subjects with score
			$Update = mysqli_query($connect,$UpdateRecords) or die("Error with update score " . $ss_no . " query");

			if($i == 1) {

				$description = $row['first_name'] . " " . $row['last_name'] . " updated student " . $row_student['first_name'] . " " . $row_student['last_name'] . " test scores";
				$sql_act = "INSERT INTO user_activities (description,user_no,ip,host,dateposted) VALUES ('$description','$row[user_no]','$ip','$host','$dateposted')";
				$result_act = mysqli_query($connect,$sql_act) or die("Couldn't execute insert query activities.");
				
			}

			$i++;
									
		}
								
	}
			
}

unset($i);
		
/* Success feedback */
echo "<fieldset>";
echo "<div id='success_page'>";
echo "<div class='alert-success' role='alert'><div class='d-flex align-items-center justify-content-start'><i class='icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0'></i><span><strong>Well done!</strong> Student " . $row_student['first_name'] . " " . $row_student['last_name'] . " Test Scores Updated Successfully!</span></div></div>";
echo "</div>";
echo "</fieldset>";
exit();	
	
?>