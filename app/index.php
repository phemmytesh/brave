<?php
include('../includes/global.php'); include('../includes/auth.php'); 

if(isset($_SESSION['pag'])) {
	
	echo "<meta http-equiv='refresh' content='0;url=".$_SESSION['pag']."'>"; 
  unset($_SESSION['pag']); 
  exit();
	
}

$sql_students = "SELECT * FROM students ORDER BY dateposted DESC";
$result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
$row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);

$student_no = array();
$class_no = array();
$year = array();
$studentID = array();
$first_name = array();
$last_name = array();
$address = array();
$birth_date = array();
$full_name = array();
$contact_phone = array();
$join_date = array();

if($num_students) {

  do {

    array_push($student_no, $row_students['student_no']);
    array_push($class_no, $row_students['class_no']);
    array_push($year, $row_students['year']);
    array_push($studentID, $row_students['studentID']);
    array_push($first_name, $row_students['first_name']);
    array_push($last_name, $row_students['last_name']);
    array_push($address, $row_students['address']);
    array_push($birth_date, $row_students['birth_date']);
    array_push($full_name, $row_students['full_name']);
    array_push($contact_phone, $row_students['contact_phone']);
    array_push($join_date, $row_students['dateposted']);

  } while($row_students = mysqli_fetch_assoc($result_students));

}

$sql_active = "SELECT DISTINCT(student_no) FROM student_subjects WHERE score <> ''";
$result_active = mysqli_query($connect,$sql_active) or die("Couldn't execute query active students");
$row_active = mysqli_fetch_assoc($result_active); $num_active = mysqli_num_rows($result_active);

$active = array();

if($num_active) {

  do {

    array_push($active, $row_active['student_no']);

  } while($row_active = mysqli_fetch_assoc($result_active));

}

?>

<head>
    
	<title>Dashboard: Management System | Brave</title>
    <?php include('../includes/meta.php'); ?>

</head>
    
