    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Femi Omotesho">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $server; ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $server; ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $server; ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $server; ?>/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo $server; ?>/img/favicon/safari-pinned-tab.svg" color="#d56e5b">
    <link rel="shortcut icon" href="<?php echo $server; ?>/img/favicon/favicon.ico">
    
    <!-- Vendor CSS -->
    <link href="<?php echo $server; ?>/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $server; ?>/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    
    <?php if($filename2 == "user_info" || $filename2 == "change_password") { ?>
        <link href="<?php echo $server; ?>/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
        <link href="<?php echo $server; ?>/lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
        <link href="<?php echo $server; ?>/lib/highlightjs/github.css" rel="stylesheet">
    <?php } ?>

    <?php if($filename2 == "app" || $filename2 == "subjects" || $filename2 == "classes" || $filename2 == "add_student" || $filename2 == "view_students" || $filename2 == "edit_student" || $filename2 == "scores" || $filename2 == "view_reports" || $filename2 == "notifications") { ?>
        <link href="<?php echo $server; ?>/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
        <link href="<?php echo $server; ?>/lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
        <link href="<?php echo $server; ?>/lib/highlightjs/github.css" rel="stylesheet">
        <link href="<?php echo $server; ?>/lib/select2/css/select2.min.css" rel="stylesheet">
        <link href="<?php echo $server; ?>/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <?php } ?>
        
    <!-- Brave CSS -->
    <link rel="stylesheet" href="<?php echo $server; ?>/css/brave.css">

    <style>
	.tx-fade {
		color: #CCC;
	}
	</style>
