<?php 
		
		//declare the variables 

       $serial_no=$email = $password = $confirmPassword = $companyName = $contactPerson = $address1 = 
       $address2 =$city = $pincode = $state = $phone = $mobile = $website = $region = 
       $category = $memberSpecifiedCategory = $memberType = $otherDetails = $doc1 = 
       $doc2= $doc1_name = $doc2_name = $doc1_ref =$doc2_ref = $membershipNumber = $disable = $disableDesc =  $disabledDate ="";
       $emailErr = $passwordErr = $confirmPasswordErr = $companyNameErr = $contactPersonErr = $address1Err = 
       $address2Err =$cityErr = $pincodeErr = $stateErr = $phoneErr = $mobileErr = $websiteErr = $regionErr = 
       $categoryErr = $memberSpecifiedCategoryErr = $memberTypeErr = $otherDetailsErr = $doc1Err = $doc2Err = 
       $membershipNumberErr  = $disableDescErr = "";


		$memberSerial = $_GET["id"];
		$result = $db -> query(getUnapprovedMemberDetails.$memberSerial);
			 if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$email = $row["email"];
            $membershipNumber = $row["membership_no"];
						$companyName = $row["company_name"];
						$contactPerson = $row["contact_person"];
						$address1 = $row["address_1"];
						$city = $row["city"];
						$pincode = $row["pincode"];
						$state = $row["state"];
						$phone = $row["phone"];
						$mobile = $row["mobile"];
						$website = $row["website"];
						$region = $row["region"];
						$category_id = $row["category"];
						$memberSpecifiedCategory = $row["member_specified_category"];
						$memberType_id = $row["member_type"];
						$other_details = $row["other_details"];
            			$disable = $row["disable"];
           				$disableDesc = $row["disabled_desc"];
            			$disabledDate = $row["disabled_date"];

					}

			}

		 $sql_cat = "SELECT category_desc FROM Members_Categories WHERE category_ID='$category_id'";
         if($result_cat = $db->query($sql_cat)){
             while ($obj = $result_cat->fetch_object()) {
                       $category =  $obj->category_desc;
             }

         }

        $sql_mt = "SELECT member_desc FROM Members_Type WHERE member_type='$memberType_id'";
         if($result_mt = $db->query($sql_mt)){
             while ($obj = $result_mt->fetch_object()) {
                       $memberType =  $obj->member_desc;
             }

         }
 	
 	// Get the user updated files 
      $iterator = new FilesystemIterator(MEMBER_FILE_UPLOAD_FOLDER);
                                              $filter = new RegexIterator($iterator, "/($memberSerial)_*.*$/");
                                              $filelist = array();

                                              if (iterator_count( $filter)>0) {


                                                foreach($filter as $entry) {
                                                  $filelist[] = $entry->getFilename();
                                                   $filename= $entry->getFilename();
                                                   // echo "filename : $filename";

                                                    $filenameArray = explode("_", $filename);
                                                 
                                                  if($filenameArray[1]=="1"){
                                                      $doc1_name =$filenameArray[2];
                                                      $doc1_ref=MEMBER_FILE_UPLOAD_FOLDER.$filename;
                                                    }

                                                   if($filenameArray[1]=="2"){
                                                      $doc2_name =$filenameArray[2];
                                                      $doc2_ref=MEMBER_FILE_UPLOAD_FOLDER.$filename;
                                                    }
                                                  }

                                                  // echo "\n$doc1_name and $doc2_name";
                                              }

?>


