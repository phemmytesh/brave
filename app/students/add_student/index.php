<?php
include('../../../includes/global.php'); include('../../../includes/auth.php');

$sql_classes = "SELECT * FROM classes WHERE status = '2'";
$result_classes = mysqli_query($connect,$sql_classes) or die(mysqli_error());
$row_classes = mysqli_fetch_assoc($result_classes); $num_classes = mysqli_num_rows($result_classes); 

$sql_subjects = "SELECT * FROM subjects WHERE status = '2'";
$result_subjects = mysqli_query($connect,$sql_subjects) or die(mysqli_error());
$row_subjects= mysqli_fetch_assoc($result_subjects); $num_subjects = mysqli_num_rows($result_subjects); 

?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Add Student - Students: Management System | Brave</title>
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
          <span class="breadcrumb-item active">Add New Student</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Add New Student</h4>
        <p class="mg-b-0">Add a new student</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <form name="form_action" id="form_action" action="../process/" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="new" />
            <input type="hidden" id="photo3" name="photo3" value="yes">

            <div class="form-layout form-layout-6">

              <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Photo:
                  </div><!-- col-4 -->
                  <div class="col-5 col-sm-8">
                    <label class="custom-file-label" id="la_photo" for="photo">Choose photo file...</label>
                    <p style="width:100%; font-size:11px; margin-bottom:0">Choose a .jpeg, .jpg, or .png file less than 5MB</p>
                    <input type="file" id="photo" name="photo" onChange="la_photo();" style="display:none">
                  </div><!-- col-8 -->
                  <div class="col-2 col-sm-1">
                    <div id="preview">
                        <img src="<?php echo $server; ?>/img/male.jpg" style="height:50px">
                    </div>
                  </div>
                </div><!-- row -->

                <div id="msg"></div>

                <div class="row no-gutters">
                  <div class="col-sm-12" style="background-color:#FFF; border-left:none">
                  </div><!-- col-8 -->
                </div><!-- row -->
              
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    First Name: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
	                  <input class="form-control" type="text" id="first_name" name="first_name" maxlength="18" required>
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Last Name: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
	                  <input class="form-control" type="text" id="last_name" name="last_name" maxlength="18" required>
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Birthday: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <input class="form-control" type="text" id="birth_date" name="birth_date" placeholder="MM/DD/YYYY" required>
                  </div><!-- col-8 -->
                </div><!-- row -->
                                                
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Address Line: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <textarea class="form-control" type="text" id="address" name="address" required></textarea>
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-sm-12" style="background-color:#FFF; border-left:none">
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Emergency Contact Full Name: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
	                  <input class="form-control" type="text" id="full_name" name="full_name" maxlength="38" required>
                  </div><!-- col-8 -->
                </div><!-- row -->
                
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Phone Number: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <input class="form-control" type="text" id="contact_phone" name="contact_phone" maxlength="14" required>
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-sm-12" style="background-color:#FFF; border-left:none">
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Class: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <select id="class_no" class="form-control select2-show-search" name="class_no" required>
                        <option value="">Choose a class</option>
                        <?php if($num_classes) { do { ?>
                            <option value="<?php echo $row_classes['class_no']; ?>"><?php echo $row_classes['class_name']; ?></option>
                        <?php } while($row_classes = mysqli_fetch_assoc($result_classes)); } ?>
                    </select>	
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Year: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <select id="year" class="form-control select2-show-search" name="year" required>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                    </select>	
                  </div><!-- col-8 -->
                </div><!-- row -->

                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Subjects: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <select id="subject_no" class="form-control select2-show-search" multiple name="subject_no[]" required>
                        <?php if($num_subjects) { do { ?>
                            <option value="<?php echo $row_subjects['subject_no']; ?>"><?php echo $row_subjects['title']; ?></option>
                        <?php } while($row_subjects = mysqli_fetch_assoc($result_subjects)); } ?>
                    </select>	
                    <p style="width:100%; font-size:11px; margin-bottom:0">Choose as many subjects</p>
                  </div><!-- col-8 -->
                </div><!-- row -->

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
                    <input class="btn btn-primary" id="submit" type="submit" style="cursor:pointer" value="Add Student"> 
                  </div><!-- col-8 -->
                </div><!-- row -->
                
              </div><!-- form-layout -->
		      </form>
          <div id="message"></div>
          
          <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Notes</p>
          <pre><code class="javascript pd-20">This will add a new student to the system. All fields with <span class="tx-danger">*</span> are mandatory</code></pre>
          
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
	<?php include('../../../includes/footer.php'); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    
	<?php include('../../../includes/scripts.php'); ?>

    <script language="javascript">
	
		function la_photo() {
			
			$('#la_photo').html($('#photo').val());
			
			$("#preview").html('<img src="<?php echo $server; ?>/img/loader.gif" style="height:50px">');
			
			var dataimg = new FormData();   
			dataimg.append('photo', $("#photo")[0].files[0]);
			dataimg.append('action', 'photo');
			
  			$.ajax({
				   
				type : 'POST',
				url : '../process/',
   				data:  dataimg,
   				contentType: false,
         		cache: false,
   				processData:false,
				beforeSend : function() { },
				success:function(response) { 

                    if(response == 'heavy_photo') {

                        $("#msg").html('<div class="error_message" style="margin-top: 20px"><i class="flaticon-alert-1"></i> Photo is too large! Must be less than 5MB.</div>');
                        $("#preview").html('<img src="<?php echo $server; ?>/img/male.jpg" style="height:50px">');
                        $("#photo3").val('no');

                    } else if(response == 'upload_error') {

                        $("#msg").html('<div class="error_message" style="margin-top: 20px"><i class="flaticon-alert-1"></i> An error occurred while uploading the photo.</div>');
                        $("#preview").html('<img src="<?php echo $server; ?>/img/male.jpg" style="height:50px">');
                        $("#photo3").val('no');

                    } else if(response == 'invalid_file') {

                        $("#msg").html('<div class="error_message" style="margin-top: 20px"><i class="flaticon-alert-1"></i> Invalid photo file.</div>');
                        $("#preview").html('<img src="<?php echo $server; ?>/img/male.jpg" style="height:50px">');
                        $("#photo3").val('no');

                    } else if(response == 'no_file') {

                        $("#msg").html('<div class="error_message" style="margin-top: 20px"><i class="flaticon-alert-1"></i> No photo file selected.</div>');
                        $("#preview").html('<img src="<?php echo $server; ?>/img/male.jpg" style="height:50px">');
                        $("#photo3").val('no');

                    } else {
                    
                        $("#preview").html(response);
                        $("#msg").html('');
                        $("#photo3").val('yes');
                    
                    }
                
                }
				
			});

		}

    $('#form_action').submit(function(){
								   
			var first_name = $("#first_name").val();
			var last_name = $("#last_name").val();
			var birth_date = $("#birth_date").val();
			var address = $("#address").val();
			var full_name = $("#full_name").val();
			var contact_phone = $("#contact_phone").val();
			var class_no = $("#class_no").val();
			var subject_no = $("#subject_no").val();

			if(first_name != "" && last_name != "" && birth_date != "" && address != "" && full_name != "" && contact_phone != "" && class_no != "" && subject_no != "") {
				
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
					success : function(response) {

                        $("#message").html(response);
                        $('#message').slideDown('slow');
                        $('#form_action img.loader').fadeOut('slow',function(){$(this).remove()});
                        $('#submit').removeAttr('disabled');

                        if(response.match('success') != null) { 

                            window.location = '<?php echo $server; ?>/app/students/view_students';

                        }
						
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
