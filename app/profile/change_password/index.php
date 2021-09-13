<?php
include('../../../includes/global.php'); include('../../../includes/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Change Password - Profile: Management System | Brave</title>
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
          <a class="breadcrumb-item" href="javascript:">My Profile</a>
          <span class="breadcrumb-item active">Change Password</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Change Password</h4>
        <p class="mg-b-0">Create a new password.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <form name="form" id="form" action="process/" method="post">
              <div class="form-layout form-layout-6">
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Current Password: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <input required class="form-control" type="password" id="opassword" name="opassword" placeholder="Enter your current password you wish to change" maxlength="15">
                  </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    New Password: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <input required class="form-control" type="password" id="password" name="password" placeholder="Enter the new password you wish to use" maxlength="15">
                  </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    Confirm Password: <span class="tx-danger">*</span>
                  </div><!-- col-4 -->
                  <div class="col-7 col-sm-9">
                    <input required class="form-control" type="password" id="cpassword" name="cpassword" placeholder="Re-enter the new password you wish to use" maxlength="15">
                  </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                  <div class="col-5 col-sm-3">
                    &nbsp;
                  </div><!-- col-4 -->
                  <div class="form-layout-footer col-7 col-sm-9 bd pd-20 bd-t-0">
                    <input class="btn btn-primary" id="submit" type="submit" style="cursor:pointer" value="Change Password"> 
                  </div><!-- col-8 -->
                </div><!-- row -->
              </div><!-- form-layout -->
		  </form>
          <div id="message"></div>
          
          <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Notes</p>
          <pre><code class="javascript pd-20">This will change your password and security passcode for logging into and using the system. All fields with <span class="tx-danger">*</span> are mandatory</code></pre>
          
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
	<?php include('../../../includes/footer.php'); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    
	<?php include('../../../includes/scripts.php'); ?>
</body>
</html>
