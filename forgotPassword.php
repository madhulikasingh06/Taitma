<?php include_once "common/header.php"; ?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="" class="page-contents"> <!---page div starts  -->


       <!--  <?php //$pageName="Notice Board" ?> -->
        <?php include_once "common/inner-nav-bar.php"; ?>	


	<div id="forgot-password-conents">


       	 <div class="row center">
            <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
        	   
             <?php 
                    if(isset($_GET["oper"])){
                      // echo "oper is set";
                        include_once "user-operations.php";
                        echo $status[1];
                    }

               ?>



          <div class=""><h5>Please enter your email/membership number below - </h5></div>
        		<div>
        			<form>

        				<div class="form-group row">

                  <input type="hidden" name="oper" value="newPwd"/>

<!-- 							<div class="col-sm-offset-2 col-sm-4"><label for="username">Email/Membership number : </label></div>
							<div class="col-sm-6"><input class="input-box" type = "text" name ="username" id="username"/></div>
 -->
 							<label for="username">Email/Membership number : </label>
							<input class="" type = "text" name ="username" id="username"/>
        				</div>

						<div class="form-group row">
								<button type="submit">Mail me new password!</button>
						</div>

        			</form>

        		</div>
        	
          </div>
       	</div>
		</div>

    
    </div> <!-- -page div ends -->  


<?php include_once "common/footer.php"; ?>