<body>

    <!-- ########## START: LEFT PANEL ########## -->
    <?php include('../includes/left-panel.php'); ?>
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include('../includes/head-panel.php'); ?>
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">

      <div class="pd-30">
        <h4 class="tx-gray-800 mg-b-5">Dashboard</h4>
        <p class="mg-b-0">Welcome to your dashboard</p>
      </div><!-- d-flex -->

      <div class="br-pagebody mg-t-5 pd-x-30">
      
        <div class="row row-sm">

          <div class="col-sm-6 col-xl-4">
            <div class="bg-primary rounded overflow-hidden">
              <div class="pd-25 d-flex align-items-center">
                <i class="ion ion-person-stalker tx-60 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Active Students</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?php echo number_format($num_active); ?></p>
                </div>
              </div>
            </div>
          </div><!-- col-3 -->
          
          <div class="col-sm-6 col-xl-4 mg-t-20 mg-sm-t-0">
            <div class="bg-danger rounded overflow-hidden">
              <div class="pd-25 d-flex align-items-center">
                <i class="ion ion-person tx-60 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Inactive Students</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?php echo number_format($num_students - $num_active); ?></p>
                </div>
              </div>
            </div>
          </div><!-- col-3 -->
  
          <div class="col-sm-12 col-xl-4 mg-t-20 mg-xl-t-0">
            <div class="bg-teal rounded overflow-hidden">
              <div class="pd-25 d-flex align-items-center">
                <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Students</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?php echo number_format($num_students); ?></p>
                </div>
              </div>
            </div>
          </div><!-- col-3 -->
          
        </div><!-- row -->

        <div class="row row-sm mg-t-20">

          <div class="col-12 col-12">
            <div class="card pd-0 bd-0 shadow-base">
              <div class="pd-x-30 pd-t-30 pd-b-15">
                <div class="d-flex align-items-center justify-content-between">
                  <div>
                    <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">Table View</h6>
                    <p class="mg-b-0"></p>
                  </div>
                  <div class="tx-13">
                    <p class="mg-b-0"><span class="square-8 rounded-circle mg-r-10" style="background-color: #06C"></span>Students with reports</p>
                    <p class="mg-b-0" style="text-align: right"><a href="<?php echo $server; ?>/app/students/add_student">Add New Student</a></p>
                  </div>
                </div>
              </div>
              <div class="pd-x-30">
                <div class="table-wrapper">
                  <table id="datatable" class="table display responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th class="wd-5p">SN</th>
                        <th class="wd-10p">Actions</th>
                        <th class="wd-20p">Student Name | ID</th>
                        <th class="wd-20p">Birthday | Join Date</th>
                        <th class="wd-10p">Class</th>
                        <th class="wd-10p">Subjects</th>
                        <th class="wd-10p">Emergency Contact</th>
                        <th class="wd-15p">Report</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if($num_students != 0) { $i = 1; foreach($student_no as $key => $value) { 

                      $sql_class = "SELECT * FROM classes WHERE class_no = '$class_no[$key]'";
                      $result_class = mysqli_query($connect,$sql_class) or die("Couldn't execute query class");
                      $row_class = mysqli_fetch_assoc($result_class); $num_class = mysqli_num_rows($result_class);

                      $sql_subjects = "SELECT COUNT(*) AS subject FROM student_subjects WHERE student_no = '$value'";
                      $result_subjects = mysqli_query($connect,$sql_subjects) or die("Couldn't execute query subjects");
                      $row_subjects = mysqli_fetch_assoc($result_subjects); $num_subjects = mysqli_num_rows($result_subjects);
                      
                     ?>
                      <tr>
                      
                        <td><?php echo $i++; ?></td>
                        
                        <td>
                          <a href="<?php echo $server."/app/students/edit_student/?id=".$studentID[$key]; ?>" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="Edit <?php echo $first_name[$key]; ?>"><div style="height:22px"><i class="fa fa-pencil"></i></div></a>
                          <a href="<?php echo $server."/app/students/process/?action=delete&id=".$studentID[$key]; ?>" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete <?php echo $first_name[$key]; ?>" onClick="return confirm('Are you sure..?');"><div style="height:22px"><i class="fa fa-close"></i></div></a>
                        </td>
                        
                        <td data-toggle='tooltip' data-placement='top' title='Address: <?php echo $address[$key]; ?>'>
                          <?php echo $first_name[$key] . " " . $last_name[$key]; ?><br>
                          <?php echo $studentID[$key]; ?>
                        </td>

                        <td>
                          <b style="letter-spacing:1px"><?php echo  date("d-M-Y",strtotime($birth_date[$key])); ?></b><br>
                          <?php echo  date("D d/M/y g:ia",strtotime($join_date[$key])); ?>
                        </td>

                        <td>
                            <?php echo $year[$key]; ?><br>
                            <?php echo $row_class['class_name']; ?>
                        </td>

                        <td>
                            <?php echo $row_subjects['subject']; ?>
                        </td>
                        
                        <td>
                          <?php echo $full_name[$key]; ?><br>
                          <a href="tel:<?php echo $contact_phone[$key]; ?>"><?php echo $contact_phone[$key]; ?></a>
                        </td>
              
                      <td>
                        <?php if(in_array($value, $active)) { ?>
                          <a href="<?php echo $server; ?>/app/reports/view_reports/?no=<?php echo $value; ?>" class="btn btn-primary btn-icon"><div style="height:22px" data-toggle="tooltip" data-placement="top" title="View report for <?php echo $first_name[$key]; ?>"><i class="fa fa-eye"></i></div></a>
                        <?php } else { ?>
                          <a href="javascript:" class="btn btn-secondary btn-icon" style="cursor:crosshair"><div style="height:22px" data-toggle="tooltip" data-placement="top" title="Inactive"><i class="fa fa-eye"></i></div></a>
                        <?php } ?>
                      </td>
                                        
                      </tr>
                    <?php } unset($i); unset($key); unset($value); } ?>
                    </tbody>
                  </table>
                </div><!-- table-wrapper -->

                <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-10 mg-b-10 tx-gray-600">Notes</p>
                <pre><code class="javascript pd-20 mg-b-10">
                Hover your pointer on the icons to see their actions.
                Only active students have reports. <a href="<?php echo $server; ?>/app/reports/scores">Click here</a> to enter test scores for inactive students to make them active
                </code></pre>
                
              </div>
            </div><!-- card -->
          </div>
          
        </div><!-- row -->            

      </div><!-- br-pagebody -->
      
      <?php include('../includes/footer.php'); ?>
    
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <?php include('../includes/scripts.php'); ?>
    
</body>
</html>
