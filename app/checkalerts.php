<?php
include('../includes/global.php'); 

if(isset($_SESSION['lastlogin_time'])) {

    $sql_alerts = "SELECT * FROM user_activities WHERE dateposted >= '$_SESSION[lastlogin_time]' ORDER BY dateposted DESC LIMIT 0 , 1";
  
  } else {
  
    $sql_alerts = "SELECT * FROM user_activities ORDER BY dateposted DESC LIMIT 0 , 1";
    
  }
  
  $result_alerts = mysqli_query($connect,$sql_alerts) or die("Couldn't execute query alerts");
  $row_alerts = mysqli_fetch_assoc($result_alerts); $num_alerts = mysqli_num_rows($result_alerts);
  
  if($num_alerts) {
  
    $i = 1;
  
    do {
  
        if($i == 1) { 
  
          if(!isset($_SESSION['last_alert'])) {
          
            $_SESSION['last_alert'] = $row_alerts['dateposted'];
            $_SESSION['red'] = 'yes';
            $response = 'new_but_same';
  
          } else {
  
            if($_SESSION['last_alert'] != $row_alerts['dateposted']) {
  
              $_SESSION['red'] = 'yes';
              $_SESSION['last_alert'] = $row_alerts['dateposted']; 

              $sql_user = "SELECT * FROM users WHERE user_no = '$row_alerts[user_no]'";
              $result_user = mysqli_query($connect,$sql_user) or die("Couldn't execute query alert user.");
              $row_user = mysqli_fetch_assoc($result_user);
      
              $response = 'new|'.$row_user['photo'].'|'.$row_alerts['description'].'|'.date('F d, Y g:ia', strtotime($row_alerts['dateposted']));
  
            } else {
  
              unset($_SESSION['red']);
              $response = 'same';
  
            }
  
          }
        
        }
    
        $i++; 
  
    } while($row_alerts = mysqli_fetch_assoc($result_alerts));
  
    unset($i);
  
  }  

echo $response;

?>