<?php include_once "common/header.php"; ?>

<?php $pageName="Home" ?>

  <div> <!-- Carousel div start-->
    <div id="homeCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
<!--        <ol class="carousel-indicators">
        <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#homeCarousel" data-slide-to="1"></li>
      </ol> -->

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

          <!-- <div class="carousel-caption">
           <p>house of the <br><span style="padding-left:100px;">toy makers...</span></p>
          </div> -->
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

    <div class="row">
        <div  class="col-sm-offset-1  col-sm-4 inner-menu">
            <ul>
                  <li><a href="notice-board.php">Notice Board</a></li>
                  <li><a href="register.php">Login / Register</a></li>
                  <li><a href="contact.php">Contact</a></li>
            </ul>
        <div class="col-sm-7"></div>
    </div>


     <div class="row">
            <div class="col-sm-offset-  col-sm-7 home-text">
              <p>THE ALL INDIA TOY MANUFACTURERS’ ASSOCIATION<br>
              (TAITMA) was established in 1976 with the prime object of <br>fostering integrated and accelerated growth and development of<br>
              the toy industry in India, in a systematic and scientific manner,<br>
              and to exploit its export potential to earn valuable foreign<br>exchange for the country.</p>

              <p>The toy industry in India has tremendous potential to raise its<br> productivity, create employment and for all-round development of<br>the economy. The industry also presents vast potential for export<br> of toys, dolls, games and playthings. However, the toy industry<br>has not received adequate attention for its development.
                
              </p>
           </div>
           <div class="col-sm-1"></div>
     </div>
<?php include_once "common/footer.php"; ?>