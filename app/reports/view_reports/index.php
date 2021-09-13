<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

$sql_students = "SELECT * FROM students ORDER BY dateposted DESC";
$result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
$row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);

?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <title>View Reports - Reports: Management System | Brave</title>
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
          <a class="breadcrumb-item" href="javascript:">Reports</a>
          <span class="breadcrumb-item active">View Reports</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">View Reports</h4>
        <p class="mg-b-0">View active student reports</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

          <form name="form_action" id="form_action" action="javascript:" method="post">

              <div class="form-layout form-layout-6">

                  <div class="row no-gutters">
                    <div class="col-5 col-sm-3">
                      Student: <span class="tx-danger">*</span>
                    </div><!-- col-4 -->
                    <div class="col-7 col-sm-9">
                      <select id="student_no" class="form-control select2-show-search" name="student_no" onChange="report();">
                          <option value="">Choose a student</option>
                          <?php if($num_students) { do { ?>
                              <option value="<?php echo $row_students['student_no']; ?>"><?php echo $row_students['studentID'] . " - " . $row_students['first_name'] . " " . $row_students['last_name']; ?></option>
                          <?php } while($row_students = mysqli_fetch_assoc($result_students)); } ?>
                      </select>	
                    </div><!-- col-8 -->
                  </div><!-- row -->
                  
                </div><!-- form-layout -->

          </form>
              <div id="message"></div>
                    
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

      <div class="br-pagebody">
        <div class="br-section-wrapper">

            <div id="report">

              <div id="card" class="br-section-wrapper" style="display:none">

                <div class="row">
                  <div class="col-6">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-40">Report</h6>
                  </div>
                  <div class="col-6 text-right">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-40" id="rep"></h6>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <h6 class="tx-gray-800 tx-14 mg-b-10" id="student_name"></h6>
                  </div>
                  <div class="col-6">
                    <h6 class="tx-gray-500 tx-14 mg-b-10" id="studentID"></h6>
                  </div>
                  <div class="col-6 text-right">
                    <h6 class="tx-gray-500 tx-14 mg-b-10" id="start_date"></h6>
                  </div>
                </div>

                <div class="row">
                  <div class="col-4">
                    <h6 class="tx-gray-800 tx-14 mg-b-10" id="address"></h6>
                  </div>
                  <div class="col-8 text-right">
                    <h6 class="tx-gray-500 tx-14 mg-b-10" id="year_class"></h6>
                    <h6 class="tx-gray-800 tx-14 mg-b-10" id="DOB"></h6>
                  </div>
                </div>

                <div class="table-wrapper">
                  <table id="datatable2" class="table display responsive nowrap" style="width:100%">
                    <thead style="background-color:#EEE">
                      <tr>
                        <th style="width:5%">SN</th>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Score</th>
                        <th>Grade</th>
                      </tr>
                    </thead>
                    <tbody id="subjects">
                    </tbody>
                    <tbody>
                      <tr>
                        <td colspan="5"></td>
                      </tr>
                      <tr>
                        <td colspan="3" class="text-right">Weighted Average</td>
                        <td id="weight"></td>
                        <td id="grade_weight"></td>
                      </tr>
                  </table>
                </div>

              </div>

              <span id="default" class="mg-t-30">Report will then appear here...</span>

            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
	<?php include('../../../includes/footer.php'); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    
	<?php include('../../../includes/scripts.php'); ?>

    <script language="javascript">
	
    function report() {

      $('#card').hide(); 
      $('#default').html('<img src=\'<?php echo $server; ?>/img/loader.gif\'>');

			var student_no = $('#student_no').val();
			
			if(student_no != '') {

        var subjects = $("#subjects");
				var dataString = 'student_no='+ student_no;
				
        $.ajax({

					type: "POST",
					url: "get_report.php",
					data: dataString,
					dataType: 'json',
          success: function(response) {

            for(var i = 0; i < response.length; i++) {

              if(response[i].msg == 'success') { 

                var msg = 'success'; 

                $('#rep').html(response[i].report_no);
                $('#student_name').html(response[i].student_name);
                $('#studentID').html(response[i].studentID);
                $('#address').html(response[i].address);
                $('#start_date').html(response[i].start_date);
                $('#year_class').html(response[i].year_class);
                $('#DOB').html(response[i].DOB);

                if(response[i].weight > 59) {

                  $('#weight').html('<span class="tx-success">'+response[i].weight+'%</span>');
                  $('#grade_weight').html('<span class="tx-success">'+response[i].grade_weight+'</span>');

                } else if(response[i].weight < 60 && response[i].weight > 49) {

                  $('#weight').html('<span class="tx-primary">'+response[i].weight+'%</span>');
                  $('#grade_weight').html('<span class="tx-primary">'+response[i].grade_weight+'</span>');
                  
                } else if(response[i].weight < 50 && response[i].weight > 39) {

                  $('#weight').html('<span class="tx-info">'+response[i].weight+'%</span>');
                  $('#grade_weight').html('<span class="tx-info">'+response[i].grade_weight+'</span>');
                  
                } else if(response[i].weight < 40 && response[i].weight > 29) {

                  $('#weight').html('<span class="tx-warning">'+response[i].weight+'%</span>');
                  $('#grade_weight').html('<span class="tx-warning">'+response[i].grade_weight+'</span>');
                  
                } else if(response[i].weight < 39) {

                  $('#weight').html('<span class="tx-danger">'+response[i].weight+'%</span>');
                  $('#grade_weight').html('<span class="tx-danger">'+response[i].grade_weight+'</span>');
                  
                }

                var subj = '';
                subjects.empty();      

                var subjectID = response[i].subjectID;
                var title = response[i].title;
                var score = response[i].score;
                var grade = response[i].grade;

              } else { 
                
                var msg = 'fail'; 
              
              }

            }

            if(msg == 'success') {

              $('#card').slideDown('slow');      
              $('#default').hide(); 

              for(var i = 0; i < subjectID.length; i++) {

                subj += '<tr>';
                subj += '<td>'+(i+1)+'</td><td>'+subjectID[i]+'</td><td>'+title[i]+'</td>';

                if(score[i] > 59) {
                  subj += '<td class="tx-success">'+score[i]+'%</td><td class="tx-success">'+grade[i]+'</td>';
                } else if(score[i] < 60 && score[i] > 49) {
                  subj += '<td class="tx-primary">'+score[i]+'%</td><td class="tx-primary">'+grade[i]+'</td>';
                } else if(score[i] < 50 && score[i] > 39) {
                  subj += '<td class="tx-info">'+score[i]+'%</td><td class="tx-info">'+grade[i]+'</td>';
                } else if(score[i] < 40 && score[i] > 29) {
                  subj += '<td class="tx-warning">'+score[i]+'%</td><td class="tx-warning">'+grade[i]+'</td>';
                } else if(score[i] < 39) {
                  subj += '<td class="tx-danger">'+score[i]+'%</td><td class="tx-danger">'+grade[i]+'</td>';
                } else {
                  subj += '<td class="tx-danger">-</td><td class="tx-danger">-</td>';
                }

                subj += '</tr>';

              }

              subjects.append(subj);

            } else {

              $('#card').hide();
              $('#default').show();          
              $('#default').html('<span class="mg-t-30">Inactive student... Enter his/her test scores first</span>');      

            }

          }					   
              
        });
				
			} else {

				$('#card').hide();
        $('#default').show();          
				$('#default').html('<span class="mg-t-30">Report will then appear here...</span>');      
				
			}
			
		}

    </script>
    
  </body>
</html>
