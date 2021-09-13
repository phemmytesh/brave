<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

$sql_students = "SELECT * FROM students ORDER BY dateposted DESC";
$result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
$row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <title>View Students - Students: Management System | Brave</title>
	<?php include('../../../includes/meta.php'); ?>
    
  </head>

  <body>

    <!-- ########## START: LEFT PANEL ########## -->
    <?php include('../../../includes/left-panel.php'); ?>
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
	  <?php include('../../../includes/head-panel.php'); ?>
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo $server; ?>/app">Dashboard</a>
          <a class="breadcrumb-item" href="javascript:">Students</a>
          <span class="breadcrumb-item active">View Students</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">View Students</h4>
        <p class="mg-b-0">List of all students.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

          <div class="table-wrapper">
            <table id="datatable" class="table display responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th class="wd-5p">SN</th>
                  <th class="wd-10p">Actions</th>
                  <th class="wd-30p">Student Name | ID | Birthday</th>
                  <th class="wd-10p">Class</th>
                  <th class="wd-10p">Subjects</th>
                  <th class="wd-20p">Emergency Contact</th>
                  <th class="wd-15p">Join Date</th>
                </tr>
              </thead>
              <tbody>
              <?php if($num_students != 0) { $i = 1; do { 

                if($row_students['photo'] != '') {

                    $filepath = $server.'/img/students/'.$row_students['photo'];

                } else {

                    $filepath = $server.'/img/male.jpg';

                }

                $sql_class = "SELECT * FROM classes WHERE class_no = '$row_students[class_no]'";
                $result_class = mysqli_query($connect,$sql_class) or die("Couldn't execute query class");
                $row_class = mysqli_fetch_assoc($result_class); $num_class = mysqli_num_rows($result_class);

                $sql_subjects = "SELECT COUNT(*) AS subject FROM student_subjects WHERE student_no = '$row_students[student_no]'";
                $result_subjects = mysqli_query($connect,$sql_subjects) or die("Couldn't execute query subjects");
                $row_subjects = mysqli_fetch_assoc($result_subjects); $num_subjects = mysqli_num_rows($result_subjects);
                
			        ?>
                <tr>
                
                  <td><?php echo $i++; ?></td>
                  
                  <td>
                    <a href="<?php echo $server."/app/students/edit_student/?id=".$row_students['studentID']; ?>" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="Edit <?php echo $row_students['first_name']; ?>"><div style="height:22px"><i class="fa fa-pencil"></i></div></a>
                    <a href="<?php echo $server."/app/students/process/?action=delete&id=".$row_students['studentID']; ?>" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete <?php echo $row_students['first_name']; ?>" onClick="return confirm('Are you sure..? This will the delete the student along with all its references.');"><div style="height:22px"><i class="fa fa-close"></i></div></a>
                  </td>
                  
                  <td data-toggle='tooltip' data-placement='top' title='Address: <?php echo $row_students['address']; ?>'>
                    <img src="<?php echo $filepath; ?>" style="float:left; margin-right:10px; height:60px; border-radius:5px" />
                    <?php echo $row_students['first_name'] . " " . $row_students['last_name']; ?><br>
                    <?php echo $row_students['studentID']; ?><br>
                    <b style="letter-spacing:1px"><?php echo  date("d-M-Y",strtotime($row_students['birth_date'])); ?></b>
                  </td>

                  <td>
                      <?php echo $row_students['year']; ?><br>
                      <?php echo $row_class['class_name']; ?>
                  </td>

                  <td>
                      <?php echo $row_subjects['subject']; ?>
                  </td>
                  
                  <td>
                    <?php echo $row_students['full_name']; ?><br>
                    <a href="tel:<?php echo $row_students['contact_phone']; ?>"><?php echo $row_students['contact_phone']; ?></a>
                  </td>
				 
                 <td>
                    <?php echo date("l",strtotime($row_students['dateposted'])); ?><br>
                    <?php echo date("d-M-Y",strtotime($row_students['dateposted'])); ?><br>
                    <?php echo date("g:ia",strtotime($row_students['dateposted'])); ?>
                 </td>
                                   
                </tr>
               <?php } while($row_students = mysqli_fetch_assoc($result_students)); } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->

          <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Notes</p>
          <pre><code class="javascript pd-20">
          Hover your pointer on the icons to see their actions.
          </code></pre>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
	<?php include('../../../includes/footer.php'); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    
	<?php include('../../../includes/scripts.php'); ?>
  </body>
</html>
