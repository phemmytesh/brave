<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

$sql_subjects = "SELECT * FROM student_subjects WHERE student_no = '$_POST[student_no]'";
$result_subjects = mysqli_query($connect,$sql_subjects) or die("Couldn't execute query subjects");
$row_subjects = mysqli_fetch_assoc($result_subjects); $num_subjects = mysqli_num_rows($result_subjects);

if($num_subjects > 0) {

    do { 

        $sql_ann = "SELECT * FROM subjects WHERE subject_no = '$row_subjects[subject_no]'";
        $result_ann = mysqli_query($connect,$sql_ann) or die("Couldn't execute query subjects.");
        $row_ann = mysqli_fetch_assoc($result_ann); $num_ann = mysqli_num_rows($result_ann);

        if($row_subjects['score'] == '') { $score = ''; }
        else { $score = $row_subjects['score']; }
            
        $subject[] = array(
            'ss_no' => $row_subjects['ss_no'],
            'subject' => $row_ann['title'],
            'score' => $score
        );
        
    } while($row_subjects = mysqli_fetch_assoc($result_subjects));

} else {
	
	$subject[] = array();
	
}

echo json_encode($subject);

?>