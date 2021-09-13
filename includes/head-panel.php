<?php

if(isset($_SESSION['lastlogin_time'])) {

  $sql_alerts = "SELECT * FROM user_activities WHERE dateposted >= '$_SESSION[lastlogin_time]' ORDER BY dateposted DESC LIMIT 0 , 5";

} else {

  $sql_alerts = "SELECT * FROM user_activities ORDER BY dateposted DESC LIMIT 0 , 5";
  
}

$result_alerts = mysqli_query($connect,$sql_alerts) or die("Couldn't execute query alerts");
$row_alerts = mysqli_fetch_assoc($result_alerts); $num_alerts = mysqli_num_rows($result_alerts);

$al_photo = array();
$al_desc = array();
$al_date = array();

if($num_alerts) {

  $i = 1;

  do {

      if($i == 1) { 

        if(!isset($_SESSION['last_alert'])) {
        
          $_SESSION['last_alert'] = $row_alerts['dateposted'];
          $_SESSION['red'] = 'yes';

        } else {

          if($_SESSION['last_alert'] != $row_alerts['dateposted']) {

            $_SESSION['red'] = 'yes';
            $_SESSION['last_alert'] = $row_alerts['dateposted']; 

          } else {

            unset($_SESSION['red']);

          }

        }
      
      }

      $sql_user = "SELECT * FROM users WHERE user_no = '$row_alerts[user_no]'";
      $result_user = mysqli_query($connect,$sql_user) or die("Couldn't execute query alert user.");
      $row_user = mysqli_fetch_assoc($result_user);

      array_push($al_photo, $row_user['photo']);
      array_push($al_desc, $row_alerts['description']);
      array_push($al_date, $row_alerts['dateposted']);

      $i++; 

  } while($row_alerts = mysqli_fetch_assoc($result_alerts));

  unset($i);

}

?>
    
    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div><!-- br-header-left -->
      
      <div class="br-header-right">
        <nav class="nav">

          <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown" onClick="red();">
              <i class="icon ion-ios-bell-outline tx-24"></i>
                <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle" <?php if(!isset($_SESSION['red'])) { echo 'style="display:none"'; } ?> id="red"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-300 pd-0-force">
              <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
                <label class="tx-12 tx-info tx-uppercase tx-semibold tx-spacing-2 mg-b-0">Alerts</label>
                <a href="" class="tx-11"><?php echo 'Last Login: '.date('M d, Y g:ia',strtotime($_SESSION['lastlogin_time'])); ?></a>
              </div><!-- d-flex -->

              <div class="media-list">

              <span id="tweet2">
                <a href="<?php echo $server; ?>/app/notifications" class="media-list-link read">
                <div class="media pd-x-20 pd-y-15">
                  <span id="al_photo2"></span>
                  <div class="media-body">
                  <p id="al_desc2" class="tx-13 mg-b-0 tx-gray-700"></p>
                  <span id="al_date2" class="tx-12"></span>
                  </div>
                </div>
                </a>
              </span>

              <?php if($num_alerts) { foreach($al_photo as $key => $value) { ?>

                <a href="<?php echo $server; ?>/app/notifications" class="media-list-link read">
                  <div class="media pd-x-20 pd-y-15">
                  <?php if($value == '') { ?>
                    <img src="<?php echo $server; ?>/img/male.jpg" class="wd-32 rounded-circle" alt="" style="height: 40px">
                    <?php } else { ?>
                      <img src="<?php echo $server; ?>/img/users/<?php echo $value; ?>" class="wd-32 rounded-circle" alt="" style="height: 40px">
                    <?php } ?>
                    <div class="media-body">
                      <p class="tx-13 mg-b-0 tx-gray-700"><?php echo $al_desc[$key]; ?></p>
                      <span class="tx-12"><?php echo date('F d, Y g:ia', strtotime($al_date[$key])); ?></span>
                    </div>
                  </div>
                </a>

              <?php }  } else { ?>

                  <div class="media pd-x-20 pd-y-15">
                    <div class="media-body">
                      <p class="tx-13 mg-b-0 tx-gray-700">No new notifications</p>
                    </div>
                  </div>

              <?php } ?>

                <div class="pd-y-10 tx-center bd-t">
                  <a href="<?php echo $server; ?>/app/notifications" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Show All Notifications</a>
                </div>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span id="ch_first_name" class="logged-name hidden-md-down">
                <?php echo $row['first_name']; ?>
              </span>
              <?php if($row['photo'] == '') { ?>
                <img src="<?php echo $server; ?>/img/male.jpg" class="wd-32 rounded-circle" alt="" style="height: 32px">
              <?php } else { ?>
                <img src="<?php echo $server; ?>/img/users/<?php echo $row['photo']; ?>" class="wd-32 rounded-circle" alt="" style="height: 32px">
              <?php } ?>
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href="<?php echo $server; ?>/app/profile/user_info"><i class="icon ion-ios-person"></i> Update Profile</a></li>
                <li><a href="<?php echo $server; ?>/sign_out"><i class="icon ion-power"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
      </div><!-- br-header-right -->
    </div><!-- br-header -->
