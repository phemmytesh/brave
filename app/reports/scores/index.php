<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

$sql_students = "SELECT * FROM students ORDER BY dateposted DESC";
$result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
$row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);

?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Test Scores - Reports: Management System | Brave</title>
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
          <span class="breadcrumb-item active">Test Scores</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Test Scores</h4>
        <p class="mg-b-0">View, add and update student test scores</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <form name="form_action" id="form_action" action="process/" method="post">

            <div class="form-layout form-layout-6">

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Student: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <select id="student_no" class="form-control select2-show-search" name="student_no" onChange="$('#subject').html('<img src=\'<?php echo $server; ?>/img/loader.gif\'>'); subject();" required>
                        <option value="">Choose a student</option>
                        <?php if($num_students) { do { ?>
                            <option value="<?php echo $row_students['student_no']; ?>"><?php echo $row_students['studentID'] . " - " . $row_students['first_name'] . " " . $row_students['last_name']; ?></option>
                        <?php } while($row_students = mysqli_fetch_assoc($result_students)); } ?>
                    </select>	
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-sm-12" style="background-color:#FFF; border-left:none">
                  </div><!-- col-8 -->
                </div><!-- row -->    
                
                <div id="subject" class="row no-gutters" style="border-none">
                    <span class="mg-t-30">Subjects will then appear here...</span>
                </div>

                <div class="row no-gutters">
                  <div class="col-sm-12" style="background-color:#FFF; border-left:none">
                  </div><!-- col-8 -->
                </div><!-- row -->
                                
                <div class="row no-gutters">
                  <div class="col-sm-12" style="background-color:#FFF; border-left:none">
                  </div><!-- col-8 -->
                </div><!-- row -->
                
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Security: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Enter Account Password" maxlength="15">
                  </div><!-- col-8 -->
                </div><!-- row -->
                                
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    &nbsp;
                  </div><!-- col-4 -->
                  <div class="form-layout-footer col-7 col-sm-9 bd pd-20 bd-t-0">
                    <input class="btn btn-primary" id="submit" type="submit" style="cursor:pointer" value="Update Student Score"> 
                  </div><!-- col-8 -->
                </div><!-- row -->
                
              </div><!-- form-layout -->
		      </form>
          <div id="message"></div>
          
          <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Notes</p>
          <pre><code class="javascript pd-20">This will update the student test scores. An inactive student is a student without test scores.</code></pre>
          
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
	<?php include('../../../includes/footer.php'); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    
	<?php include('../../../includes/scripts.php'); ?>

    <script language="javascript">
	
        function subject() {
			
			var subject = $("#subject");
			var student_no = $('#student_no').val();
			
			if(student_no != '') {
				
				var dataString = 'student_no='+ student_no;
				
				$.ajax({ 
					   
					type: "POST",
					url: "get_subjects.php",
					data: dataString,
					dataType: 'json',
					success: function(response) {
						
						var subj = '';
						subject.empty();      
						
						for(var i = 0; i < response.length; i++) {
							
							
								if(response[i].score != 'null') {

                  subj += '<div class="col-lg-5 col-md-5 col-10" style="background-color:#FAFAFA">'+response[i].subject+'</div><div class="col-lg-1 col-md-1 col-2"><input class="form-control" type="text" id=st'+response[i].ss_no+' name=st'+response[i].ss_no+' maxlength="2" value="'+response[i].score+'"><div style="margin:-20px 0 0 20px; font-weight:bold">%</div></div>';
																	
								} else {
									
                  subj += '<div class="col-lg-5 col-md-5 col-10" style="background-color:#FAFAFA">'+response[i].subject+'</div><div class="col-lg-1 col-md-1 col-2"><input class="form-control" type="text" id=st'+response[i].ss_no+' name=st'+response[i].ss_no+' maxlength="2"><div style="margin:-20px 0 0 20px; font-weight:bold">%</div></div>';
									
								}
							
							
						}
						
						subject.append(subj);
						
					}
				
				});
				
			} else {
				
				subject.html('<span class="mg-t-30">Subjects will then appear here...</span>');      
				
			}
			
		}

		$('#form_action').submit(function(){
								   
			var student_no = $('#student_no').val();
			
			if(student_no != "") {
				
                $("#message").hide();
                $('#submit')
                .after('<img src="<?php echo $server; ?>/img/ajax-loader.gif" class="loader" style="margin-left:10px" />')
                .attr('disabled','disabled');
				
				$.ajax({
					   
					type : $(this).attr('method'),
					url : $(this).attr('action'),
					data:  new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					beforeSend : function() { },
					success:function(response) {

                        $("#message").html(response);
                        $('#message').slideDown('slow');
                        $('#form_action img.loader').fadeOut('slow',function(){$(this).remove()});
                        $('#submit').removeAttr('disabled');
					
					}
					
				});
				
			} else {
				
				alert('Enter all fields marked as mandatory');
				
			}
			
			return false;
		});

    </script>
    
  </body>
</html>
