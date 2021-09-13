<?php if(isset($_SESSION['msg'])) { ?>
	<script>alert('<?php echo $_SESSION['msg']; ?>');</script>
<?php } unset($_SESSION['msg']); ?>
  
<?php if($filename2 != "brave") { ?>
<footer class="br-footer">
   	<div class="footer-left">
       	<div class="mg-b-2">Copyright &copy; <?php echo date("Y"); ?> Femi Omotesho</div>
	</div>
    <div class="footer-right tx-right">
       	<div class="mg-b-2">
			<a href="mailto:femiomotesho@icloud.com">femiomotesho@icloud.com</a> | <a href="tel:+2348102112212">+234 (810) 211-2212</a>
		</div>
    </div>
</footer>
<?php } ?>

<div id="tweet" class="media-list col-8 col-sm-7 col-md-6 col-lg-4 col-xl-3 pd-0" style="position:fixed; bottom: 20px; right: 10px; border:solid 1px #666666; display:none" >

  <a href="<?php echo $server; ?>/app/notifications" class="media-list-link read">
	<div class="media pd-x-20 pd-y-15">
	  <span id="al_photo"></span>
	  <div class="media-body">
		<p id="al_desc" class="tx-13 mg-b-0 tx-gray-700"></p>
		<span id="al_date" class="tx-12"></span>
	  </div>
	</div>
  </a>

</div>


