    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!-- 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!~~ Include all compiled plugins (below), or include individual files as needed ~~>
    <script src="js/bootstrap.min.js"></script>
 	 <script src="js/bootstrap-paginator.js"></script>
 -->


			  	<div id="site-footer-link" class="row"> <!--site-footer-links div starts-->

					    <div class="col-sm-2"></div>    
					    
					    <div class="col-sm-8   site-footer-links">
			 		        <ul>
					          <li><a href="index.php">Home</a></li>
					          <li>|</li>
					          <li><a href="about-us.php">About us</a></li>
					          <li>|</li>
					          <li><a href="commitee-members.php">Commitee Members</a></li>
					          <li>|</li>
					          <li><a href="news-events.php">News &amp; Events</a></li>
					          <li>|</li>
					          <li><a href="useful-links.php">Useful Links</a></li>
					          <li>|</li>
					          <li><a href="quality-parameters.php">Quality Parameter</a> </li>
					          <li>|</li>
					          <li><a href="toy-guide.php">Toy Guide</a></li>

					        </ul>
				    	</div>
						<div class="col-sm-2"></div>
				</div><!--site-footer-links div ends-->
		
		
		


	</div> <!--home-main div end-->
 </div><!-- body div end-->

			<div class="site-footer" > <!--site footer div start-->
	
			<ul>
			<?php
				 $result = $db->query(getFooterImages);
				
//				 if ($result->num_rows > 0) { 
				if($db->affected_rows > 0){

                          while($row = $result->fetch_assoc()) { ?>

                          	<li><a href="http://<?php echo $row['link']?>" target="_blank" title="<?php echo $row['company_name'] ; ?>"><img src="<?php echo BANNER_FOLDER.$row['Image_name'] ?>" alt="<?php echo $row['company_name'] ; ?>"></a></li>
                  <?php   }
                }
			?>

				
				<!-- 	<li><a href="#"><img src="images/footer/add-01.jpg"></li>
					<li><a href="#"><img src="images/footer/add-02.jpg"></li>
					<li><a href="#"><img src="images/footer/add-03.jpg"></li>
					<li><a href="#"><img src="images/footer/add-04.jpg"></li>
					<li><a href="#"><img src="images/footer/add-05.jpg"></li>
					<li><a href="#"><img src="images/footer/add-06.jpg"></li>
					<li><a href="#"><img src="images/footer/add-07.jpg"></li>
					<li><a href="#"><img src="images/footer/add-08.jpg"></li> -->
					
				</ul>
			</div> <!--site footer div end-->
	
	</div><!-- container div end-->
  </body>
</html>