<?php
include('includes/global.php'); ?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<?php

$filename2 = "brave";

if(isset($_SESSION['authenticate']) && isset($_SESSION['user_no'])) { 

	if($_SESSION['authenticate'] == 'users') {

?>

		<script>
        // similar behavior as an HTTP redirect
        window.location.replace("<?php echo $server."/app"; ?>");
        </script>

<?php	

		exit();

	}
}

?>

<head>

	<title>Login: Management System | Brave</title>
	<?php include('includes/meta.php'); ?>
    
</head>

<body>

	<div class="d-flex align-items-center justify-content-center ht-100v" style="background-color:#000">

    	<div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        	<div class="signin-logo tx-center tx-28 tx-bold tx-inverse">
				<span class="tx-normal">
					<img src="<?php echo $server; ?>/img/logo.png" style="width: 200px" />
				</span>
			</div>
        	<div class="tx-center mg-b-30 mg-t-10"></div>

        	<form name="form" id="form" action="process/" method="post">
                <?php if(isset($_GET['pag'])) { ?>
                <input type="hidden" name="pag" value="<?php echo $_GET['pag']; ?>" />
                <?php } ?>
        		<div class="form-group">
                	<input type="text" name="email" id="email" class="form-control" placeholder="Enter your email address" maxlength="55" required>
                </div>
        		<div class="form-group">
			        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" maxlength="15" required>
          			<!-- <a href="<?php echo $server; ?>/reset_password" class="tx-info tx-12 d-block mg-b-10 tx-right">Forgot password?</a> -->
                </div>
        		<div class="form-group">
                    <button type="submit" class="btn btn-info btn-block" style="cursor:pointer">Sign In</button>
                </div>
			</form>
                                  
          	<div id="message"></div>
            
            <div class="tx-center">
                <span class="tx-12">
					Copyright &copy; <?php echo date("Y"); ?> Femi Omotesho<br>
					<a href="mailto:femiomotesho@icloud.com">femiomotesho@icloud.com</a><br>
					<a href="tel:+2348102112212">+234 (810) 211-2212</a>
				</span>
			</div>
            
        </div><!-- login-wrapper -->
      
    </div><!-- d-flex -->
    
    <?php include('includes/footer.php'); ?>
    
    <?php include('includes/scripts.php'); ?>

</body>
</html>
