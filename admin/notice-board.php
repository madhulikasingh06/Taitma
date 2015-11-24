<?php include_once "common/header.php"; ?>
    
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
                            <h4><a href="#"  class="text-color-blue"><?php echo $row["title"]; ?></a> </h4> 
                            <p><?php echo $row["data"];?></p>
                          </div>
                          <div class="col-sm-1"></div>
              </div>
      
    
       
                <?php }
        }

  }
                  
    
  }else { ?>


           <div id="notice-board-conents">
          
                    <div class="row" style="padding-top:20px;">           
            <div class="col-sm-offset-2  col-sm-10">
                 <button type="button" onClick="location.href='add-news-events.php'">Add Notice</button>
            </div>
            </div>



        <?php 

     $result = $db->query(getNotices);
                
                if ($result->num_rows > 0) { 

                  while($row = $result->fetch_assoc()) {?>

               <div class="row">
                          <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
                            <div id="delete-status-<?php echo $row["ID"]; ?>"></div>
                            <div class="row">
                              <div class="col-sm-10">                               
                                <h4 style=""><a href="#"  class="text-color-blue"><?php echo $row["title"]; ?></a> </h4> 
                              </div>
                              <div class="col-sm-2">
                                <button onclick="location.href='add-news-events.php?oper=edit&amp;id=<?php echo $row["ID"]; ?>'">Edit</button> 
<!--                                 <button onclick="location.href='?oper=delNE&amp;id=<?php echo $row["ID"]; ?>'">Delete</button> 
 -->
                                 <button onClick="javascript:deleteNewsAndNotice('<?php echo ACTION_DELETE_NEWS;?>','<?php echo $row["ID"] ?>');" >Delete</button>


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