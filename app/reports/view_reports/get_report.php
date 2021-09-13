<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

$sql_students = "SELECT * FROM students WHERE student_no = '$_POST[student_no]'";
$result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
$row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);

$sql_class = "SELECT * FROM classes WHERE class_no = '$row_students[class_no]'";
$result_class = mysqli_query($connect,$sql_class) or die("Couldn't execute query class");
$row_class = mysqli_fetch_assoc($result_class); $num_class = mysqli_num_rows($result_class);

$sql_subjects = "SELECT * FROM student_subjects WHERE student_no = '$_POST[student_no]'";
$result_subjects = mysqli_query($connect,$sql_subjects) or die("Couldn't execute query subjects");
$row_subjects = mysqli_fetch_assoc($result_subjects); $num_subjects = mysqli_num_rows($result_subjects);

$subject_no = array();

if($num_subjects) {

    do { if($row_subjects['score'] != '') { array_push($subject_no, $row_subjects['subject_no']); } } while($row_subjects = mysqli_fetch_assoc($result_subjects));

}

if(empty($subject_no)) { $msg = 'fail'; }
else { $msg = 'success'; }

$subjectID = array();
$title = array();
$score = array();
$grade = array();

$weight = 0;
$grade_weight = '-';
$i = 0;

if($msg == 'success') {

    $result_subjects = mysqli_query($connect,$sql_subjects) or die("Couldn't execute query subjects");
    $row_subjects = mysqli_fetch_assoc($result_subjects);

    do { 

        $sql_ann = "SELECT * FROM subjects WHERE subject_no = '$row_subjects[subject_no]'";
        $result_ann = mysqli_query($connect,$sql_ann) or die("Couldn't execute query subject.");
        $row_ann = mysqli_fetch_assoc($result_ann); $num_ann = mysqli_num_rows($result_ann);

        array_push($subjectID, $row_ann['subjectID']);
        array_push($title, $row_ann['title']);

        if($row_subjects['score'] != '') {

            array_push($score, $row_subjects['score']);

            $weight += $row_subjects['score'];
            $i++;

            if($row_subjects['score'] > 79) { $grad = 'A'; }
            if($row_subjects['score'] < 80 && $row_subjects['score'] > 59) { $grad = 'B'; }
            if($row_subjects['score'] < 60 && $row_subjects['score'] > 49) { $grad = 'C'; }
            if($row_subjects['score'] < 50 && $row_subjects['score'] > 39) { $grad = 'D'; }
            if($row_subjects['score'] < 40 && $row_subjects['score'] > 29) { $grad = 'E'; }
            if($row_subjects['score'] < 30) { $grad = 'F'; }

            array_push($grade, $grad);

        } else {

            array_push($score, '-');
            array_push($grade, '-');
        }
                
    } while($row_subjects = mysqli_fetch_assoc($result_subjects));

    $weight = $weight / $i;

    if($weight > 79) { $grade_weight = 'A'; }
    if($weight < 80 && $weight > 59) { $grade_weight = 'B'; }
    if($weight < 60 && $weight > 49) { $grade_weight = 'C'; }
    if($weight < 50 && $weight > 39) { $grade_weight = 'D'; }
    if($weight < 40 && $weight > 29) { $grade_weight = 'E'; }
    if($weight < 30) { $grade_weight = 'F'; }

}

$subject[] = array(
    'report_no' => '#00'.$row_students['student_no'],
    'student_name' => $row_students['first_name'] . " " . $row_students['last_name'],
    'studentID' => $row_students['studentID'],
    'address' => $row_students['address'],
    'start_date' => 'Started: '.date('D, F d, Y',strtotime($row_students['dateposted'])),
    'year_class' => 'Year: '.$row_students['year'].' | Class: '.$row_class['class_name'],
    'DOB' => 'D.O.B: '.date('D, M d, Y',strtotime($row_students['birth_date'])),
    'subjectID' => $subjectID,
    'title' => $title,
    'score' => $score,
    'grade' => $grade,
    'weight' => number_format($weight),
    'grade_weight' => $grade_weight,
    'msg' => $msg
);

echo json_encode($subject);

?>