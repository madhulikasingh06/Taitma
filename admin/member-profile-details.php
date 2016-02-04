<?php include_once "common/header.php"; ?>
<?php 
		
		//declare the variables 

       $serial_no=$email = $password = $confirmPassword = $companyName = $contactPerson = $address1 = 
       $address2 =$city = $pincode = $state = $phone = $mobile = $website = $region = 
       $category = $memberSpecifiedCategory = $memberType = $otherDetails = $doc1 = 
       $doc2= $doc1_name = $doc2_name = $doc1_ref =$doc2_ref = $membershipNumber = $disable = $disableDesc =  $disabledDate = 
       $addPaymentDetails = $paymentMode = $amount =$paymentNumber = $paymentAgainst = $payOtherDetails = 
       $paymentID= $membershipStartDate =$membershipExpiryDate = $reminder = $statusMsg= $statusCode = 
       $billNumber = "";

       $emailErr = $passwordErr = $confirmPasswordErr = $companyNameErr = $contactPersonErr = $address1Err = 
       $address2Err =$cityErr = $pincodeErr = $stateErr = $phoneErr = $mobileErr = $websiteErr = $regionErr = 
       $categoryErr = $memberSpecifiedCategoryErr = $memberTypeErr = $otherDetailsErr = $doc1Err = $doc2Err = 
       $membershipNumberErr  = $disableDescErr = $addPaymentDetailsErr = $paymentModeErr = $amountErr =$paymentNumberErr = 
       $paymentAgainstErr = $payOtherDetailsErr = $paymentDateErr = $billNumberErr ="";

        if(isset($_POST["operation"]) && ($_POST["operation"]=="approve-member")) { 

                      if($_SESSION["approveMemberToken"]==$_POST["approveMemberTokenPost"]){

                        $_SESSION["approveMemberToken"]='';
                          include_once "registrationValidation.php";

                            // echo "isErrored :: ".intval($isErrored);
                           
                           if (!$isErrored) {
                            $statusCode = $status[0]; 
                            $statusMsg = $status[1];  
                          }

                        }
          }


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
            $paymentID = $row["payment_id"];
            $membershipStartDate = date_create($row["membership_start_date"]);
            $membershipExpiryDate = date_create($row["membership_expiry_date"]);
            $reminder = $row["reminder"];


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

<div id="members-div"  class="page-background"> <!--home-main starts -->

  <div id="members-page" class="page-contents"> <!-- members-page div starts  -->

    <?php include_once "common/inner-nav-bar.php"; ?>

      <div id="approve-members-contents" class="row">
          <div class="col-sm-offset-1  col-sm-10 trasparent-bg  page-content-style">
