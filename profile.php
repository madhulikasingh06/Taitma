<?php include_once "common/headerNew.php";?>

  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="register-page" class="page-contents"> <!--register-page div starts  -->

        <?php include_once "common/inner-nav-bar.php"; ?>

            <div id="register-contents" class="row"> 


      <?php  
       $membership_no=$serial_no=$email = $password = $confirmPassword = $companyName = $contactPerson = 
       $address1 = $address2 =$city = $pincode = $state = $phone = $mobile = $website = $region = $category = 
       $memberSpecifiedCategory = $memberType = $otherDetails = $doc1 = $doc2= $doc1_name = $doc2_name = 
       $doc1_ref =$doc2_ref = $membershipStartDate = $membershipExpiryDate="";
       $addPaymentDetails = $paymentMode = $amount =$paymentNumber = $paymentAgainst = $payOtherDetails = 
       $paymentID= $membershipStartDate =$membershipExpiryDate = $reminder = $statusMsg= $statusCode = 
       $billNumber = $receiveMessage = $showProfile =$daysToExpiry = $membershipRequested = $subscribeNewsletter ="";       

       $emailErr = $passwordErr = $confirmPasswordErr = $companyNameErr = $contactPersonErr = $address1Err = 
       $address2Err =$cityErr = $pincodeErr = $stateErr = $phoneErr = $mobileErr = $websiteErr = $regionErr = 
       $categoryErr = $memberSpecifiedCategoryErr = $memberTypeErr = $otherDetailsErr = $doc1Err = $doc2Err = "";
       $memberTypeRequestedErr = $addPaymentDetailsErr = $paymentModeErr = $amountErr =$paymentNumberErr = 
       $paymentAgainstErr = $payOtherDetailsErr = $paymentDateErr = $billNumberErr ="";

      if(isset($_SESSION["userSrNo"])){
        $serialNo=$_SESSION["userSrNo"];
      }
      //echo "email: $email";

      if (is_object($db)) {
      
       $sql = "SELECT * FROM Members_Profile WHERE serial_no='$serialNo'";
       //echo "$sql";
       $result = $db->query($sql);

       // echo "result: ". $result;

      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) 

         {
            $membership_no = $row["membership_no"];
            $serial_no=$row["serial_no"];
            $companyName = $row["company_name"];
            $contactPerson = $row["contact_person"];
            $address1 = $row["address_1"];
            $address2 = $row["address_2"];
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
            $otherDetails = $row["other_details"];
            $email=$row["email"];
            $paymentID = $row["payment_id"];
            $membershipStartDate = date_create($row["membership_start_date"]);
            $membershipExpiryDate = date_create($row["membership_expiry_date"]);
            $receiveMessage = $row["receive_message"];
            $showProfile = $row["view_profile"];
            $membershipRequested = $row["membership_requested"];
            $subscribeNewsletter = intval($row["recieve_newsletter"]);

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


         $todays_date= date_create(date("Y-m-d H:i:s"));
         $diff=date_diff($todays_date,$membershipExpiryDate);
         $daysToExpiry = $diff->format("%R%a days");



      } 

      }



 // Get the user updated files 


      $iterator = new FilesystemIterator(MEMBER_FILE_UPLOAD_FOLDER);
                                              $filter = new RegexIterator($iterator, "/($serial_no)_*.*$/");
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

    <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style">

          <?php        if(isset($_POST["operation"])) {

                        if($_POST["operation"] == "edit-profile"){

                          if($_SESSION["editProfileToken"]==$_POST["editProfileTokenPost"]){

                                      // echo $_POST["editProfileTokenPost"];
                                      $_SESSION["editProfileToken"]='';
                                        include_once "registrationValidation.php";

                                          // echo "isErrored :: ".intval($isErrored);
                                         
                                         if (!$isErrored) {
                                          $statusCode = $status[0]; 
                                          $statusMsg = $status[1];  


                                  ?>

							<?php 
              //             echo  $statusMsg; 
//                            header('location:'.$_SERVER["PHP_SELF"].'?status=1');
                              echo "<meta http-equiv='refresh' content='0; url=?status=1'>";
						          exit;
                          ?>

                                    <?php  } else {  ?>

                          <p style="text-align:center;color:#FF5050;"><?php echo  ERR_ACCOUNT_EDIT_FORM_VAL_FAILED ?></p>

                                    <?php 
                                        }
                              }

                        }

                        if($_POST["operation"] == "requestMembership"){

                          if($_SESSION["addPaymentToken"]==$_POST["addPaymentTokenPost"]){
                              $_SESSION["addPaymentToken"]='';
                               $response = include_once "user-operations.php"; 
                                 // echo "<p class='center'>".$response."</p>";
                              // header('location:'.$_SERVER["PHP_SELF"].'?requestMembership='.$response);
                               echo "<meta http-equiv='refresh' content='0; url=?requestMembership=$response'>";
                                 exit;
                             
                          }
                        }


                      }
           ?>




          <p  class="center">
          <?php       if (isset($_GET["status"]) AND $_GET["status"]==1 ) {
                      echo MSG_ACCOUNT_EDIT_PROFILE_SUCCESS;
                    }

                    if(isset($_GET["requestMembership"])) {
                        if($_GET["requestMembership"] == SUCCESS){

                          echo MSG_MEMBERSHIP_REQUEST_SUCCESS;

                        }else{
                           echo MSG_MEMBERSHIP_REQUEST_FAILURE;

                        }

                    }
            
               ?>
              </p>



                <!-- register-contents div starts -->

                <!-- <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style"> -->
                    <!-- <p> You can download the Registration form here. (Right click &amp;Save link As)</p>
                    <p> You will need to post a hard copy of the filled in Membership form to TAITMA office address along
                        with a cheque of Rs.3000/- (Rs.1000/- annual fee &amp; Rs.2000/- one time joining fee).</p>
 -->
        <?php 
          if($_SESSION["accountStatus"]==3){ ?>
               <div class="center space-after-para error"> <?php    echo MSG_PROFILE_INCOMPLETE; ?> </div>
       <?php    }


        ?>

                <div id="register-form-div"  style="display:block;">

                    <form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="register-form" role="form"  method="post"   class="form-horizontal"  enctype="multipart/form-data">  
                        <!--Generate a unique token-->
                        <?php $newToken= sha1(time());
                             $_SESSION["editProfileToken"]=$newToken;
                             //echo $_SESSION["registerUserToken"];
                         ?>

                      <input type="hidden" name="operation" value="edit-profile"/>
                      <input type="hidden" id="editProfileTokenPost" name="editProfileTokenPost" value="<?php echo $newToken; ?>"/>
                      <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                      <input type="hidden" name="serial_no" value="<?php echo $serial_no; ?>"/>
                      <input type="hidden" name="memberType" value="<?php echo $memberType; ?>"/>
                        
                    <?php if(strlen($membership_no)>0) { ?>
                          <div class="form-group">
                              <label class="col-sm-4">Membership number:&nbsp;<sup>*</sup></label>
                              <div  class="input-box col-sm-8"> <?php echo $membership_no ;?>
                              </div>
                          </div>
                      <?php } ?>
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
                                <option value="" >Please choose a region.</option>
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
                                <option value="" >Please choose a category.</option>

                                <?php
                                 // $sql="select * from Members_Categories" ;

                                    $result = $db->query(getMembersCategories);

                                    if ($result->num_rows > 0) {

                                         while($row = $result->fetch_assoc()) {

                                         //    echo "id: " . $row["ID"]. " - category_ID: " . $row["category_ID"]. "  - category_desc:" . $row["category_desc"]. "<br>";
                                        
                                        ?>
                                 <option value= "<?php echo $row["category_desc"]; ?>" <?php if($category_id==$row["category_ID"]){echo "selected";} ?> ><?php echo $row["category_desc"]; ?></option>

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

                        <span  id="otherDetailsMessage" class="col-sm-offset-4 error" ><?php echo $otherDetailsErr;?></span>
                          <div class="form-group">
                              <label for="otherDetails" class="col-sm-4">Other Details:</label>
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
                          <div class="form-group">
                            <div id="doc1_name" class="col-sm-4"  style="font-weight: bold;">Uploaded File 1 :</div>                 
                            <div  class="col-sm-8"><a href="<?php echo $doc1_ref ;?>"  target="_blank"><?php echo $doc1_name;?></a></div>
                          </div>
                         <?php }?>

                       <?php if(!empty($doc2_name)) { ?>
                           <div class="form-group">
                            <div id="doc2_name" class="col-sm-4" style="font-weight: bold; padding-bottom:10px;">Uploaded File 2 :</div>
                            <div  class="col-sm-8"><a href="<?php echo $doc2_ref ;?>"  target="_blank"><?php echo $doc2_name;?></a></div>
                          </div>
                            
                         <?php }?>


                       <span  id="memberTypeMessage" class="col-sm-offset-4 error" ><?php echo $memberTypeErr; ?></span>
                          <div class="form-group">
                            <label for="memberType" class="col-sm-4">Member Type:&nbsp;<sup>*</sup></label>
                            <div class="col-sm-3"><b><?php echo $memberType ; ?></b></div>
                            <div class="col-sm-5">
                              <?php if($membershipRequested==0) {   
                                    if($memberType_id==0) { ?>
                                <button type="Button" class="button-common" style="margin: 0px;" data-toggle="modal" data-target="#addPaymentDetails"  >Become A Member!</button>
                            <?php } else if ($daysToExpiry <= 30) { ?>
                                <button type="Button" class="button-common" style="margin: 0px;" data-toggle="modal" data-target="#addPaymentDetails"  >Renew Membership!</button>
                             <?php }  }?>
                              </div>

                              <?php if($membershipRequested==1) {  
                                echo "<p class='error'>Application is pending approval.</p>";
                              }?>

              
               <!--               <select class="input-box col-sm-8 form-control <?php if(!$memberTypeErr==""){echo " errorBox" ;} ?>" id="memberType"  name="memberType" >
                                <option value="" >Please choose a member type.</option>

                                <?php
                                  $sql="select * from Members_Type" ;

                                    $resultMembersType = $db->query($sql);

                                    if ($resultMembersType->num_rows > 0) {

                                         while($member = $resultMembersType->fetch_assoc()) {

                                              // echo "id: " . $memberType["ID"]. " - category_ID: " . $memberType["member_type"]. "  - category_desc:" . $memberType["member_desc"]. "<br>";
                                        
                                        ?>
                                        <option value= "<?php echo $member["member_desc"]; ?>" <?php if($memberType_id==$member["member_type"]){ echo "selected" ;}  ?>  ><?php echo $member["member_desc"]; ?></option>

                                        <?php }
                                     }
                                 ?>
                             </select> -->


                          </div>

                          <div class="form-group">
                           <?php if ($memberType_id !=0){?>
                            <label for="membership-period" class="col-sm-4" >Membership Period:</label>
                            <div class="col-sm-8"><?php echo date_format($membershipStartDate,"m/d/Y");?> - <?php echo date_format($membershipExpiryDate,"m/d/Y");?>
                            </div>  
                            <?php  } ?>
                          </div>

                        <?php if ($memberType_id !=0){?>
                       <span></span>
                       <div class="form-group">
                         <label for="receiveEnquiries" class="col-sm-4" >Receive Messages:</label>
                        <select class="input-box col-sm-6 form-control" name="receiveMessage">
                              <option value="1" <?php if($receiveMessage) echo 'selected' ?> >Yes</option>
                              <option value="0" <?php if(!$receiveMessage) echo 'selected' ?>>No</option>
                          </select>
                       </div>

                     <span></span>
                       <div class="form-group">
                         <label for="receiveEnquiries" class="col-sm-4" >Show Profile to other members :</label>
                        <select class="input-box col-sm-6 form-control" name="showProfile">
                              <option value="1" <?php if($showProfile) echo 'selected' ?> >Yes</option>
                              <option value="0" <?php if(!$showProfile) echo 'selected' ?>>No</option>
                          </select>
                       </div>
                       <?php  } ?>

                       
                       <span></span>
                       <div class="form-group">
                         <label for="subscribeNewsletter" class="col-sm-4" >Subscribe Newsletter :</label>
                        <select class="input-box col-sm-6 form-control" name="subscribeNewsletter">
                              <option value="1" <?php if($subscribeNewsletter) echo 'selected' ?> >Yes</option>
                              <option value="0" <?php if(!$subscribeNewsletter) echo 'selected' ?>>No</option>
                          </select>
                       </div>


                        <div class="col-sm-offset-4 col-sm-8"  style="padding-top:10px;">
                            <!-- <button type="Submit">Submit</button> -->
                            <button type="Submit">Submit</button>
                            <button type="Reset">Reset</button>
                             <button type="button" onClick="location.href = 'index.php'">Cancel</button>
                     </div>


                    </form>

                    


                </div>

                    
                </div>
                <div class="col-sm-2">
                    <p id="demo"></p>

                </div>
            </div> <!-- register-contents div ends -->    

    </div> <!-- register-page div ends -->  


<!-- MODAL DIV FOR ADDING PAYMENT TO USER ACCOUNT - STARTS -->


         <div id="addPaymentDetails" class="modal fade" role="dialog">
              <div class="modal-dialog ">

                  <!-- Modal content-->
                  <div class="modal-content" style="border:1px solid #0ABDC8">
                    <div class="modal-header site-header white-text ">
                      <button type="button" class="close" data-dismiss="modal" >&times;</button>
                      <h4 class="center">Request Membership</h4>
                      <div id="PaymentStatus"></div>
                    </div>

                    <div class="modal-body transparent-bg">
                    <div id="responseText" class="center"></div>
                        <form id="addPaymentForm" method="POST" action=""  enctype="multipart/form-data">

                           <!--Generate a unique token-->
                        <?php $newToken= sha1(time());
                             $_SESSION["addPaymentToken"]=$newToken;
                             //echo $_SESSION["registerUserToken"];
                         ?>
                        
                          <input type="hidden" name="operation" value="requestMembership"  />
                          <input type="hidden" name="serialNo" value="<?php echo $serialNo; ?>"/>
                          <input type="hidden" id="addPaymentTokenPost" name="addPaymentTokenPost" value="<?php echo $newToken; ?>"/>

                       <span  id="memberTypeRequestedMessage" class="col-sm-offset-4 error" ><?php echo $memberTypeRequestedErr; ?></span>
                        <div class="row form-group">
                        <label  for="memberTypeRequested" class="col-sm-4">Membership Type : </label>
                        <select class="input-box col-sm-8 form-control <?php if(!$memberTypeRequestedErr==""){echo " errorBox" ;} ?>" id="memberTypeRequested"  name="memberTypeRequested" >
                          <option value="" >Please choose a member type.</option>
                          <option value= "Premium Yearly">Premium Yearly</option>
                          <option value="Premium Lifetime">Premium Lifetime</option>
                        </select> 
                        </div>

                      <span  id="paymentDateMessage" class="col-sm-offset-4 error" ><?php echo $paymentDateErr;?></span>
                      <div class="row form-group">
                          <label  for="paymentDate" class="col-sm-4">Payment Date : </label>
                          <input   id="datepicker" class="col-sm-8 input-box <?php if(!empty($paymentDateErr)){ echo " errorBox" ;} ?>" name="paymentDate" type="text" /> 
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


<!--                       <span  id="billNumberMessage" class="col-sm-offset-4 error" ><?php echo $billNumberErr;?></span>
                      <div class="row  form-group">
                          <label  for="billNumber" class="col-sm-4">Bill number :</label>
                          <input id="billNumber" class="col-sm-8 input-box <?php if(!empty($billNumberErr)){ echo " errorBox" ;} ?>" type="text" name="billNumber" value="<?php echo $billNumber; ?>"/> 
                      </div> -->

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


                        <div class="row">
                           <div class="col-sm-offset-4 col-sm-8">                                      
<!--                            <button type ="button" onclick="addPaymentDetails('<?php echo $serialNo; ?>','requestMembership','responseText','memberTypeRequested')">Submit</button>
 -->                           <button type ="submit" onclick="return addPaymentDetails('<?php echo $serialNo; ?>','requestMembership','responseText','memberTypeRequested')">Submit</button>

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

<?php include_once "common/footer.php"; ?>
















