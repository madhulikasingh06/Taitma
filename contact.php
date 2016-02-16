<?php include_once "common/header.php"; ?>

<?php 

   $category= $name = $email = $message = $companyName = $phone = "";
   $categoryErr = $nameErr = $emailErr = $messageErr = $companyNameErr = $phoneErr = $captchaMessageErr ="";

   if(isset($_POST["operation"])){

        $isErrored = false;


        // your secret key
        $secret = RECAPTCHA_SECRET_KEY;
         
        // empty response
        $response = null;
         
        // check secret key
        $reCaptcha = new ReCaptcha($secret);

        // if submitted check response
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );

            if (!($response != null && $response->success)) {
                $isErrored = true;
                $captchaMessageErr = "Please verify again.";

            }

        }else{
            $isErrored = true;
           $captchaMessageErr = "Please check this box.";
        }




        if(empty($_POST["name"])){
            $isErrored = true;
           $nameErr = "Please enter your name";
        }else {
            $name = $_POST["name"];
        }

        if(empty($_POST["email"])){
             $isErrored = true;
             $emailErr = "Please enter your email";

        }else {
            $email = $_POST["email"];
        }

         if(empty($_POST["companyName"])){
             $isErrored = true;
             $companyNameErr = "Please enter your company name";

        }else {
            $companyName = $_POST["companyName"];
        }

         if(empty($_POST["phone"])){
             $isErrored = true;
             $phoneErr = "Please enter your phone";

        }else {
            $phone = $_POST["phone"];
        }


        if(empty($_POST["category"])){
             $isErrored = true;
             $categoryErr = "Please choose a category";

        }else {
            $category = $_POST["category"];
        }


        if(empty($_POST["message"])){
             $isErrored = true;
             $messageErr = "Please write your message";

        }else {
            $message = $_POST["message"];
        }

        if(!$isErrored){
            include_once "user-operations.php";
               echo "<meta http-equiv='refresh' content='0;contact.php?showMessage=1'>";
                          exit;
        }

   }


?>

  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="contact-page" class="page-contents"> <!--contact-page div starts  -->

          <?php include_once "common/inner-nav-bar.php"; ?>



        <div id="contact-form-bg" class="row" > <!--contact-form-bg starts-->
         
            <div class="col-sm-offset-2  col-sm-3 page-content-style">
                <h4>TAITMA</h4>

                <p>301, Business Park,<br>
                    18 S V Road,<br>
                    Malad (West),<br>
                    Toy Guide Mumbai - 400064</p>
            </div>


            <div class="col-sm-7  page-content-style  left-border"><!---->

                    <div id="contact-message">
                       <?php if(isset($_GET["showMessage"]) && ($_GET["showMessage"]==1)){

                            echo "<b><i>Thank you for your message.
                            <br/>It needs to be approved by admin for other members to read.</i></b>";

                       }
                       
                       ?> 
                        
                    </div>
                    

                    <div  id="contact-form" > <!--contact-form div starts-->
                           <div>
                              <p class="form-control-static">You can leave a message using the contact form below.</p>
                            </div>

                         <form  role="form" action="" method="post"  class="form-horizontal" >
                      
                        <input type="hidden" name="operation" value="drop-message"/>
                        <input type="hidden" name="premium_val" value="0"/>


                                   
                                   <span  id="nameMessage" class="col-sm-offset-4 col-sm-8 error" ><?php echo $nameErr;?></span>
                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-4">Your Name:<sup>*</sup></label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control input-sm <?php if(!$nameErr==""){echo " errorBox" ;} ?>" id="name" name="name"  value = "<?php echo $name;?>">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                   <span  id="emailMessage" class="col-sm-offset-4 col-sm-8  error" ><?php echo $emailErr;?></span>
                                    <div class="form-group">
                                        <label for="email" class="control-label col-sm-4">Your e-mail address:<sup>*</sup></label>
                                        <div class="col-sm-7">
                                          <input type="email" class="form-control  input-sm <?php if(!$emailErr==""){echo " errorBox" ;} ?>" id="email" name="email" value = "<?php echo $email;?>">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                   <span  id="companyNameMessage" class="col-sm-offset-4  col-sm-8  error" ><?php echo $companyNameErr;?></span>
                                    <div class="form-group">
                                        <label for="companyName" class="control-label col-sm-4">Your company name:<sup>*</sup></label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control  input-sm <?php if(!$companyNameErr==""){echo " errorBox" ;} ?>" id="companyName" name="companyName" value = "<?php echo $companyName;?>">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                   <span  id="phoneMessage" class="col-sm-offset-4  col-sm-8  error" ><?php echo $phoneErr;?></span>
                                    <div class="form-group">
                                        <label for="phone" class="control-label col-sm-4">Your phone:<sup>*</sup></label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control  input-sm <?php if(!$phoneErr==""){echo " errorBox" ;} ?>" id="phone" name="phone"  value = "<?php echo $phone;?>">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>


<!--                                     <div class="form-group">
                                        <label for="category" class="control-label col-sm-4">Category:<sup>*</sup></label>
                                        <div class="col-sm-3">
                                            <select class="form-control input-sm" id="category" name="category">
                                                    <option>Please Choose</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
 -->
                            <span  id="categoryMessage" class="col-sm-offset-4  col-sm-8 error" ><?php echo $categoryErr;?></span>
                             <div class="form-group">
                              <label for="category" class="control-label col-sm-4">Category:&nbsp;<sup>*</sup></label>
                                <div class="col-sm-6">
                                <select class="input-box  input-sm form-control<?php if(!$categoryErr==""){echo " errorBox" ;} ?>" id="category"  name="category" >
                                <option value="" ></option>

                                <?php
                                 // $sql="select * from Members_Categories" ;

                                    $result = $db->query(getMembersCategories);

                                    if ($result->num_rows > 0) {

                                         while($row = $result->fetch_assoc()) {

                                         //    echo "id: " . $row["ID"]. " - category_ID: " . $row["category_ID"]. "  - category_desc:" . $row["category_desc"]. "<br>";
                                        
                                        ?>
                                 <option value= "<?php echo $row["category_desc"]; ?>" <?php if($category==$row["category_desc"]){echo "selected";} ?> ><?php echo $row["category_desc"]; ?></option>

                                        <?php }
                                    } 
                                 ?>
                             </select>
                             </div>
                              <div class="col-sm-1"></div>
                          </div>

                                   <span  id="messageMessage" class="col-sm-offset-4  col-sm-8  error" ><?php echo $messageErr;?></span>
                                    <div class="form-group">
                                        <label for="message" class="control-label col-sm-4">Message:<sup>*</sup></label>
                                        <div class="col-sm-7">
                                        <textarea type="text" class="form-control input-sm <?php if(!$messageErr==""){echo " errorBox" ;} ?>"  id="message" rows="5" columns="5" name="message"><?php echo $message; ?></textarea>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                    <span  id="captchaMessage" class="col-sm-offset-4  col-sm-8  error" ><?php echo $captchaMessageErr;?></span>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-7">
                                            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY ;?>"></div>
                                        </div>
                                    </div>


                                    <div class="col-sm-offset-9 col-sm-3">
                                          <button type="submit" class="btn btn-default">Submit</button>
                                    </div>

                        </form>



                    </div> <!--contact-form div ends-->

            </div><!---->

           </div> <!--contact-form-bg ends-->


    </div> <!-- contact-page div ends -->  


<?php include_once "common/footer.php"; ?>