<?php include_once "common/header.php"; ?>
<?php 

	$total_members=0;
	$searchCrit1 = "All";
	$searchCrit  = $searchVal ="";
	$query = getLimitedMembers;

		if(isset($_GET["sercrit1"]) && !empty($_GET["sercrit1"])){
				$searchCrit1 =$_GET["sercrit1"];
		}

		if(isset($_GET["sercrit"]) && !empty($_GET["sercrit"]) AND !empty($_GET["serval"])){
			$searchCrit  = $_GET["sercrit"];
			$searchVal = $_GET["serval"];

		}




		if(isset($_GET["recs"]) && !empty($_GET["recs"])){
				  $records_per_page=intval($_GET["recs"]);

		}else {
				 $records_per_page=RECORDS_PER_PAGE;

		}




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

			// if(isset($_GET["recs"]) && !empty($_GET["recs"])){
			// 	  $records_per_page=intval($_GET["recs"]);

			// }

			// if($_SESSION["searchMemberToken"]==$_GET["token"]){

				// $_SESSION["searchMemberToken"]="";

				if(isset($_GET["sercrit1"])){

					 $searchCrit1 =$_GET["sercrit1"];
					if(!($_GET["sercrit1"]=="All")){
					
						
						$searchCrit1 =$_GET["sercrit1"];
						// echo "sercrit1 is ::".$_GET["sercrit1"];

						if($searchCrit1>=0 AND $searchCrit1<=2){

							$status = $_GET["sercrit1"];
							if(!empty($_GET["sercrit"]) AND !empty($_GET["serval"])){

								 $searchCrit  = $_GET["sercrit"];
								  $searchVal = $_GET["serval"];

							 $query = 'SELECT * FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND serial_no IN (SELECT serial_no from Member_Verification_Status WHERE Verification_Status ='.intval($status).')';
								$sql = 'SELECT serial_no FROM Members_Profile where '.$_GET["sercrit"] .' like "'.$_GET["serval"] .'%" AND serial_no IN (SELECT serial_no from Member_Verification_Status WHERE Verification_Status ='.intval($status).')';
								$result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}


							}else {
								 $query = 'SELECT * FROM Members_Profile where serial_no IN (SELECT serial_no from Member_Verification_Status WHERE Verification_Status ='.intval($status).')';
								$sql = 'SELECT serial_no FROM Members_Profile where serial_no IN (SELECT serial_no from Member_Verification_Status WHERE Verification_Status ='.intval($status).')';
								$result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}
							}

						}else if ($searchCrit1 >=3 AND $searchCrit1<=4){

							if($searchCrit1 == 3){
								$member_category = "M";
							}else {
								$member_category = "O";
							}

							if(!empty($_GET["sercrit"]) AND !empty($_GET["serval"])){
								$searchCrit  = $_GET["sercrit"];
								  $searchVal = $_GET["serval"];

								  $query = 'SELECT * FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND  category="'.$member_category.'"';
								  $sql = 'SELECT serial_no FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND  category="'.$member_category.'"';
								  $result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}

							}else {
								 $query = 'SELECT * FROM Members_Profile where category="'.$member_category.'"';
								  $sql = 'SELECT serial_no FROM Members_Profile where  category="'.$member_category.'"';
								  $result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}

							}



						}else if($searchCrit1 >=5 AND $searchCrit1<=6){

							if($searchCrit1==5){
								$memberType = "0";
							}else {
								$memberType = "(1 or 2)";
							}

							if(!empty($_GET["sercrit"]) AND !empty($_GET["serval"])){
								$searchCrit  = $_GET["sercrit"];
								  $searchVal = $_GET["serval"];

								  $query = 'SELECT * FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND  member_type='.$memberType;
								  $sql = 'SELECT serial_no FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND  member_type='.$memberType;
								  $result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}

							}else {
								 $query = 'SELECT * FROM Members_Profile where member_type='.$memberType;
								  $sql = 'SELECT serial_no FROM Members_Profile where  member_type = '.$memberType;
								  $result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}

							}

						}else if($searchCrit1 >=7 AND $searchCrit1<=8){

							if($searchCrit1==7){
								$disable = "0";
							}else {
								$disable = "1";
							}


							if(!empty($_GET["sercrit"]) AND !empty($_GET["serval"])){
								$searchCrit  = $_GET["sercrit"];
								  $searchVal = $_GET["serval"];

								   $query = 'SELECT * FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND  disable='.$disable;
								  $sql = 'SELECT serial_no FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" AND  disable='.$disable;
								  $result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}

							}else {
								 $query = 'SELECT * FROM Members_Profile where disable='.$disable;
								  $sql = 'SELECT serial_no FROM Members_Profile where  disable = '.$disable;
								  $result = $db -> query($sql);
								if ($result->num_rows > 0) {
									$total_members=$result->num_rows;
								}

							}

						}


					}else {

						if(!empty($_GET["sercrit"]) AND !empty($_GET["serval"])){

							 $searchCrit  = $_GET["sercrit"];
							  $searchVal = $_GET["serval"];

						 $query = 'SELECT * FROM Members_Profile where '.$_GET["sercrit"].' like "'.$_GET["serval"].'%" ';
							$sql = 'SELECT serial_no FROM Members_Profile where '.$_GET["sercrit"] .' like "'.$_GET["serval"] .'%"';
							$result = $db -> query($sql);
							if ($result->num_rows > 0) {
								$total_members=$result->num_rows;
							}


						}else {

						$result = $db -> query(getMembersCount);
						if ($result->num_rows > 0) {
							$total_members=$result->num_rows;
						}

					}

					}

				}
				else {

						$result = $db -> query(getMembersCount);
						if ($result->num_rows > 0) {
							$total_members=$result->num_rows;
						}

					}


				 // }
				//else {

				// 		  	$result = $db -> query(getMembersCount);
				// 			if ($result->num_rows > 0) {
				// 				$total_members=$result->num_rows;
				// 			}

				// }
			// }else {

			// 	$result = $db -> query(getMembersCount);
			// 	if ($result->num_rows > 0) {
			// 	$total_members=$result->num_rows;
			// 	}

			// } 

			}else {

						  	$result = $db -> query(getMembersCount);
							if ($result->num_rows > 0) {
								$total_members=$result->num_rows;
							}

			}

		
				
			// echo "CRITERIA ::".$searchCrit1.$searchCrit.$searchVal;

		
 ?>

    
  <div id="members-div"  class="page-background"> <!--home-main starts -->

    <div id="members-page" class="page-contents"> <!-- members-page div starts  -->

        <?php include_once "common/inner-nav-bar.php"; ?>

        	 <div id="approve-members-contents" class="row">
	               <div class="col-sm-offset-1  col-sm-10 trasparent-bg  page-content-style">
					
					<?php  if(!isset($_GET["id"])){ ?>
						<div class="row"><!-- div for  search box  starts-->
							<div class="col-sm-2  navbar-form navbar-left">
								<button type="button" onClick="location.href = 'register.php'">Add New Member</button>
							</div>
							
							<div class="col-sm-2  navbar-form navbar-left">
								<button type="button" onClick="location.href = 'downloadMemberForMessages.php'">Get Emails for Message</button>
							</div>

								<form class="navbar-form navbar-right" role="search">

									<?php $newToken= sha1(time());
			                             $_SESSION["searchMemberToken"]=$newToken;
			                             //echo $_SESSION["registerUserToken"];
			                        ?>
									
									<input type="hidden" name="oper" value="ser" />
									<input type="hidden" name = "token" value="<?php echo $newToken?>"/> 
									<input type="hidden" name="recs" value ="<?php echo $records_per_page ?>" >

									  <div class="form-group" >
								    	<select class="" name="sercrit1">
<!-- 								        	<option value="">Please select a criteria</option>
 -->								        <option value="All" <?php if($searchCrit1=="All") echo 'selected '; ?>>All</option>
								        	<option value="0" <?php if($searchCrit1=="0") echo 'selected '; ?>>New/Unverified</option>
								        	<option value="1" <?php if($searchCrit1=="1") echo 'selected '; ?>>Unapproved</option>
								        	<option value="2" <?php if($searchCrit1=="2") echo 'selected '; ?>>Approved</option>
								        	<option value="3" <?php if($searchCrit1=="3") echo 'selected '; ?>>Manufacturers</option>
								        	<option value="4" <?php if($searchCrit1=="4") echo 'selected '; ?>>Others</option>
								        	<option value="5" <?php if($searchCrit1=="5") echo 'selected '; ?>>Regular Members</option>
								        	<option value="6" <?php if($searchCrit1=="6") echo 'selected '; ?>>Premium Members</option>
								        	<option value="7" <?php if($searchCrit1=="7") echo 'selected '; ?>>Enabled Members</option>
								        	<option value="8" <?php if($searchCrit1=="8") echo 'selected '; ?>>Disabled Members</option>
								       

								        </select>
								    </div>
								    <div class="form-group" >
								    	<select class="" name="sercrit">
								        	<option value="" <?php if($searchCrit=="") echo 'selected '; ?>>Please select a criteria</option>
								        	<option value="membership_no" <?php if($searchCrit=="membership_no") echo 'selected '; ?>>Membership Number</option>
								        	<option value="email" <?php if($searchCrit=="email") echo 'selected '; ?>>Email Address</option>
								        	<option value="contact_person" <?php if($searchCrit=="contact_person") echo 'selected '; ?>>Contact Person</option>
								        	<option value="company_name" <?php if($searchCrit=="company_name") echo 'selected '; ?>>Company Name</option>
								        	<option value="region" <?php if($searchCrit=="region") echo 'selected '; ?>>Region</option>
								        	<option value="state" <?php if($searchCrit=="state") echo 'selected '; ?>>State</option>
								        	<option value="city" <?php if($searchCrit=="city") echo 'selected '; ?>>City</option>
								        	<option value="pincode" <?php if($searchCrit=="pincode") echo 'selected '; ?>>Pincode</option>
								        	<option value="phone" <?php if($searchCrit=="phone") echo 'selected '; ?>>Phone</option>
								        	<option value="mobile" <?php if($searchCrit=="mobile") echo 'selected '; ?>>Mobile</option>

								        </select>
								    </div>

								    <div class="form-group" >
								        <input type="text" class="rounded-box" placeholder="Search" name="serval" value="<?php echo $searchVal; ?>">
								    </div>

								    <button type="submit" class="rounded-box">Search</button>
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
												<div class="col-sm-2"><b><u>Contact person/<br/>Phone/<br/>Mobile</u></b></div>
												<div class="col-sm-1"><b><u>Region/<br/>City/<br/>Pincode</u></b></div>
												<div class="col-sm-1"><b><u>Status</u></b></div>
												<div class="col-sm-2"><b><u>Member Type/<br/>Expiry Date</u></b></div>												
											</div>
										</div>	
                  					<?php 	while($row = $result1->fetch_assoc()) {
                  								 // echo "\nMEMBER member_type :: ".$row["member_type"];

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
												<div class="col-sm-2" ><a href="member-profile-details.php?id=<?php echo $row["serial_no"]?>" class="<?php if($member_status=='new') echo ' error';?>"><?php echo $row["email"] ?></a><br/>
													<?php if ($member_status=='new') { ?> <span class="error"><I>unverified.</I></span><?php } ; ?>
												</div>												
												<?php if(intval($memberType_id)>0){ ?>
												<div class="col-sm-2<?php if(empty($row["membership_no"])){echo ' error' ;} ?>" style="text-align:center;">
													<?php  if(!empty($row["membership_no"])){echo $row["membership_no"]; } else {echo 'Pending Approval'; } ?>
												</div>
													<?php  }else { ?>
												<div class="col-sm-2 center" ><p>-</p></div>

												<?php	 } ?>

												
												<div class="col-sm-2"><?php echo ucfirst($row["company_name"]); ?></div>
												<div class="col-sm-2"><?php echo ucfirst($row["contact_person"]); ?><br>
													<?php echo ucfirst($row["phone"]); ?><br/>
													<?php echo ucfirst($row["mobile"]); ?>
												</div>
												<div class="col-sm-1"><?php echo ucfirst($row["region"]); ?><br/>
													<?php echo ucfirst($row["city"]); ?><br/>
													<?php echo $row["pincode"] ; ?>
												</div>

												<div class="col-sm-1"><?php echo ucfirst($member_status); ?></div>
												<div class="col-sm-2"><?php
													if( $row["membership_requested"]==1){
													 	echo '<span class="error">Pending Approval</span>';
													}else {
														echo ucfirst($memberType);
													}

												 ?> <br/>
													<?php echo $row["membership_expiry_date"]; ?>
												</div>
												
	
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


										echo "<li><a href='members.php?oper=ser&sercrit1=".$searchCrit1."&sercrit=".$searchCrit."&serval=".$searchVal."&recs=".$records_per_page."&page=1'>".'&laquo;'."</a></li>"; // Goto 1st page  

										for ($i=1; $i<=$total_pages; $i++) { 
										       echo "<li><a href='members.php?oper=ser&sercrit1=".$searchCrit1."&sercrit=".$searchCrit."&serval=".$searchVal."&recs=".$records_per_page."&page=".$i."'>".$i."</a></li> "; 
										}; 
										echo "<li><a href='members.php?oper=ser&sercrit1=".$searchCrit1."&sercrit=".$searchCrit."&serval=".$searchVal."&recs=".$records_per_page."&page=".$total_pages."'>".'&raquo;'."</a></li>"; 
								?>
							</ul>
						
						<form action="" >
							<input type="hidden" name = "sercrit1" value="<?php echo $searchCrit1;?>">
							<input type="hidden" name = "sercrit" value="<?php echo $searchCrit; ?>">
							<input type="hidden" name = "serval" value="<?php echo $searchVal; ?>">
							<input type="hidden" name="oper" value="ser" />

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