<?php
include('../../includes/global.php'); include('../../includes/auth.php'); 

if(isset($_GET['sec'])) {
	echo "<meta http-equiv='refresh' content='0;url=".$server."/app/classes/#table'>"; exit();
}

$sql_ann = "SELECT * FROM classes ORDER BY class_no DESC";
$result_ann = mysqli_query($connect,$sql_ann) or die("Couldn't execute query classes.");
$row_ann = mysqli_fetch_assoc($result_ann); $num_ann = mysqli_num_rows($result_ann);

$sql_ann2 = "SELECT * FROM classes ORDER BY class_no DESC";
$result_ann2 = mysqli_query($connect,$sql_ann2) or die("Couldn't execute query classes 2.");
$row_ann2 = mysqli_fetch_assoc($result_ann2); $num_ann2 = mysqli_num_rows($result_ann2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>Classes - Management System | Brave</title>
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
    
    	<div class="br-pageheader pd-y-15 pd-l-20" style="margin-left:-10px">
        	<nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="<?php echo $server; ?>/app">Dashboard</a>
                <span class="breadcrumb-item active">Classes</span>
        	</nav>
		  </div><!-- br-pageheader -->
      
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        	<h4 class="tx-gray-800 mg-b-5">Classes</h4>
            <p class="mg-b-0">Update classes</p>
        </div>
        
        <div class="br-pagebody">
        	<div class="br-section-wrapper">
            	<form name="form" id="form" action="process/" method="post">
                <input type="hidden" name="action" value="new">
            		<div class="form-layout form-layout-6">
                
                    <div class="row no-gutters">
                      <div class="col-5 col-sm-3">
                        Class Name: <span class="tx-danger">*</span>
                      </div><!-- col-4 -->
                      <div class="col-7 col-sm-9">
                        <input class="form-control" type="text" id="class_name" name="class_name" maxlength="38" required>
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
                        <input class="btn btn-primary" id="submit" type="submit" style="cursor:pointer" value="Add Class"> 
                      </div><!-- col-8 -->
                    </div><!-- row -->
                        
              	</div><!-- form-layout -->
             </form>   
             <div id="message" style="width:100%"></div>
             
          <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Notes</p>
          <pre><code class="javascript pd-20">
          This will add a new class.
          See all classes in the table below
          </code></pre>
             
            </div><!-- br-section-wrapper -->
          </div><!-- br-pagebody -->
          
          <div class="br-pagebody">
            <div class="br-section-wrapper">
            
                  <div class="table-wrapper">
                  
                    <a name="table"></a>
                    <table id="datatable" class="table display responsive nowrap" style="width:100%">
                      <thead>
                        <tr>
                          <th class="wd-5p">SN</th>
                          <th class="wd-10p">Actions</th>
                          <th class="wd-50p">Class</th>
                          <th class="wd-10p">Students</th>
                          <th class="wd-20p">Posted</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if($num_ann != 0) { $i = 1; do { 
                        
                        $sql_students = "SELECT * FROM students WHERE class_no = '$row_ann[class_no]'";
                        $result_students = mysqli_query($connect,$sql_students) or die("Couldn't execute query students");
                        $row_students = mysqli_fetch_assoc($result_students); $num_students = mysqli_num_rows($result_students);
                                        
                      ?>
                        <tr>
                        
                          <td><?php echo $i++; ?></td>
                          
                          <td>       
                            <a href="javascript:" class="btn btn-info btn-icon" data-toggle="modal" data-target="#modaldemo<?php echo $row_ann['class_no']; ?>" data-toggle="tooltip" data-placement="top" title="Edit <?php echo $row_ann['class_name']; ?>"><div style="height:22px"><i class="fa fa-pencil"></i></div></a>
                            <?php if($row_ann['status'] == '2') { ?>
                              <a href="<?php echo $server."/app/classes/process/?action=disable&no=".$row_ann['class_no']."&name=".$row_ann['class_name']; ?>" class="btn btn-warning btn-icon" data-toggle="tooltip" data-placement="top" title="Disable <?php echo $row_ann['class_name']; ?>"><div style="height:22px"><i class="fa fa-ban"></i></div></a>
                            <?php } else {?>
                              <a href="<?php echo $server."/app/classes/process/?action=enable&no=".$row_ann['class_no']."&name=".$row_ann['class_name']; ?>" class="btn btn-success btn-icon" data-toggle="tooltip" data-placement="top" title="Enable <?php echo $row_ann['class_name']; ?>"><div style="height:22px"><i class="fa fa-ban"></i></div></a>
                            <?php } ?>
                            <a href="<?php echo $server."/app/classes/process/?action=delete&no=".$row_ann['class_no']."&name=".$row_ann['class_name']; ?>" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete <?php echo $row_ann['class_name']; ?>" onClick="return confirm('Are you sure..?');"><div style="height:22px"><i class="fa fa-close"></i></div></a>
                          </td>

                          <td style="font-weight: 400; letter-spacing: 1px; word-spacing: 2px">
                            <?php echo $row_ann['class_name']; ?>
                          </td>

                          <td><?php echo number_format($num_students); ?></td>
                                            
                          <td><?php echo date("Y M d D g:ia",strtotime($row_ann['dateposted'])); ?></td>
                          
                        </tr>
                       <?php } while($row_ann = mysqli_fetch_assoc($result_ann)); } ?>
                      </tbody>
                    </table>
                  </div><!-- table-wrapper -->
                  
                  <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Notes</p>
                  <pre><code class="javascript pd-20">
                  Hover your pointer on the icons to see their actions. You cannot delete a class with students enrolled in
                  </code></pre>
            
            </div><!-- br-section-wrapper -->
          </div><!-- br-pagebody -->

		<?php include('../../includes/footer.php'); ?>
        
    </div>

          <!-- LARGE MODAL -->
          <?php if($num_ann2 != 0) { do { ?>
          <div id="modaldemo<?php echo $row_ann2['class_no']; ?>" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content tx-size-sm">
       	       <form name="form<?php echo $row_ann2['class_no']; ?>" id="form<?php echo $row_ann2['class_no']; ?>" action="process/" method="post">
                <div class="modal-header pd-x-20">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Class - <?php echo $row_ann2['class_name']; ?></h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
                <div class="modal-body pd-20 wd-750">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="no" value="<?php echo $row_ann2['class_no']; ?>">

            		<div class="form-layout form-layout-6">
                
                    <div class="row no-gutters">
                      <div class="col-5 col-sm-3">
                        Class Name: <span class="tx-danger">*</span>
                      </div><!-- col-4 -->
                      <div class="col-7 col-sm-9">
                        <input class="form-control" type="text" id="class_name" name="class_name" maxlength="38" value="<?php echo $row_ann2['class_name']; ?>" required>
                      </div><!-- col-8 -->
                    </div><!-- row -->
                                                                                                    
              	</div><!-- form-layout -->
                </div><!-- modal-body -->
                <div class="modal-footer">
                  <input class="btn btn-primary tx-size-xs" id="submit<?php echo $row_ann2['class_no']; ?>" type="submit" style="cursor:pointer" value="Save changes">
                  <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Close</button>
                </div>
             </form>   
             <div id="message<?php echo $row_ann2['class_n0']; ?>"></div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
          <?php } while($row_ann2 = mysqli_fetch_assoc($result_ann2)); } ?>

    <!-- ########## END: MAIN PANEL ########## -->
    
    <?php include('../../includes/scripts.php'); ?>

</body>
</html>
