<?php include_once "common/header.php";?>
<div id=""  class="page-background"> <!--home-main start -->

    <div id="useful-links-page" class="page-contents "> <!-- useful-links-page div starts  -->

    <?php include_once "common/inner-nav-bar.php"; ?>


          
  <div id="useful-links-contents"> <!--useful-links-contents div starts-->



    <div class="admin-options-div row"><!-- admin option div starts-->
 
   <div class="col-sm-offset-1  col-sm-10 trasparent-bg  page-content-style">


      <div class="row">
            <div class="col-sm-offset-0 col-sm-10">
                <button type="button" onclick="toggleForm('add-useful-links')"><b>Add Links</b></button>

            </div>
        </div>
   <?php 
             if (isset($_GET["oper"]) ) {
      
      if ($_GET["oper"] === "edul") {
        include_once "admin-operations.php";
      }

  }


          if(isset($_POST["operation"])) {        
            // echo "post token : ".$_POST["addLinkTokenPost"]."\n";

              if (isset($_SESSION["addLinkToken"]) AND isset($_POST["addLinkTokenPost"])){

                  if($_SESSION["addLinkToken"]== $_POST["addLinkTokenPost"]){

                        $_SESSION["addLinkToken"]='';
                        include_once "admin-operations.php"; ?>

                      <div class="row">
                        <div  id ="messageAddLink" class="center"  > <span><?php echo $status ?></span> 
                            <button type="Button" onClick="javascript:cancelDiv('messageAddLink')">Ok!</button>         

                        </div>
                      </div>
         <?php    }
            } else {echo "add link token is not added ";}
         // else { echo "Please do not refresh!" ; } 
        }  
  ?>



        <div  id="add-useful-links"   class="row"> <!--add-links starts-->
          

              <div class="col-sm-offset-3 col-sm-6 admin-box" style="padding:20px;" >

                <form id="add-useful-links-form" action="" role="form"  method="post"   class="form-horizontal" style="display:none;">  
                  
                  <?php 
                      $addLinkToken = sha1(time());

                      $_SESSION["addLinkToken"]=$addLinkToken; ?>
 
                     <?php  //echo $_SESSION["addLinkToken"];
                   ?>

                  <input type="hidden" name="operation" value="add-useful-link"/>
                  <input type="hidden" name="addLinkTokenPost" value="<?php echo $addLinkToken ;?>"/>



                      <div class="form-group">
                        <label for="title" class="col-sm-4">Link Title:</label>
                        <input  class="input-box col-sm-8" type="text" required="" id="title"  name="title"/>
                      </div>

                      <div id = "dynamic-urls" class="form-group">
                        <label for="urls[]"  class="col-sm-4">Link URL:</label>
                        <input  class="input-box col-sm-7" type="url" required="" id="url-0" name="urls[]" />
                        
                        <!-- <input type="button" value="+" onClick="addInput('dynamic-urls',1);"> -->
                            <a href="#" class="col-sm-1" onClick="addInput('dynamic-urls',1);"><span class="sign-link">+</span></a>

                      </div>

                      <div class="form-group">
                        <label for="premium_val"  class="col-sm-4">Link Premium Value:</label>
                          <select  class="input-box col-sm-8  form-control"  type="select" required="" id="enabled" name="premium_val">
                            <option value="0">Regular</option>
                            <option value="1">Premium</option>                         
                          </select>         
                      </div>
                      <div class="form-group">
                        <label for="enabled"  class="col-sm-4">Link enable:</label>
                           <select class="input-box col-sm-8 form-control" type="select" required="" id="enabled"  name="enabled">
                              <option value="1">Enable</option>
                              <option value="0">Disable</option>                         
                          </select> 
                      </div>

                      <div   class="col-sm-offset-4 col-sm-8">
                            <button type="Submit">Submit</button>
                            <button type="Reset">Reset</button>
                            <button type="button"  onclick="cancelForm('add-useful-links')">Cancel</button>
                      </div>

                </form>
              </div>
                  <div class="col-sm-3"></div>

        </div> <!--add-links ends-->

<!--   <div class="space-after-para"></div>
 -->  <!-- </div> --><!-- admin option div ends-->
              
  <div class="row">
                   <div class="col-sm-0"></div>

               <div class="col-sm-11">

            <?php

               // $sql = "GetUsefulLinks()";
                 $result = $db->query(getUsefulLinks);
                // $result->data_seek(0);
                if ($result->num_rows > 0) {?>

                      <div id="" class = "row heading">
                          <div class="col-sm-4">Title</div>
                          <div class="col-sm-4">URL</div>
                          <div class="col-sm-1">Enabled</div>   
                          <div class="col-sm-2">Premium Value</div>   

                      </div>

                  <?php while($row = $result->fetch_assoc()) {
                    
                     // echo "id: " . $row["ID"]. " - Title: " . $row["title"]. "  - url:" . $row["url"]. "<br>";

                       $urls = explode('|', $row["url"]); 
                       $id=$row["ID"];

                        ?>


                      <div class="row">

                          <div class="col-sm-4"><p class="text-color-blue"><?php echo $row['title'] ;?></p></div>
                          <div class="col-sm-4"> 
                          <?php foreach ($urls as $url) {?>
                             <a href= "http://<?php echo $url; ?>" target="_blank"><?php echo $url;?></a><br>
                          <?php } ?>
                          </div>
                            <div class="col-sm-1"><?php 
                                $enable = $row['enabled'];
                                if($enable){
                                  echo "Enabled";
                                }else {
                                  echo "Disabled";
                                }

                              ;?></div>
                              <div class="col-sm-2"><?php 
                                $enable = $row['premium_val'];
                                if(!$enable){
                                  echo "Regular";
                                }else {
                                  echo "Premium";
                                }

                              ;?></div>
                           <div class="col-sm-1">
                            <button type="button" class="" onclick="editLink('<?php echo $id; ?>')">Edit/Delete</button>
                          </div>                             

                      </div>
                            
                    <div id="editLinkStatus<?php echo $id; ?>" style="text-align:center;"></div>
                    <div class="row">
                      <div id="editLink<?php echo $id; ?>"  class="col-sm-offset-2 col-sm-8"></div>

                    </div>
                            
                    
                  
                  
                <?php } //while ends



              } else {
                 // echo "0 results";
              }
              $db->close();

            ?>

                </div>

              <div class="col-sm-1"></div>


  </div>

  </div>

          </div>

          </div> <!-- useful-links-contents div ends -->

  </div> <!-- useful-links-page div ends  -->

<?php include_once "common/footer.php"; ?>

<script type="text/javascript">
  

      function toggleDiv1(divID){

             alert(divID);

              var e = document.getElementById(divID);
              if(e.style.display == 'block')
                  e.style.display = 'none';
              else
                  e.style.display = 'block';

      }

</script>