<div id="approve-member-div"> 	<!-- Approve-admin-div-starts -->
                  <?php  if($statusCode==SUCCESS){?>

            <p style="text-align:center;"><?php echo  $statusMsg; ?></p>

                      <?php } else {  ?>

            <p style="text-align:center;color:#FF5050;"><?php echo  ERR_ACCOUNT_EDIT_FORM_VAL_FAILED; ?></p>

                      <?php }  ?>



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


                  		<span id="membershipNumberMessage"  class="col-sm-offset-4 <?php if(!$membershipNumberErr==""){echo " error" ;} ?>" ><?php echo $membershipNumberErr?></span>
                  		<div class="form-group">
                  			<label for="membershipNumber" class="col-sm-4">Membership Number:&nbsp;<sup>*</sup></label>
                  			<input class="input-box col-sm-7 <?php if(!$membershipNumberErr==""){echo " errorBox" ;} ?>" id="membershipNumber" type="text" name="membershipNumber"  
                          <?php if(!empty($membershipNumber)){ ?>
                                  onBlur="showAlert(this)"
                          <?php }?>  value="<?php echo $membershipNumber;?>"   onchange="showAlert(this)" />
                  		  <?php if(strlen(trim($membershipNumber))<3)  { ?>
                        <div id="approve-button"><button style="vertical-align:top;margin-left:10px;" type="button" onClick="validateAndApproveMembershipNumber('membershipNumber','<?php echo $memberSerial; ?>' , '<?php echo $email; ?>')">Approve!</button></div>
                        <?php } ?>
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
                                <option value="" >Please select.</option>
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
                                <option value="" >Please select.</option>

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
                              <input  class="input-box col-sm-8<?php if(!$memberSpecifiedCategoryErr==""){echo " errorBox" ;} ?>" type="" id="memberSpecifiedCategory"  name="memberSpecifiedCategory" 
                                value="<?php echo $memberSpecifiedCategory; ?>"/>
                          </div>

                        <span  id="memberTypeMessage" class="col-sm-offset-4 error" ><?php echo $memberTypeErr; ?></span>
                          <div class="form-group">
                            <label for="memberType" class="col-sm-4">Member Type:&nbsp;<sup>*</sup></label>
                             <select class="input-box col-sm-6 form-control <?php if(!$memberTypeErr==""){echo " errorBox" ;} ?>" id="memberType"  name="memberType" 
                               onchange="Upgrade_membership(this)"> 
                                <option value="" >Please select.</option>

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

                         <div class="form-group">
                            <label for="memberType" class="col-sm-4">Payment Details&nbsp;</label>
                             
                            <div class= "col-sm-5">
                              <?php if (!empty($paymentID)){?>

                                    <b>Membership Start Date :</b><?php echo date_format($membershipStartDate,"m/d/Y");?><br/>
                                    <b>Membership End Date :</b><?php echo date_format($membershipExpiryDate,"m/d/Y");?>
                              <?php  } ?>
                              </div>
                            <div class= "col-sm-2">  
                            <button id="upgradeMembershipButton" class="button-common" type="button" style="margin-left:auto;width:100px;"
                            data-toggle="modal" data-target="#addPaymentDetails" 
                            >Add Payment</button>
                          </div>



                          </div>


                        <div class="form-group">
                          <label for="reminder" class="col-sm-4">Reminder</label>
                          <select class="input-box col-sm-6 form-control" name="reminder">
                              <option value="1" <?php if($reminder) echo 'selected' ?> >Yes</option>
                              <option value="0" <?php if(!$reminder) echo 'selected' ?>>No</option>

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
                        <div class="form-group">
                          <label for="doc1" class="col-sm-4">New File 1 to upload: </label>                          
                          <input  class="col-sm-8" type="file" name="doc1" id="doc1" />
                        </div>


                        <span  id="doc2Message" class="col-sm-offset-4 col-sm-8 error" ><?php echo $doc2Err;?></span>
                        <div class="form-group">
                          <label for="doc2" class="col-sm-4">New File 2 to upload: </label>                          
                          <input  class="col-sm-8" type="file" name="doc2" id="doc2" />
                        </div>

                           <div class="form-group">
                           <label for="accountStatus" class="col-sm-4">User account status: </label>
                            <div class= "col-sm-5">
                              <?php if (!$disable){?>
      
                                <span> <b>Status  : </b> Enabled</span>
                                                            
                              <?php  } else { ?>
    
                                    <b>Status  : </b> Disabled<br />
                                    <b>Reason for disabling :</b><?php echo $disableDesc?><br/>
                                    <b>Date of disabling :</b><?php echo $disabledDate?>
                              <?php  } ?>
                              </div>
                            <div class= "col-sm-2">    
                        <?php if (!$disable){?> 

                         <button type="button" class="button-common"  style="margin-left:auto;width:80px;" data-toggle="modal" data-target="#disableUserModal">Disable</button>

                         <?php  }else { ?>
                        <button type="button" class="button-common"  style="margin-left:auto;width:80px;"
                              onCLick="enableDisableMember('disableDesc','<?php echo $memberSerial; ?>',<?php echo $disable ?>)">
                              Enable</button>

                         <?php } ?>
                        </div>
                      </div>      

                        <div class="col-sm-offset-4 col-sm-8"  style="padding-top:10px;">
                            <!-- <button type="Submit">Submit</button> -->
                            <button type="Submit" class="button-common ">Update</button>
                            <button type="Reset" class="button-common">Reset</button>
                             <button type="button" class="button-cancel" onClick="location.href = 'members.php'">Cancel</button>
                     </div>
		



	</form><!-- form div ends -->
      
<!-- MODAL DIV FOR ENABLING DISABLING USER ACCOUNT - STARTS -->


         <div id="disableUserModal" class="modal fade" role="dialog">
              <div class="modal-dialog ">

                  <!-- Modal content-->
                  <div class="modal-content" style="border:1px solid #0ABDC8">
                    <div class="modal-header site-header white-text ">
                      <button type="button" class="close" data-dismiss="modal" >&times;</button>
                      <h4 class="center">Disable User Account</h4>
                    </div>

                    <div class="modal-body transparent-bg">
                        <form id="disableUserForm" method="POST" action="admin-operations.php">
                          <input type="hidden" name="operation" value="changeAccount"  />
                          <input type="hidden" name="serialNo" value="<?php echo $memberSerial; ?>" />
                          <input type="hidden" name="status" value="<?php echo $disable ?>" />



        

                      <div class="row center">
                          <span id="disableDescMessage"  class="col-sm-offset-2 error" ></span>

                      </div>

                       <div class="row">
                            <label for="disableDesc" class="col-sm-2">Reason for disabling:</label>
                            
                            <div class="form-group col-sm-10 center" >
                              <textarea  class="form-control col-sm-12 rounded-Box<?php if(!$disableDescErr==""){echo " errorBox" ;} ?>" rows="5" id="disableDesc" 
                               name="disableDesc" ><?php echo $disableDesc ?></textarea>
                            
                          </div>
                        

                      </div>

                        <div class="row">
                           <div class="col-sm-offset-4 col-sm-8">                                      
                           <button type ="button" onCLick="enableDisableMember('disableDesc','<?php echo $memberSerial; ?>',<?php echo $disable ?>)" >Submit</button>
                           <button type="Reset">Reset</button>
                           <button type="button"  data-dismiss="modal" >Cancel</button>
                   
                         </div>


                        </div>
                      
                          

                        </form>
                    </div>
                  </div>

              </div>
          </div>


