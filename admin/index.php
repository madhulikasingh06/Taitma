<?php include_once "common/header.php"; ?>

<?php $pageName="Home" ?>


  <div> <!-- Carousel div start-->
    <div id="homeCarousel" class="carousel slide" data-ride="carousel">

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox"> <!--carousel-inner div starts-->
       
        <div class="item active">
          <img src="images/carousel-img/carousel-img-1.jpg" alt="" width="1024" height="333">
            <div class="carousel-caption">
             <p>house of the <br><span style="padding-left:100px;">toy makers...</span></p>
           </div>
        </div>


        <div class="item">
          <img src="images/carousel-img/carousel-img-2.jpg" alt="" width="1024" height="333">
            <div class="carousel-caption">
           <p>house of the <br><span style="padding-left:100px;">toy makers...</span></p>
          </div>
        </div>

      </div><!--carousel-inner div ends-->
       

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#homeCarousel" role="button" data-slide="prev" style="">
            <!--         <span class="glyphicon glyphicon-chevron-left" aria-hidden="true">
                                  <img src="images/carousel-img/left-slider.png" width="30px" height="30px">

                    </span>
             -->       
          <img  class="chevron chevron-left" src="images/carousel-img/left-slider.png"  style="width:90px; height:80px;background:none;"/>



           <span class="sr-only">Previous</span>
      </a>

      <a class="right carousel-control" href="#homeCarousel" role="button" data-slide="next">
       <!--  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span> -->
        <img  class="chevron chevron-right" src="images/carousel-img/right-slider.png"  style="width:90px; height:80px;background:none;"/>

      </a>

    </div>

  </div>  <!-- Carousel div end -->

  <div id="home-main"  class="page-background"><!--home-main div start-->

    <div class="row"> <!--row  starts-->

            <div  class="col-sm-offset-1  col-sm-4 "> <!--col div starts-->

              <div class="row inner-menu"> <!-- inside row 1 starts-->
                <div class="  col-sm-12">
                <ul>
                      <li><a href="notice-board.php">Notice Board</a></li>
                      <li><a href="contact.php">Contact</a></li>
                      <!-- <li><a href="register.php">Login / Register</a></li> -->
                      <li><?php if(!isset($_SESSION["loggedIN"])) { ?>

                        <a href='javascript:onclick=showLoginBox();'>Login</a>
                        <?php }else { ?><a href="logout.php">Logout</a> <?php }?></li>
                      


                </ul>
                </div>
              </div><!-- inside row 1 ends-->


              <?php 
                 if(isset($_POST["operation"])) {

                  // echo "operation set";

                 if($_SESSION["logInToken"]==$_POST["logInTokenPost"]){

                    $_SESSION["logInToken"]='';
                    include_once "admin-operations.php"; 
                      $statusCode = $status[0];
                      $statusMsg = $status[1] ;

                    ?>

                 <div class="row">
                  <div  id ="message" > <?php 

                      if ($statusCode==SUCCESS) {
                          echo "<meta http-equiv='refresh' content='0;/admin/index.php'>";
                         exit;
                      }
                   
                  ?>
                 </div>
                 </div>

                 <?php }
                       // else { echo "Please do not refresh!" ; } 
                     } //else { echo "operation not set!" ; }
                ?>
              <div class="row"><!-- inside row 2 starts  -->

                    
                    <div  id="login-box"  class="col-sm-12  trasparent-bg " style="display:none;">

                      <section id="" style="padding-top:0px;">
                      <?php 
                        if ((!empty($statusCode)) && $statusCode==ERROR) {
                         ?><div class="error"><script type="text/javascript"> document.getElementById("login-box").style.display='block'; </script> <?php 
                          echo $statusMsg;?></div> <?php
                      } 

                      ?>

                        <form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="form"   method="post"   >
                        <!--Generate a unique token-->
                        <?php $newToken= sha1(time());
                             $_SESSION["logInToken"]=$newToken;
                             //echo $_SESSION["logInToken"];
                         ?>   
                            <input type="hidden" name="operation" value="log-in"/>
                            <input type="hidden" id="logInTokenPost" name="logInTokenPost" value="<?php echo $newToken; ?>"/>
               
                          <div class="form-group">
                            <label for="email">Username:</label>
                            <input  class="input-box" type="text" placeholder="Username" required="" id="username" name="email" />
                          </div>

                          <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input  class="input-box" type="password" placeholder="Password" required="" id="password" name="pwd" />
                          </div>

                          <div style="width:100%;">
                            <!-- <input class="button-style" type="submit" value="Log in" /> -->
                             
                             <button type="submit" class="button-style">Log in</button>

                          </div>
                          <div>
                            <a href="#">Forgot password?</a>
                            <a href="register.php">Register</a>
                          </div>

                        </form><!-- form -->
                      </section><!-- content -->
                  </div><!-- login-box -->
              </div> <!-- inside row 2 ends  -->

            </div>  <!--col div ends-->

         
            <div class="col-sm-7 home-text">
                <p>THE ALL INDIA TOY MANUFACTURERS’ ASSOCIATION<br>
                (TAITMA) was established in 1976 with the prime object of <br>fostering integrated and accelerated growth and development of<br>
                the toy industry in India, in a systematic and scientific manner,<br>
                and to exploit its export potential to earn valuable foreign<br>exchange for the country.</p>

                <p>The toy industry in India has tremendous potential to raise its<br> 
                  productivity, create employment and for all-round development of<br>
                  the economy. The industry also presents vast potential for export<br> 
                  of toys, dolls, games and playthings. However, the toy industry<br>
                  has not received adequate attention for its development.                
                </p>

            </div>
    </div> <!--row  ends-->


         <script type="text/javascript">

            function showLoginBox(){
                         
                  //alert ("inside  showLoginBoxd!");

                    var e = document.getElementById("login-box");
                     // e.style.display = '';

                       if(e.style.display == 'block')
                          e.style.display = 'none';
                       else
                          e.style.display = 'block';
            }
    </script>

<?php include_once "common/footer.php"; ?>