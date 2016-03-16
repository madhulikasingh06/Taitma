<?php include_once "common/header.php";?>

  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="register-page" class="page-contents"> <!--register-page div starts  -->

        <?php include_once "common/inner-nav-bar.php"; ?>

            <div id="register-contents" class="row"> 


                <?php  
       $membership_no=$serial_no=$email = $password = $confirmPassword = $companyName = $contactPerson = 
       $address1 = $address2 =$city = $pincode = $state = $phone = $mobile = $website = $region = $category = 
       $memberSpecifiedCategory = $memberType = $otherDetails = $doc1 = $doc2= $doc1_name = $doc2_name = 
       $doc1_ref =$doc2_ref = $membershipStartDate = $membershipExpiryDate="";
       $emailErr = $passwordErr = $confirmPasswordErr = $companyNameErr = $contactPersonErr = $address1Err = 
       $address2Err =$cityErr = $pincodeErr = $stateErr = $phoneErr = $mobileErr = $websiteErr = $regionErr = 
       $categoryErr = $memberSpecifiedCategoryErr = $memberTypeErr = $otherDetailsErr = $doc1Err = $doc2Err = "";



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


                      if($_SESSION["editProfileToken"]==$_POST["editProfileTokenPost"]){

                        // echo $_POST["editProfileTokenPost"];
                        $_SESSION["editProfileToken"]='';
                          include_once "registrationValidation.php";

                            // echo "isErrored :: ".intval($isErrored);
                           
                           if (!$isErrored) {
                            $statusCode = $status[0]; 
                            $statusMsg = $status[1];  


                    ?>

            <p style="text-align:center;"><?php 
//             echo  $statusMsg; 
          	header('location:'.$_SERVER["PHP_SELF"].'?status=1');
          	exit;
            ?></p>

                      <?php  } else {  ?>

            <p style="text-align:center;color:#FF5050;"><?php echo  ERR_ACCOUNT_EDIT_FORM_VAL_FAILED ?></p>

                      <?php 


                          }


                       }
                      }



                    if (isset($_GET["status"]) AND $_GET["status"]==1 ) {
                      echo MSG_ACCOUNT_EDIT_PROFILE_SUCCESS;
                    }
            
               ?>



                <!-- register-contents div starts -->

                <!-- <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style"> -->
                    <!-- <p> You can download the Registration form here. (Right click &amp;Save link As)</p>
                    <p> You will need to post a hard copy of the filled in Membership form to TAITMA office address along
                        with a cheque of Rs.3000/- (Rs.1000/- annual fee &amp; Rs.2000/- one time joining fee).</p>
 -->


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
                        

                          <div class="form-group">
                              <label class="col-sm-4">Membership number:&nbsp;<sup>*</sup></label>
                              <div  class="input-box col-sm-8 <?php if($membership_no=="" || $membership_no==NULL){echo ' error';} ?>"> <?php if($membership_no=="" || $membership_no==NULL){echo "Not Assigned" ;}else {echo $membership_no ;} ?>
                              </div>
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

                        <span  id="memberTypeMessage" class="col-sm-offset-4 error" ><?php echo $memberTypeErr; ?></span>
                          <div class="form-group">
                            <label for="memberType" class="col-sm-4">Member Type:&nbsp;<sup>*</sup></label>
                            <div class="col-sm-3"><b><?php echo $memberType ; ?></b></div>
                            <div class="col-sm-5"><?php if($memberType_id==0) { ?>
                                <button type="Button" class="button-common" style="margin: 0px;">Become A Member!</button>
                            <?php } ?>
                              </div>
              
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
                           <?php if (!empty($paymentID)){?>
                            <label for="membership-period" class="col-sm-4" >Membership Period:</label>
                            <div class="col-sm-8"><i>Membership Starts -</i><?php echo date_format($membershipStartDate,"m/d/Y");?><br/>
                                    <i>Membership Ends -</i><?php echo date_format($membershipExpiryDate,"m/d/Y");?>
                            </div>  
                            <?php  } ?>
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



<?php include_once "common/footer.php"; ?>
















