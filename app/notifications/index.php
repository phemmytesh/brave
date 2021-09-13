<?php
include('../../includes/global.php'); include('../../includes/auth.php'); 

$sql_alerts2 = "SELECT * FROM user_activities ORDER BY dateposted DESC";
$result_alerts2 = mysqli_query($connect,$sql_alerts2) or die("Couldn't execute query alerts 2");
$row_alerts2 = mysqli_fetch_assoc($result_alerts2); $num_alerts2 = mysqli_num_rows($result_alerts2);

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <title>Notifications: Management System | Brave</title>
	<?php include('../../includes/meta.php'); ?>
    
  </head>

  <body>

    <!-- ########## START: LEFT PANEL ########## -->
    <?php include('../../includes/left-panel.php'); ?>
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
	  <?php include('../../includes/head-panel.php'); ?>
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo $server; ?>/app">Dashboard</a>
          <span class="breadcrumb-item active">Notifications</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Notifications</h4>
        <p class="mg-b-0">View all alerts.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

          <div class="table-wrapper">
            <table id="datatable" class="table display responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th class="wd-5p">SN</th>
                  <th class="wd-80p">Description</th>
                  <th class="wd-15p">Timestamp</th>
                </tr>
              </thead>
              <tbody>
              <?php if($num_alerts2 != 0) { $i = 1; do { ?>
                <tr>
                
                  <td><?php echo $i++; ?></td>
                  
                  <td>
                      <?php echo $row_alerts2['description']; ?>
                  </td>
			 
                 <td>
                    <?php echo date("l d-M-Y g:ia",strtotime($row_alerts2['dateposted'])); ?><br>
                 </td>
                                   
                </tr>
               <?php } while($row_alerts2 = mysqli_fetch_assoc($result_alerts2)); } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
	<?php include('../../includes/footer.php'); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    
	<?php include('../../includes/scripts.php'); ?>
  </body>
</html>
