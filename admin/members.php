<?php include_once "common/header.php"; ?>
<?php $total_members=0;
	  $records_per_page=RECORDS_PER_PAGE;
	  $query = getLimitedMembers;


   function test_input1($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
	  if (isset($_GET["page"])) { 
	  		$page  = $_GET["page"]; 
	  	} else { 
	  		$page=1; 
	  	}; 
		$start_from = ($page-1) * $records_per_page; 


		if(isset($_GET["oper"])){

			if($_SESSION["searchMemberToken"]==$_GET["token"]){

				$_SESSION["searchMemberToken"]="";

				if(!empty($_GET["sercrit"]) AND !empty($_GET["serval"])){

					$searchCriteria = $_GET["sercrit"];
					$searchValue = test_input1($_GET["serval"]);
					$likeExp = "'".$searchValue."%'";
					// echo "searchCriteria :".$searchCriteria." AND search Value : ".$searchValue ;

					if($searchCriteria == MEMBER_SERIAL_NO){
						// echo "Echo searching with membership number";
						$sql = getMemberWithSerialNoCount.$likeExp; 

						// echo $sql;
						 $query = searchMemberWithSerialNo.$likeExp; 
						$result = $db -> query($sql);
						if ($result->num_rows > 0) {
						$total_members=$result->num_rows;
						}
					}else if ($searchCriteria ==  MEMBER_EMAIL) {
						
						// echo "Echo searching with Email";


						$sql = getMemberWithEmailCount.$likeExp; 

						// echo $sql;
						 $query = searchMemberWithEmail.$likeExp;
						 $result = $db -> query($sql);
						if ($result->num_rows > 0) {
							$total_members=$result->num_rows;
						}

					}elseif ($searchCriteria == CONTACT_PERSON) {
						
						// echo "Echo searching with contact person";


						$sql = getMemberWithContactPersonCount.$likeExp; 

						// echo $sql;
						 $query = searchMemberWithContactPerson.$likeExp;
						$result = $db -> query($sql);
						if ($result->num_rows > 0) {
							$total_members=$result->num_rows;
						}

					}elseif ($searchCriteria == COMPANY) {
						
						// echo "Echo searching with company";


						$sql = getMemberWithCompanyCount.$likeExp; 

						// echo $sql;
						 $query = searchMemberWithCompany.$likeExp;
						$result = $db -> query($sql);
						if ($result->num_rows > 0) {
						$total_members=$result->num_rows;
						}
					}else if($searchCriteria == UNAPPROVED){
						
						$sql = getUnapprovedMembers;
						$query =getUnapprovedMembers;
						$result = $db -> query($sql);
						if ($result->num_rows > 0) {
						$total_members=$result->num_rows;

						}
					}


				}else if (!empty($_GET["sercrit"]) ){
					$searchCriteria = $_GET["sercrit"];
					// echo "searchCriteria :".$searchCriteria;

					if($searchCriteria == UNAPPROVED){
						
						$sql = getUnapprovedMembers;
						$query =getUnapprovedMembers;
						$result = $db -> query($sql);
						if ($result->num_rows > 0) {
						$total_members=$result->num_rows;

						}
					}


				}
			}else {

					$result = $db -> query(getMembersCount);
					if ($result->num_rows > 0) {
						$total_members=$result->num_rows;
					}

				}


		}else {

				  	$result = $db -> query(getMembersCount);
					if ($result->num_rows > 0) {
						$total_members=$result->num_rows;
					}

		}


		
 ?>

    
  <div id="members-div"  class="page-background"> <!--home-main starts -->

    <div id="members-page" class="page-contents"> <!-- members-page div starts  -->


       <!--  <?php //$pageName="Notice Board" ?> -->
        <?php include_once "common/inner-nav-bar.php"; ?>

        	 <div id="approve-members-contents" class="row">
	               <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style">

						<div class="row"><!-- div for  search box  starts-->
							<div class="col-sm-3  navbar-form navbar-left">
								<button type="button" onClick="location.href = 'register.php'">Add New Member</button>
							</div>
							

								<form class="navbar-form navbar-right" role="search">

									<?php $newToken= sha1(time());
			                             $_SESSION["searchMemberToken"]=$newToken;
			                             //echo $_SESSION["registerUserToken"];
			                        ?>
									
									<input type="hidden" name="oper" value="ser" />
									<input type="hidden" name = "token" value="<?php echo $newToken?>"/> 
								    <div class="form-group" >
								    	<select class="" name="sercrit">
								        	<option value="">Please select a criteria</option>
								        	<option value="<?php echo MEMBER_SERIAL_NO?>">Membership Number</option>
								        	<option value="<?php echo MEMBER_EMAIL?>">Email Address</option>
								        	<option value="<?php echo CONTACT_PERSON?>">Contact Person</option>
								        	<option value="<?php echo COMPANY?>">Company Name</option>
								        	<option value="<?php echo UNAPPROVED ?>">Unapproved</option>
								        </select>
								    </div>

								    <div class="form-group" >
								        <input type="text" class="rounded-box" placeholder="Search" name="serval">
								    </div>

								    <button type="submit"><span class="glyphicon glyphicon-search"></span></button>
								</form>

							
							

 

						</div><!-- div for  search box ends -->
						<?php 
							if(isset($_GET["id"])){
									
								include_once 'member-profile-details.php';



								
							}else {

								
									$queryWithLimit = $query." LIMIT ". $start_from.",". $records_per_page;
								   $result1 = $db -> query($queryWithLimit);

								   if ($result1->num_rows > 0) { ?>


								<div class="row">

									<p style="text-align:center;"><b>Total <?php echo $total_members; ?> members found.</b></p>

									<div class="col-sm-12" style="line-height:3.2em;padding-right:25px;">
											<div class="row">
												<div class="col-sm-4"><b><u>Member Email</u></b></div>
												<div class="col-sm-4"><b><u>Comapny Name</u></b></div>
												<div class="col-sm-4"><b><u>Contact Person</u></b></div>
											</div>
										</div>	
                  					<?php 	while($row = $result1->fetch_assoc()) {
                  								// echo "\nMEMBER ID :: ".$row["serial_no"];

                  						?>
										<div class="col-sm-12" style="line-height:2.2em;padding-right:25px;">
											<div class="row">
												<div class="col-sm-4"><a href="?id=<?php echo $row["serial_no"]?>"><?php echo $row["email"] ?></a></div>
												<div class="col-sm-4"><?php echo $row["company_name"] ?></div>
												<div class="col-sm-4"><?php echo $row["contact_person"] ?></div>
	
											</div>
										</div>	

                  						<?php 



                  						} ?>
                  			
								</div>

                  			<?php } //if ends
                  				else {
                  					?> <p style="text-align:center;"><?php echo NO_SEARCH_RESULT ?></p> <?php ;
                  				}
							}


						?>

					
					<div  style="text-align: center;">
							<ul class = "pagination pagination-sm">
								<?php 
								if(!isset($_GET["id"])){
										
										// echo "total members :".$total_members;
										$total_pages = ceil($total_members/$records_per_page);	


										echo "<li><a href='members.php?page=1'>".'&laquo;'."</a></li>"; // Goto 1st page  

										for ($i=1; $i<=$total_pages; $i++) { 
										       echo "<li><a href='members.php?page=".$i."'>".$i."</a></li> "; 
										}; 
										echo "<li><a href='members.php?page=".$total_pages."'>".'&raquo;'."</a></li>"; 
								}



								?>
							</ul>

					</div>
					

	               </div>
	 			 </div>



    
    </div> <!-- approve-members-page div ends -->  
    
    </div> <!-- members-page div ends -->  


<?php include_once "common/footer.php"; ?>