<?php include_once "common/header.php";?>

  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="register-page" class="page-contents"> <!--register-page div starts  -->

        <?php include_once "common/inner-nav-bar.php"; ?>

            <div id="register-contents" class="row"> 


                <?php 
                   $email = $password = $confirmPassword = $companyName = $contactPerson = $address1 = $address2 =$city = $pincode = $state = $phone = $mobile = $website = $region = $category = $memberSpecifiedCategory = $memberType = $otherDetails ="";
                   $emailErr = $passwordErr = $confirmPasswordErr = $companyNameErr = $contactPersonErr = $address1Err = $address2Err =$cityErr = $pincodeErr = $stateErr = $phoneErr = $mobileErr = $websiteErr = $regionErr = $categoryErr = $memberSpecifiedCategoryErr = $memberTypeErr = $otherDetailsErr = $doc1Err = $doc2Err = "";

                 if(isset($_POST["operation"])) {

                   // echo "member_type:".($_POST["memberType"]);

                 if($_SESSION["registerUserToken"]==$_POST["registerUserTokenPost"]){

                    $_SESSION["registerUserToken"]='';
                      include_once "registrationValidation.php";
                    ?>
                 <?php }
                      // else { echo "Please do not refresh!" ; } 
                     }  
               ?>



                <!-- register-contents div starts -->

                <div class="col-sm-offset-2  col-sm-8 trasparent-bg  page-content-style">
                 <p> You can download the Registration form here. (Right click &amp;Save link As)</p>
                    <p> You will need to post a hard copy of the filled in Membership form to TAITMA office address along
                        with a cheque of Rs.3000/- (Rs.1000/- annual fee &amp; Rs.2000/- one time joining fee).</p>
 


                <div id="register-form-div"  style="display:block;">

                    <form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="register-form" role="form"  method="post"   class="form-horizontal"  enctype="multipart/form-data">  
                        <!--Generate a unique token-->
                        <?php $newToken= sha1(time());
                             $_SESSION["registerUserToken"]=$newToken;
                             //echo $_SESSION["registerUserToken"];
                         ?>

                      <input type="hidden" name="operation" value="register-user"/>
                      <input type="hidden" id="registerUserTokenPost" name="registerUserTokenPost" value="<?php echo $newToken; ?>"/>
                            



                          <span  id="RegisterEmailMessage" class="col-sm-offset-4 error" ><?php echo $emailErr;?></span>
                          <div class="form-group">
                            <label for="email" class="col-sm-4">Email:&nbsp;<sup>*</sup></label>
                            <input  class="input-box col-sm-8 <?php if(!$emailErr==""){echo " errorBox" ;} ?> " type="text" id="RegisterEmail"  name="email" value="<?php echo $email; ?>" onChange="checkEmailExists(this)"/>
                            <!-- <div id="RegisterEmailMessage" class="error col-sm-3"><?php echo $emailErr;?></div> -->


                          </div>

                          <span  id="passwordMessage" class="col-sm-offset-4 error" ><?php echo $passwordErr;?></span>
                         <div class="form-group">
                            <label for="password" class="col-sm-4">Password:&nbsp;<sup>*</sup></label>
                            <input  class="input-box col-sm-8 <?php if(!$passwordErr==""){echo " errorBox" ;} ?>" type="password" id="password"  name="password" value="<?php echo $password; ?>"/><br>
                          </div>

                        <span  id="confirmPasswordMessage" class="col-sm-offset-4 error" ><?php echo $confirmPasswordErr;?></span>
                        <div class="form-group">
                            <label for="confirmPassword" class="col-sm-4">Confirm Password:&nbsp;<sup>*</sup></label>
                            <input  class="input-box col-sm-8 <?php if(!$confirmPasswordErr==""){echo " errorBox" ;} ?>" type="password" id="confirmPassword"  name="confirmPassword" value="<?php echo $confirmPassword; ?>" />
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
                                <option value="<?php echo $region; ?>" ><?php echo $region; ?></option>
                                <option value="North" >North</option>
                                <option value="East" >East</option>
                                <option value="West" >West</option>
                                <option value="South" >South</option>
                                <option value="Country" >Country</option>
                              </select>
                          </div>
      
                        <span  id="categoryMessage" class="col-sm-offset-4 error" ><?php echo $categoryErr;?></span>
                         <div class="form-group">
                              <label for="category" class="col-sm-4">Category:&nbsp;<sup>*</sup></label>
                                <select class="input-box col-sm-8 form-control<?php if(!$categoryErr==""){echo " errorBox" ;} ?>" id="category"  name="category" >
                                <option value="<?php echo $category; ?>" ><?php echo $category; ?></option>

                                <?php
                                 // $sql="select * from Members_Categories" ;

                                    $result = $db->query(getMembersCategories);

                                    if ($result->num_rows > 0) {

                                         while($row = $result->fetch_assoc()) {

                                         //    echo "id: " . $row["ID"]. " - category_ID: " . $row["category_ID"]. "  - category_desc:" . $row["category_desc"]. "<br>";
                                        
                                        ?>
                                 <option value= "<?php echo $row["category_desc"]; ?>" ><?php echo $row["category_desc"]; ?></option>

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
                                <option value="<?php echo $memberType; ?>" ><?php echo $memberType; ?></option>

                                <?php
                                  $sql="select * from Members_Type" ;

                                    $resultMembersType = $db->query($sql);

                                    if ($resultMembersType->num_rows > 0) {

                                         while($member = $resultMembersType->fetch_assoc()) {

                                              // echo "id: " . $memberType["ID"]. " - category_ID: " . $memberType["member_type"]. "  - category_desc:" . $memberType["member_desc"]. "<br>";
                                        
                                        ?>
                                        <option value= "<?php echo $member["member_desc"];  ?>" ><?php echo $member["member_desc"]; ?></option>

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

                        <span  id="doc1Message" class="col-sm-offset-4 error" ><?php echo $doc1Err;?></span>
                        <div>
                          <label for="doc1" class="col-sm-4">Select file to upload: </label>                          
                          <input type="file" name="doc1" id="doc1">
                        </div>


                        <span  id="doc2Message" class="col-sm-offset-4 error" ><?php echo $doc2Err;?></span>
                        <div>
                          <label for="doc2" class="col-sm-4">Select file to upload: </label>                          
                          <input type="file" name="doc2" id="doc1">
                        </div>



                        <div class="col-sm-offset-4 col-sm-8">
                            <!-- <button type="Submit">Submit</button> -->
                            <button type="Button" onClick="submitRegistrationForm();" >Submit</button>
                            <button type="Reset" onClick="document.write('<?php resetRegistrationForm() ?>'); ">Reset</button>
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


<?php 

function resetRegistrationForm(){

                   $email = $password = $confirmPassword = $companyName = $contactPerson = $address1 = $address2 =$city = $pincode = $state = $phone = $mobile = $website = $region = $category = $memberSpecifiedCategory = $memberType = $otherDetails ="";
                   $emailErr = $passwordErr = $confirmPasswordErr = $companyNameErr = $contactPersonErr = $address1Err = $address2Err =$cityErr = $pincodeErr = $stateErr = $phoneErr = $mobileErr = $websiteErr = $regionErr = $categoryErr = $memberSpecifiedCategoryErr = $memberTypeErr = $otherDetailsErr = $fileToUpload1Err = "";
                   header('Location: /taitma/register.php ');
           
}


?>



<script type="text/javascript">


function submitRegistrationForm(){

  var x  = document.getElementById("RegisterEmailMessage").innerHTML;
    
    // alert("RegisterEmailMessage "+ x.length );


   if(x.length<2){
      document.getElementById("register-form").submit();

  }

}


// function resetRegistrationForm(){

// }


  
</script>
