<div id="approve-member-div"> 	<!-- Approve-admin-div-starts -->

	          <?php        

	          	if(isset($_POST["operation"])) {	

                      if($_SESSION["approveMemberToken"]==$_POST["approveMemberTokenPost"]){

                        $_SESSION["approveMemberToken"]='';
                          include_once "registrationValidation.php";

                            // echo "isErrored :: ".intval($isErrored);
                           
                           if (!$isErrored) {
                            $statusCode = $status[0]; 
                            $statusMsg = $status[1];  


                    ?>

            <p style="text-align:center;"><?php echo  $statusMsg ;
            
            header('location:'.$_SERVER["PHP_SELF"].'?status=1');
          	exit;
            
            ?></p>

                      <?php  } else {  ?>

            <p style="text-align:center;color:#FF5050;"><?php echo  ERR_ACCOUNT_EDIT_FORM_VAL_FAILED ?></p>

                      <?php 

                          }
                       }
                      }
            
               ?>



	<form action="" id="approve-member-form" role="form"  method="post"   
		class="form-horizontal"  enctype="multipart/form-data"> <!-- form div starts -->

		<!--Generate a unique token-->
                        <?php $newToken= sha1(time());
                             $_SESSION["approveMemberToken"]=$newToken;
                             //echo $_SESSION["registerUserToken"];
                         ?>

                      <input type="hidden" name="operation" value="approve-member"/>
                      <input type="hidden" id="approveMemberTokenPost" name="approveMemberTokenPost" value="<?php echo $newToken; ?>"/>
                      <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                      <input type="hidden" name="serial_no" value="<?php echo $memberSerial; ?>"/>


                  		<span id="membershipNumberMessage"  class="col-sm-offset-4" ><?php echo $membershipNumberErr?></span>
                  		<div class="form-group">
                  			<label for="membershipNumber" class="col-sm-4">Membership Number:&nbsp;<sup>*</sup></label>
                  			<input class="input-box col-sm-7 <?php if(!$membershipNumberErr==""){echo " errorBox" ;} ?>" id="membershipNumber" type="text" name="membershipNumber" value="<?php echo $membershipNumber?>" />
                  		  <?php if(strlen(trim($membershipNumber))<3)  { ?>
                        <div id="approve-button"><button style="vertical-align:top;margin-left:10px;" type="button" onClick="validateAndApproveMembershipNumber('membershipNumber','<?php echo $memberSerial; ?>' , '<?php echo $email; ?>')">Approve!</button></div>
                        <?php } ?>
                      </div>  

                      <div class="form-group">
                           <label for="accountStatus" class="col-sm-4">User account status: </label>
                            <div class= "col-sm-6">
                              <?php if (!$disable){?>
      
                                <span> <b>Status  : </b> Enabled</span>
                                                            
                              <?php  } else { ?>
    
                                    <b>Status  : </b> Disabled<br />
                                    <b>Reason for disabling :</b><?php echo $disableDesc?><br/>
                                    <b>Date of disabling :</b><?php echo $disabledDate?>
                              <?php  } ?>
                              </div>
                      </div>      
	                   

                  
  
                      <span id="disableDescMessage"  class="col-sm-offset-4 error" ></span>
                      <div class="form-group">      
                            <label for="Disable" class="col-sm-4"><?php if ($disable){ echo "Enable"; } else { echo "Disable" ;};?>&nbsp;User Account: </label>     
                              <?php if (!$disable){?>
                                  <textarea  class="rounded-Box input-Box col-sm-6<?php if(!$disableDescErr==""){echo " errorBox" ;} ?>" rows="5" id="disableDesc"  name="disableDesc"><?php echo $disableDesc ?></textarea><br />
                             <?php  } ?>
                            <button type="button" onCLick="enableDisableMember('disableDesc','<?php echo $memberSerial; ?>',<?php echo $disable ?>)" style="vertical-align:top;margin:10px;"><?php if($disable) {echo "Enable";} else {echo "Disable";} ; ?></button>

                      </div>


						<div class="form-group">
						<label for="email" class="col-sm-4">Email:</label>
                  		<input  class="input-box col-sm-8"  type="text" name="email"  disabled value="<?php echo $email; ?>"/>
					</div>



                        <span  id="companyNameMessage" class="col-sm-offset-4 error" ><?php echo $companyNameErr;?></span>
                        <div class="form-group">
                              <label for="companyName" class="col-sm-4">Company Name:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8 <?php if(!$companyNameErr==""){echo " errorBox" ;} ?>" type="text" id="companyName"  name="companyName" value="<?php echo $companyName; ?>"/>
                          </div>

                        <span  id="contactPersonMessage" class="col-sm-offset-4 error" ><?php echo $contactPersonErr;?></span>
                          <div class="form-group">
                              <label for="contactPerson" class="col-sm-4">Contact Person:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8<?php if(!$contactPersonErr==""){echo " errorBox" ;} ?>" type="text" id="contactPerson"  name="contactPerson" value="<?php echo $contactPerson; ?>"/>
                          </div>
                        
                        <span  id="address1Message" class="col-sm-offset-4 error" ><?php echo $address1Err;?></span>
                         <div class="form-group">
                              <label for="address1" class="col-sm-4">Address 1:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8<?php if(!$address1Err==""){echo " errorBox" ;} ?>" type="text" id="address1"  name="address1" value="<?php echo $address1; ?>" />
                          </div>

                        <span  id="address2Message" class="col-sm-offset-4 error" ><?php echo $address2Err;?></span>
                             <div class="form-group">
                              <label for="address2" class="col-sm-4">Address 2:</label>
                              <input  class="input-box col-sm-8<?php if(!$address2Err==""){echo " errorBox" ;} ?>" type="text" id="address2"  name="address2" value="<?php echo $address2; ?>" />
                          </div>

                         <span  id="cityMessage" class="col-sm-offset-4 error" ><?php echo $cityErr;?></span>
                         <div class="form-group">
                              <label for="city" class="col-sm-4">City:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8<?php if(!$cityErr==""){echo " errorBox" ;} ?>" type="text" id="city"  name="city"  maxlength="50" value="<?php echo $city; ?>" />
                          </div>

                        <span  id="pincodeMessage" class="col-sm-offset-4 error" ><?php echo $pincodeErr;?></span>
                          <div class="form-group">
                              <label for="pincode" class="col-sm-4">Pincode:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8<?php if(!$pincodeErr==""){echo " errorBox" ;} ?>" type="text" id="pincode"  name="pincode" value="<?php echo $pincode; ?>" />
                          </div>
            
                        <span  id="stateMessage" class="col-sm-offset-4 error" ><?php echo $stateErr;?></span>
                          <div class="form-group">
                              <label for="state" class="col-sm-4">State:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8 <?php if(!$stateErr==""){echo " errorBox" ;} ?>" type="text" id="state"  name="state"  maxlength="100" value="<?php echo $state; ?>" />
                          </div>

                        <span  id="phoneMessage" class="col-sm-offset-4 error" ><?php echo $phoneErr;?></span>
                            <div class="form-group">
                              <label for="phone" class="col-sm-4">Phone:&nbsp;<sup>*</sup></label>
                              <input  class="input-box col-sm-8 <?php if(!$phoneErr==""){echo " errorBox" ;} ?>" type="" id="phone"  name="phone"  maxlength="35" value="<?php echo $phone; ?>"/>
                          </div>


                        <span  id="mobileMessage" class="col-sm-offset-4 error" ><?php echo $mobileErr;?></span>
                          <div class="form-group">
                              <label for="mobile" class="col-sm-4">Mobile:</label>
                              <input  class="input-box col-sm-8<?php if(!$mobileErr==""){echo " errorBox" ;} ?>" type="text" id="mobile"  name="mobile" maxlength="10" value="<?php echo $mobile; ?>"/>
                          </div>

                        <span  id="websiteMessage" class="col-sm-offset-4 error" ><?php echo $websiteErr;?></span>
                          <div class="form-group">
                              <label for="" class="col-sm-4">Website:</label>
                              <input  class="input-box col-sm-8 <?php if(!$websiteErr==""){echo " errorBox" ;} ?>" type="text" id="website"  name="website" value="<?php echo $website; ?>" />
                          </div>

                        <span  id="regionMessage" class="col-sm-offset-4 error" ><?php echo $regionErr;?></span>
                          <div class="form-group">
                              <label for="region" class="col-sm-4">Region:&nbsp;<sup>*</sup></label>
                              <select class="input-box col-sm-8 form-control <?php if(!$regionErr==""){echo " errorBox" ;} ?>" id="region"  name="region">
                                <option value="" ></option>
                                <option value="North"  <?php if($region=="North"){ echo "selected" ;}?> >North</option>
                                <option value="East" <?php if($region=="East"){ echo "selected" ;}?> >East</option>
                                <option value="West" <?php if($region=="West"){ echo "selected" ;}?>>West</option>
                                <option value="South" <?php if($region=="South"){ echo "selected" ;}?> >South</option>
                                <option value="Country" <?php if($region=="Country"){ echo "selected" ;}?> >Country</option>
                              </select>
                          </div>
      
                        <span  id="categoryMessage" class="col-sm-offset-4 error" ><?php echo $categoryErr;?></span>
                         <div class="form-group">
                              <label for="category" class="col-sm-4">Category:&nbsp;<sup>*</sup></label>
                                <select class="input-box col-sm-8 form-control<?php if(!$categoryErr==""){echo " errorBox" ;} ?>" id="category"  name="category" >
                                <option value="" ></option>

                                <?php
                                 // $sql="select * from Members_Categories" ;

                                    $resultC = $db->query(getMembersCategories);

                                    if ($resultC->num_rows > 0) {

                                         while($row = $resultC->fetch_assoc()) {

                                         //    echo "id: " . $row["ID"]. " - category_ID: " . $row["category_ID"]. "  - category_desc:" . $row["category_desc"]. "<br>";
                                        
                                        ?>
                             <option value= "<?php echo $row["category_desc"]; ?>" <?php if($category_id==$row["category_ID"]){echo "selected";} ?> ><?php echo $row["category_desc"]; ?></option>
<!--                                  <option value= "<?php echo $row["category_desc"]; ?>" <?php if($category==$row["category_desc"]){echo "selected";} ?> ><?php echo $row["category_desc"]; ?></option> -->

                                        <?php }
                                    } //else {
                                      //  echo "no results";
                                    // }
                                 ?>
                             </select>
                          </div>

                        <span  id="memberSpecifiedCategoryMessage" class="col-sm-offset-4 error" ><?php echo $memberSpecifiedCategoryErr;?></span>
                          <div class="form-group">
                              <label for="memberSpecifiedCategory" class="col-sm-4">Member Specified Category</label>
                              <input  class="input-box col-sm-8<?php if(!$memberSpecifiedCategoryErr==""){echo " errorBox" ;} ?>" type="" id="memberSpecifiedCategory"  name="memberSpecifiedCategory" value="<?php echo $memberSpecifiedCategory; ?>"/>
                          </div>

                        <span  id="memberTypeMessage" class="col-sm-offset-4 error" ><?php echo $memberTypeErr; ?></span>
                          <div class="form-group">
                            <label for="memberType" class="col-sm-4">Member Type:&nbsp;<sup>*</sup></label>
                             <select class="input-box col-sm-8 form-control <?php if(!$memberTypeErr==""){echo " errorBox" ;} ?>" id="memberType"  name="memberType" >
                                <option value="" ></option>

                                <?php 
                                  $sql="select * from Members_Type" ;

                                    if (is_object($db)) {
                                      echo "DB is alive";
                                    }else {
                                        echo "DB is not alive";
                                    }
                                    $resultMembersType = $db->query($sql);

                                    if ($resultMembersType->num_rows > 0) {

                                         while($member = $resultMembersType->fetch_assoc()) {

                                              // echo "id: " . $memberType["ID"]. " - category_ID: " . $memberType["member_type"]. "  - category_desc:" . $memberType["member_desc"]. "<br>";
                                        
                                        ?>
                                        <option value= "<?php echo $member["member_desc"]; ?>" <?php if($memberType_id==$member["member_type"]){ echo "selected" ;}  ?>  ><?php echo $member["member_desc"]; ?></option>

                                        <?php }
                                     }
                                 ?>
                             </select>


                          </div>

                        <span  id="otherDetailsMessage" class="col-sm-offset-4 error" ><?php echo $otherDetailsErr;?></span>
                          <div class="form-group">
                              <label for="otherDetails" class="col-sm-4">Other Details</label>
                             <textarea  class="rounded-Box col-sm-6<?php if(!$otherDetailsErr==""){echo " errorBox" ;} ?>" rows="5" id="otherDetails"  name="otherDetails"><?php echo $otherDetails ?></textarea>
                          </div>

                        <span  id="passwordMessage" class="col-sm-offset-4 error" ><?php echo $passwordErr;?></span>
                         <div class="form-group">
                            <label for="password" class="col-sm-4">Set New Password:</label>
                            <input  class="input-box col-sm-8 <?php if(!$passwordErr==""){echo " errorBox" ;} ?>" type="password" id="password"  name="password" value="<?php echo $password; ?>"/><br>
                          </div>

                        <span  id="confirmPasswordMessage" class="col-sm-offset-4 error" ><?php echo $confirmPasswordErr;?></span>
                        <div class="form-group">
                            <label for="confirmPassword" class="col-sm-4">Confirm New Password:</label>
                            <input  class="input-box col-sm-8 <?php if(!$confirmPasswordErr==""){echo " errorBox" ;} ?>" type="password" id="confirmPassword"  name="confirmPassword" value="<?php echo $confirmPassword; ?>" />
                          </div>
                            



                        <?php if(!empty($doc1_name)) { ?>
                          <div>
                            <div id="doc1_name" class="col-sm-4"  style="font-weight: bold;">Uploaded File 1 :</div>                 
                            <div  class="col-sm-8"><a href="<?php echo $doc1_ref ;?>"  target="_blank"><?php echo $doc1_name;?></a></div>
                          </div>
                         <?php }?>

                       <?php if(!empty($doc2_name)) { ?>
                           <div>
                            <div id="doc2_name" class="col-sm-4" style="font-weight: bold; padding-bottom:10px;">Uploaded File 2 :</div>
                            <div  class="col-sm-8"><a href="<?php echo $doc2_ref ;?>"  target="_blank"><?php echo $doc2_name;?></a></div>
                          </div>
                            
                         <?php }?>





                        <span  id="doc1Message" class="col-sm-offset-4 col-sm-8 error" ><?php echo $doc1Err;?></span>
                        <div>
                          <label for="doc1" class="col-sm-4">New File 1 to upload: </label>                          
                          <input  class="col-sm-8" type="file" name="doc1" id="doc1" />
                        </div>


                        <span  id="doc2Message" class="col-sm-offset-4 col-sm-8 error" ><?php echo $doc2Err;?></span>
                        <div>
                          <label for="doc2" class="col-sm-4">New File 2 to upload: </label>                          
                          <input  class="col-sm-8" type="file" name="doc2" id="doc2" />
                        </div>


                        <div class="col-sm-offset-4 col-sm-8"  style="padding-top:10px;">
                            <!-- <button type="Submit">Submit</button> -->
                            <button type="Submit" class="button-common ">Update</button>
                            <button type="Reset" class="button-common">Reset</button>
                             <button type="button" class="button-cancel" onClick="location.href = 'members.php'">Cancel</button>
                     </div>
		



	</form><!-- form div ends -->
	


</div> 	<!-- Approve-admin-div-ends -->