<!-- MODAL DIV FOR ENABLING DISABLING USER ACCOUNT - ENDS -->





<!-- MODAL DIV FOR ADDING PAYMENT TO USER ACCOUNT - STARTS -->


         <div id="addPaymentDetails" class="modal fade" role="dialog">
              <div class="modal-dialog ">

                  <!-- Modal content-->
                  <div class="modal-content" style="border:1px solid #0ABDC8">
                    <div class="modal-header site-header white-text ">
                      <button type="button" class="close" data-dismiss="modal" >&times;</button>
                      <h4 class="center">Add Payment</h4>
                      <div id="PaymentStatus"></div>
                    </div>

                    <div class="modal-body transparent-bg">
                    <div id="responseText" class="center"></div>
                        <form id="addPaymentForm" method="POST" action="">

                           <!--Generate a unique token-->
                        <?php $newToken= sha1(time());
                             $_SESSION["addPaymentToken"]=$newToken;
                             //echo $_SESSION["registerUserToken"];
                         ?>
                        
                          <input type="hidden" name="operation" value="addPaymentDetails"  />
                          <input type="hidden" name="serialNo" value="<?php echo $memberSerial; ?>"/>
                          <input type="hidden" id="addPaymentTokenPost" name="addPaymentTokenPost" value="<?php echo $newToken; ?>"/>

  
                      <span  id="paymentDateMessage" class="col-sm-offset-4 error" ><?php echo $paymentDateErr;?></span>
                      <div class="row form-group">
                          <label  for="paymentDate" class="col-sm-4">Payment Date : </label>
                          <input   id="datepicker" class="col-sm-8 input-box <?php if(!empty($paymentDateErr)){ echo " errorBox" ;} ?>" name="paymentDate" type="text" 
                          onchange="calculateExpiyDate(this)"/> 
                      </div>

                      
                       <span  id="memStartDateMessage" class="col-sm-offset-4 error" ><?php echo $paymentDateErr;?></span>
                      <div class="row form-group">
                          <label  for="memStartDate" class="col-sm-4">Membership Start Date : </label>
                          <input   id="memStartDate" class="col-sm-8 input-box <?php if(!empty($paymentDateErr)){ echo " errorBox" ;} ?>" name="memStartDate" type="text" 
                            /> 
                      </div>
                 
                      <span  id="memExpiryDateMessage" class="col-sm-offset-4 error" ><?php echo $paymentDateErr;?></span>                  
                      <div class="row form-group">
                          <label  for="memExpiryDate" class="col-sm-4">Membership Expiry Date : </label>
                          <input   id="memExpiryDate" class="col-sm-8 input-box <?php if(!empty($paymentDateErr)){ echo " errorBox" ;} ?>" name="memExpiryDate" type="text" 
                         /> 
                      </div>




                      <span  id="paymentModeMessage" class="col-sm-offset-4 error" ><?php echo $paymentModeErr;?></span>
                      <div class="row form-group">
                          <label  for="paymentMode" class="col-sm-4">Payment Mode : </label>
