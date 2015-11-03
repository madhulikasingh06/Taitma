<?php include_once "common/header.php"; ?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="notice-board-page" class="page-contents"> <!--nnotice-board-page div starts  -->


        <?php include_once "common/inner-nav-bar.php"; ?>
                <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style">

<!--         <p>Your registration was successful. <br/>We've sent you a verification link to your email.Please verify your account!</p>
 -->

		<?php 
			  // include_once "user-operations.php"; 
		         $statusCode = $status[0]; 
         		$statusMsg = $status[1];

		?>

		        <p style="text-align:center;"><?php echo  $statusMsg ?></p>
	


     </div>
    
    </div> <!-- notice-board-page div ends -->  


<?php include_once "common/footer.php"; ?>