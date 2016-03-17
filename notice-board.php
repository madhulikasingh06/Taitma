<?php include_once "common/headerNew.php"; ?>
    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="notice-board-page" class="page-contents"> <!--news-events-page div starts  -->

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
                              <small style="float:right" class="text-color-blue"><?php 
                                if(!empty($row["event_date"])){
                                  echo  date_format(date_create($row["event_date"]),"m/d/Y");
                                } ?></small>
                            </h4> 
                            <p><?php echo $row["data"];?></p>
                          </div>
                          <div class="col-sm-1"></div>
              </div>
      
    
       
                <?php }
        }

  }
                  
    
  }else { ?>


           <div id="notice-board-conents">

        <?php 

        $member_type=memberTypeRegular;

        if(isset($_SESSION["loggedIN"]) && isset($_SESSION["memberType"]) )  {
            if($_SESSION["memberType"]>0){

                $member_type=memberTypePremium;
            }
        }

        // echo $member_type;
     $result = $db->query(getNoticeForMemberType.$member_type." ORDER BY event_date DESC ;");
                
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
                            <p><?php echo substr($row["data"], 0, 500); ?><a href="?oper=view&amp;id=<?php echo $row["ID"]; ?>"><?php if(strlen($row["data"])>500) { ?>...(read more)<?php } ?></a></p>
<!--                             <p><?php echo substr($row["data"], 0, 300); ?><a href="?oper=view&amp;id=<?php echo $row["ID"]; ?>">...(read more)</a></p>
 -->                          </div>
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