<!--                           <input  id="paymentMode" class="col-sm-8 input-box <?php if(!empty($paymentModeErr)){ echo " errorBox" ;} ?>" name="paymentMode" type="text" value="<?php echo $paymentMode; ?>"/> 
 -->                          <select id="paymentMode" class="col-sm-8 form-control input-box <?php if(!empty($paymentModeErr)){ echo " errorBox" ;} ?>" name="paymentMode" >
                              <option value="">Please choose payment mode.</option>
                              <option value="Cash" <?php if($paymentMode=='Cash') {echo 'selected' ; } ?> >Cash</option>
                              <option value="Cheque" <?php if($paymentMode=='Cheque') {echo 'selected' ; } ?>>Cheque</option>
                              <option value="Online" <?php if($paymentMode=='Online') {echo 'selected' ; } ?>>Online</option>
                              <option vlaue="Other" <?php if($paymentMode=='Other') {echo 'selected' ;} ?>>Other</option>

                          </select>


                      </div>

                      <span  id="amountMessage" class="col-sm-offset-4 error" ><?php echo $amountErr;?></span>
                      <div class="row  form-group">
                          <label  for="amount" class="col-sm-4">Amount : </label>
                          <input id="amount" class="col-sm-8 input-box <?php if(!empty($amountErr)){ echo " errorBox" ;} ?>" type="text"  name="amount"  value="<?php echo $amount; ?>"/> 
                      </div>


                      <span  id="billNumberMessage" class="col-sm-offset-4 error" ><?php echo $billNumberErr;?></span>
                      <div class="row  form-group">
                          <label  for="billNumber" class="col-sm-4">Bill number :</label>
                          <input id="billNumber" class="col-sm-8 input-box <?php if(!empty($billNumberErr)){ echo " errorBox" ;} ?>" type="text" name="billNumber" value="<?php echo $billNumber; ?>"/> 
                      </div>

                      <span  id="paymentNumberMessage" class="col-sm-offset-4 error" ><?php echo $paymentNumberErr;?></span>
                      <div class="row  form-group">
                          <label  for="paymentNumber" class="col-sm-4">Cheque/Payment number :</label>
                          <input id="paymentNumber" class="col-sm-8 input-box <?php if(!empty($paymentNumberErr)){ echo " errorBox" ;} ?>" type="text" name="paymentNumber" value="<?php echo $paymentNumber; ?>"/> 
                      </div>
                    
                    
                    <span  id="paymentAgainstMessage" class="col-sm-offset-4 error" ><?php echo $paymentAgainstErr;?></span>                    
                    <div class="row  form-group">
                          <label  for="paymentAgainst" class="col-sm-4">Payment Against :</label>
                           <input  id="paymentAgainst" class="col-sm-8 input-box <?php if(!empty($paymentAgainstErr)){ echo " errorBox" ;} ?>" type="text" name="paymentAgainst"  value="<?php echo $paymentAgainst; ?>" /> 
                     </div>
  
  
                   <span  id="payOtherDetailsMessage" class="col-sm-offset-4 error" ><?php echo $payOtherDetailsErr;?></span>   
                       <div class="row  form-group">
                            <label for="payOtherDetails" class="col-sm-4">Other Details:</label>
                            <textarea  class="form-control col-sm-8  input-box<?php if(!empty($payOtherDetailsErr)){ echo " errorBox" ;} ?>" rows="5" id="payOtherDetails" 
                               name="payOtherDetails" ><?php echo $payOtherDetails ?></textarea>
                      </div>

                        <div class="row">
                           <div class="col-sm-offset-4 col-sm-8">                                      
                           <button type ="button" onclick="addPaymentDetails('<?php echo $memberSerial; ?>','addPaymentDetails','responseText','memberType')">Submit</button>
                           <button type="Reset">Reset</button>
                           <button type="button"  data-dismiss="modal" >Cancel</button>
                   
                         </div>

                        </div>
                        </form>
                    </div>
                  </div>

              </div>
          </div>


<!-- MODAL DIV FOR ADDING PAYMENT TO USER ACCOUNT - ENDS -->




</div> 	<!-- Approve-admin-div-ends -->
</div> 
</div> 
</div> 
<script type="text/javascript">

$( "#datepicker" ).datepicker({
      changeMonth : true,
      changeYear : true,
      yearRange : '-50:+1',
      showButtonPanel : true,
      dateFormat : 'mm/d/yy',
      maxDate: '0',
  }

  );

</script>
  <script src="js/jquery-ui.js"></script>

<script type="text/javascript">

  function calculateExpiyDate(datestr){

    if(validateDate(datestr.value)){
      var memberType = document.getElementById("memberType").value;
      // alert("Member type :"+memberType);
       
       var yearsToAdd = <?php echo PREMIUM_YEARLY_MEMBERSHIP_YEARS ;?>;
          if(memberType == "Premium Lifetime"){
            yearsToAdd = <?php echo PREMIUM_LIFETIME_MEMBERSHIP_YEARS ;?>;
          }

           // alert ("years to add :"+yearsToAdd);

        document.getElementById("memStartDate").value = datestr.value;

        var startDate = new Date(datestr.value);

        startDate.setFullYear(startDate.getFullYear() + yearsToAdd); 
       // alert("final ::"+startDate.toDateString());
                     
        document.getElementById("memExpiryDate").value = startDate.toLocaleDateString("en-IN");
    }
  
      
        

  }


  function showAlert(membershipNumberDiv){

      // alert(membershipNumberDiv.value);

      if(membershipNumberDiv.value==""){
        alert("After approval membership number cannot be blank.");
      }
  }


</script>
<?php include_once "common/footer.php"; ?>

