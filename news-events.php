<?php include_once "common/header.php"; ?>
    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="news-events-page" class="page-contents"> <!--news-events-page div starts  -->

          <?php //$pageName="News &amp; Events" ?>

          <?php include_once "common/inner-nav-bar.php"; ?>



  <?php 

  if(isset($_GET["id"])){

      if(!empty($_GET["id"])){

          $id = $_GET["id"];
         $query = getNewsAndEventsWithID.$id;
         $result = $db->query($query);
                
                if ($result->num_rows > 0) { 

                  while($row = $result->fetch_assoc()) {?>

               <div class="row">
                          <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
                            <h4><a href="#"  class="text-color-blue"><?php echo $row["title"]; ?></a>
                                  <small style="float:right" class="text-color-blue">
                                      <?php if(!empty($row["event_date"])){
                                      echo  date_format(date_create($row["event_date"]),"m/d/Y");
                                      } ?>
                                  </small>                            
                            </h4> 
                            <p><?php echo $row["data"];?></p>
                          </div>
                          <div class="col-sm-1"></div>
              </div>
      
    
       
                <?php }
        }

  }
                  
    
  }else { ?>


           <div id="news-events-conents">
  
        <!-- <div class="row">
            <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
              <h4><a href="#" class="text-color-blue">Report on 2009 Nurenberg Toy Fair</a> <span style="font-weight:normal; font-size:14px; margin-left:20px">(Click to View)</span></h4>
              <p></p>
            </div>
            <div class="col-sm-1"></div>
        </div>
        
        <div class="row">
            <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
              <h4><a href="#"  class="text-color-blue">Ahmedabad Toy Dealers Meet</a> </h4>
              <p>
                TAITMA, in association with The Ahmedabad Toy Association and Supported by Kids India, had a very successful Toy Dealers Meet on 5th April 2013. The participants feedback was very encouraging and we thank The Ahmedabad Toy Association and Mr. Sachin Bhai for his help in organizing the event.
                The next event will be the MP Toy Dealers Meet on 4th August in Indore.</p>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <div class="row">
            <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
              <h4 style=""><a href="#"  class="text-color-blue">MP Toy Dealers Meet</a> </h4> 
              <p>
                After the tremendous response to the Pune &amp; Ahmedabad Toy Dealers meets, TAITMA is happy to announce the "MP Toy Dealers Meet" in Indore, Sayaji Hotel, on Sunday 4th August, 2013 from 10 am to 6 pm.
                Thwe following have confirmed their participation:
                Prem Ratna Games &amp; Toys, Sunny Industries, Pegasus Toy Kraft, Vardhaman IQ, Min Toy Pvt Ltd, Anmol Toys Pvt Ltd, Play Kraft Traders, Sam toys, Infotech Resources, Rajesh Traders, Kudos Kids Utilities, Zephyr Toymakers Pvt Ltd and Tayebally Ebrahim &amp; Sons.</p>
            </div>
            <div class="col-sm-1"></div>

        </div> -->


        <?php 

        $member_type=memberTypeRegular;

        if(isset($_SESSION["loggedIN"]) && isset($_SESSION["memberType"]) )  {
            if($_SESSION["memberType"]>0){

                $member_type=memberTypePremium;
            }
        }

        // echo $member_type;
     $result = $db->query(getNewsAndEventsForMemberType.$member_type." ORDER BY event_date DESC ;");
                
                if ($result->num_rows > 0) { 

                  while($row = $result->fetch_assoc()) {?>

               <div class="row">
                          <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
                            <div id="delete-status-<?php echo $row["ID"]; ?>"></div>
                            <div class="row">
                              <div class="col-sm-10">                               
                                <h4 style=""><a href="?oper=view&amp;id=<?php echo $row["ID"]; ?>"  class="text-color-blue"><?php echo $row["title"]; ?></a>                                  
                                  <small style="float:right" class="text-color-blue">
                                      <?php if(!empty($row["event_date"])){
                                      echo  date_format(date_create($row["event_date"]),"m/d/Y");
                                      } ?>
                                  </small>
                                 </h4> 
                              </div>                        
                            </div>
                            <p><?php echo substr($row["data"], 0, 300); ?><a href="?oper=view&amp;id=<?php echo $row["ID"]; ?>">...(read more)</a></p>
                          </div>
                          <div class="col-sm-1"></div>

              </div>
                <?php }

              }

  ?>

      </div>


    
  <?php  }

?>

 




    </div> <!-- news-events-page div ends -->  


<?php include_once "common/footer.php"; ?>