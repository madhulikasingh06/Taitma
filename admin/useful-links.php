  
<?php include_once "common/header.php";?>
<div id=""  class="page-background"> <!--home-main start -->

    <div id="useful-links-page" class="page-contents"> <!-- useful-links-page div starts  -->

          <?php include_once "common/inner-nav-bar.php"; ?>

          
          <div id="useful-links-contents" class="row"> <!--useful-links-contents div starts-->
              
              <div class="col-sm-2"></div>

               <div class="col-sm-7 page-content-style">

              <?php 

              if(isset($_SESSION["loggedIN"])) {
                if ($_SESSION["loggedIN"]==1){ 
                  echo "you are logged in ".$_SESSION["userID"];
                }

              }else {
                  echo "you are not logged in ";
                }

              ?>

            <?php

               // $sql = "GetUsefulLinks()";
                $result = $db->query("CALL ". getUsefulLinks);

                if ($result->num_rows > 0) {

                  while($row = $result->fetch_assoc()) {
                    
                     // echo "id: " . $row["ID"]. " - Title: " . $row["title"]. "  - url:" . $row["url"]. "<br>";


                       $urls = explode('|', $row["url"]); ?>


                      <div class="space-after-para">

                          <p class="text-color-blue"><?php echo $row['title'] ;?><br>

                          <?php foreach ($urls as $url) {?>
                              <a href= "http://<?php echo $url; ?>" target="_blank"><?php echo $url;?></a><br>
                          <?php } ?>

                          </p>
                      </div>
                    
                  
                  
                <?php } //while ends



              } else {
                 // echo "0 results";
              }
              $db->close();

            ?>

                </div>

              <div class="col-sm-3"></div>

          </div> <!-- useful-links-contents div ends -->

  </div> <!-- useful-links-page div ends  -->

<?php include_once "common/footer.php"; ?>