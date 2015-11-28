<?php include_once "common/header.php"; ?>
<?php $total_members=0;

		if(isset($_GET["recs"]) && !empty($_GET["recs"])){
				  $records_per_page=intval($_GET["recs"]);

		}else {
				 $records_per_page=RECORDS_PER_PAGE;

		}


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

        <?php include_once "common/inner-nav-bar.php"; ?>

        	 <div id="approve-members-contents" class="row">
	               <div class="col-sm-offset-1  col-sm-10 trasparent-bg  page-content-style">
					
					<?php  if(!isset($_GET["id"])){ ?>
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
						<?php }

							if(isset($_GET["id"])){
									
								include_once 'member-profile-details.php';



								
							}else {

								
									$queryWithLimit = $query." LIMIT ". $start_from.",". $records_per_page;
								   $result1 = $db -> query($queryWithLimit);

								   if ($result1->num_rows > 0) { 
								   	?>


								<div class="row">

									<p style="text-align:center;"><b>Total <?php echo $total_members; ?> members found.</b></p>

									<div class="col-sm-12" style="font-size:12px;padding-top:10px;padding-bottom:20px;">
											<div class="row">
												<div class="col-sm-2"><b><u>Email</u></b></div>
												<div class="col-sm-2"  style="text-align:center;"><b><u>Membership No.</u></b></div>
												<div class="col-sm-2"><b><u>Comapny Name</u></b></div>
												<div class="col-sm-2"><b><u>Contact Person</u></b></div>
												<div class="col-sm-1"><b><u>Region</u></b></div>
												<div class="col-sm-1"><b><u>Status</u></b></div>
												<div class="col-sm-2"><b><u>Member Type</u></b></div>												
											</div>
										</div>	
                  					<?php 	while($row = $result1->fetch_assoc()) {
                  								// echo "\nMEMBER ID :: ".$row["serial_no"];

                  								$memberType_id =$row["member_type"];	
                  								$serial_no = intval($row["serial_no"]);									        
                  								$sql_mt = "SELECT member_desc FROM Members_Type WHERE member_type='$memberType_id'";
										         if($result_mt = $db->query($sql_mt)){
										             while ($obj = $result_mt->fetch_object()) {
										                       $memberType =  $obj->member_desc;
										             }

										         }

										         $sql_approved_status = $db -> prepare(getMemberStatus);
										         $sql_approved_status -> bind_param("i",$serial_no);
										         if($sql_approved_status->execute()){
										         	$sql_approved_status -> bind_result($verification_status_desc);
										         	while ( $sql_approved_status -> fetch()) {
										         	    $member_status=$verification_status_desc;
										         	}

										         }



                  						?>
										<div class="col-sm-12" style="line-height:2.2em;font-size:12px;">
											<div class="row">
												<div class="col-sm-2" ><a href="?id=<?php echo $row["serial_no"]?>" class="<?php if($member_status=='Verified') echo ' error';?>"><?php echo $row["email"] ?></a></div>												
												<div class="col-sm-2<?php if(empty($row["membership_no"])){echo ' error' ;} ?>" style="text-align:center;"><?php if(!empty($row["membership_no"])){echo $row["membership_no"]; } else {echo 'Pending Approval';}  ?></div>
												<div class="col-sm-2"><?php echo ucfirst($row["company_name"]); ?></div>
												<div class="col-sm-2"><?php echo ucfirst($row["contact_person"]); ?></div>
												<div class="col-sm-1"><?php echo ucfirst($row["region"]); ?></div>

												<div class="col-sm-1"><?php echo ucfirst($member_status); ?></div>
												<div class="col-sm-2"><?php echo ucfirst($memberType); ?></div>
												
	
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


										echo "<li><a href='members.php?recs=".$records_per_page."&page=1'>".'&laquo;'."</a></li>"; // Goto 1st page  

										for ($i=1; $i<=$total_pages; $i++) { 
										       echo "<li><a href='members.php?recs=".$records_per_page."&page=".$i."'>".$i."</a></li> "; 
										}; 
										echo "<li><a href='members.php?recs=".$records_per_page."&page=".$total_pages."'>".'&raquo;'."</a></li>"; 
								?>
							</ul>
						
						<form action="" >
							<select name="recs" onchange="this.form.submit()">
								<option value="25" <?php if($records_per_page==25){echo 'selected'; }?>>25 Records per page</option>
								<option value="50" <?php if($records_per_page==50){echo 'selected'; }?>>50 Records per page</option>
								<option value="100" <?php if($records_per_page==100){echo 'selected'; }?>>100 Records per page</option>
								<option value="<?php echo $total_members; ?>" <?php if($records_per_page==$total_members){echo 'selected'; }?>>All</option>
							</select>
						</form>
						<?php } ?>

					</div>
					

	               </div>
	 			 </div>



    
    </div> <!-- approve-members-page div ends -->  
    
    <!-- </div>  --><!-- members-page div ends -->  


<?php include_once "common/footer.php"; ?>