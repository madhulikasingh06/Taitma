<?php include_once "common/header.php"; ?>
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
          

              <div class="col-sm-offset-2 col-sm-8 admin-box" style="padding:20px;" >

                <form id="add-useful-links-form" action="" role="form"  method="post"   class="form-horizontal" style="display:none;" >  
                  
                  <?php 
                      $addLinkToken = sha1(time());

                      $_SESSION["addLinkToken"]=$addLinkToken; ?>
 
                     <?php  //echo $_SESSION["addLinkToken"];
                   ?>

                  <input type="hidden" name="operation" value="add-useful-link"/>
                  <input type="hidden" name="addLinkTokenPost" value="<?php echo $addLinkToken ;?>"/>


                      <div id="title-msg" class="center error"></div> 
                      <div class="form-group">
                        <div class="col-sm-3"><label for="title">Title:</label></div>
                        <div class="col-sm-7"><input  class=" form-control-link input-box-link" type="text" id="title"  name="title" /></div>
                      </div>

                      <div id = "edit-add-url" class="form-group">

                        <div id="edit-add-url-0[]-msg" class="center error"></div> 

                         <div class="col-sm-3"><label for="urls[]">URL:</label></div>
                         <div class="col-sm-7"><input  class=" form-control-link input-box-link" type="url" id="edit-add-url-0[]" name="urls[]" /></div>
                        
                        <!-- <input type="button" value="+" onClick="addInput('dynamic-urls',1);"> -->
                           <div class="col-sm-1"><a href="#" onClick="addInput('edit-add-url',1);"><span class="sign-link">+</span></a></div>
 
                      </div>

                      <div id="premium_val-msg" class="center error"></div> 
                      <div class="form-group">
                        <div class="col-sm-3"><label for="premium_val">Premium Value:</label></div>
                        <div class="col-sm-7"><select  class="form-control input-box-link"  type="select" id="premium_val" name="premium_val">
                            <option value=""></option>
                            <option value="0">Regular</option>
                            <option value="1">Premium</option>                         
                          </select>
                        </div>         
                      </div>

                      <div id="enabled-msg" class="center error"></div> 
                      <div class="form-group">
                         <div class="col-sm-3"><label for="enabled">Enable:</label></div>
                            <div class="col-sm-7"><select class="form-control input-box-link" type="select"  id="enabled"  name="enabled">
                              <option value=""></option>
                              <option value="1">Enable</option>
                              <option value="0">Disable</option>                         
                          </select> 
                          </div>
                      </div>

                      <div   class="col-sm-offset-4 col-sm-8">
<!--                             <button type="Submit">Submit</button>-->
                             <button type='button' onclick="if (validateUsefulLinks('')) document.forms['add-useful-links-form'].submit();">Submit</button>
                            <button type="Reset">Reset</button>
                            <button type="button"  onclick="cancelForm('add-useful-links')">Cancel</button>
                      </div>

                </form>
              </div>
                  <div class="col-sm-2"></div>

        </div> <!--add-links ends-->

<!--   <div class="space-after-para"></div>
 -->  <!-- </div> --><!-- admin option div ends-->
              
  <div class="row">
                   <div class="col-sm-0"></div>

               <div class="col-sm-11">

            <?php

               // $sql = "GetUsefulLinks()";
               if(is_object($db)){

//                 echo "getUsefulLinks  query ::".getUsefulLinks;

                 $result = $db->query(getUsefulLinks);
                // $result->data_seek(0);
                if ($result->num_rows > 0) { ?>

                      <div id="" class = "row heading">
                          <div class="col-sm-3">Title</div>
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

                          <div class="col-sm-3"><p class="text-color-blue"><?php echo $row['title'] ;?></p></div>
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
                           <div class="col-sm-2">
                            <button type="button" class="" onclick="editLink('<?php echo $id; ?>')">Edit</button>
                             <button type ="Button" onClick="javascript:updateUsefulLinks('<?php echo ACTION_DELETE;?>','<?php echo $id ?>');" >Delete</button>

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

        } ?>
                

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
