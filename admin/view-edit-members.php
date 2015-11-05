<?php include_once "common/header.php"; ?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="approve-members" class="page-contents"> <!---approve-members-page div starts  -->

        <?php include_once "common/inner-nav-bar.php"; ?>



	 <div id="approve-members-contents" class="row">
	               <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style">
						
						<?php 
							if(isset($_GET["id"])){
									
								include_once 'member-profile-details.php';



								
							}else {
								   $result = $db -> query(getUnapprovedMembers);
								   if ($result->num_rows > 0) {?>

									<ol>
                  					<?php 	while($row = $result->fetch_assoc()) {
                  								// echo "\nMEMBER ID :: ".$row["serial_no"];

                  						?>
										<li><a href="?id=<?php echo $row["serial_no"]?>"><?php echo $row["email"] ?></a></li>

                  						<?php 



                  						} ?>
                  			
									 </ol>

                  			<?php } //if ends

							}


						?>



	               </div>
	  </div>



    
    </div> <!-- approve-members-page div ends -->  


<?php include_once "common/footer.php"; ?>