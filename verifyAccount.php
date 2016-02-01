<?php include_once "common/header.php"; 

//verifyAccount.php?oper=ver&ver=6fdc6c1a28604d5bbabf2c027fe3ddcbe7fbd912&em=madhulika@abc.com

    if(isset($_GET["oper"]) &&isset($_GET['ver']) && isset($_GET['em']))
    {	
    	// echo "this is a get request";
    		include_once "user-operations.php"; 
        

         $statusCode = $status[0]; 
         $statusMsg = $status[1];


    }


?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="notice-board-page" class="page-contents"> <!--nnotice-board-page div starts  -->


       <!--  <?php //$pageName="Notice Board" ?> -->
        <?php include_once "common/inner-nav-bar.php"; ?>
                <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style">

        <p style="text-align:center;"><?php echo  $statusMsg ?><br/>
          <?php if($statusCode ==SUCCESS) {  ?>
            <a href="index.php">Login Here</a>

            <?php } ?></p>
    </div>
    
    </div> <!-- notice-board-page div ends -->  


<?php include_once "common/footer.php"; ?>