<?php include_once "common/header.php"; ?>

  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="contact-page" class="page-contents"> <!--contact-page div starts  -->

          <?php include_once "common/inner-nav-bar.php"; ?>



        <div id="contact-form-bg" class="row" > <!--contact-form-bg starts-->
         
            <div class="col-sm-offset-2  col-sm-4 page-content-style">
                <h4>TAITMA</h4>

                <p>301, Business Park,<br>
                    18 S V Road,<br>
                    Malad (West),<br>
                    Toy Guide Mumbai - 400064</p>
            </div>

            <div class="col-sm-6  page-content-style  left-border"><!---->
                    <div  id="contact-form" > <!--contact-form div starts-->
                         <form  role="form" action="" method="post"  class="form-horizontal" >
                                     <div>
                                         <p class="form-control-static">You can leave a message using the contact form below.</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Your Name:<sup>*</sup></label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control input-sm" id="name" name="name">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="control-label col-sm-2">Your e-mail address:<sup>*</sup></label>
                                        <div class="col-sm-9">
                                          <input type="email" class="form-control  input-sm" id="email" name="email">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="category" class="control-label col-sm-2">Category:<sup>*</sup></label>
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


                                    <div class="form-group">
                                        <label for="message" class="control-label col-sm-2">Message:<sup>*</sup></label>
                                        <div class="col-sm-9">
                                        <textarea type="text" class="form-control input-sm" id="message" rows="5" columns="5" name="message"></textarea>
                                        </div>
                                        <div class="col-sm-1"></div>
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