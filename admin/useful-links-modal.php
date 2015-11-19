<?php include_once "common/header.php"; ?>
<?php 

  $title = $urls[] = $enable = $premium_val =""
?>
<div id=""  class="page-background"> <!--home-main start -->

    <div id="useful-links-page" class="page-contents "> <!-- useful-links-page div starts  -->

    <?php include_once "common/inner-nav-bar.php"; ?>


          
  <div id="useful-links-contents"> <!--useful-links-contents div starts-->



    <div class="admin-options-div row"><!-- admin option div starts-->
 
   <div class="col-sm-offset-1  col-sm-10 trasparent-bg  page-content-style">


      <div class="row">
            <div class="col-sm-offset-0 col-sm-10">
                 <button type="button" data-toggle="modal" data-target="#addLinkModal">Add Link</button>

            </div>


        </div>

 <!--  -->
   

<!-- ADD USEFUL LINKS MODAL DIV STARTS  -->

        <div  id="add-useful-links"   class="row"> <!--add-links starts-->
          
          <div class="col-sm-offset-2 col-sm-8 admin-box" style="padding:20px;" >
          
              <div id="addLinkModal" class="modal fade" role="dialog">
                <div class="modal-dialog ">

                  <!-- Modal content-->
                  <div class="modal-content" style="border:1px solid #0ABDC8">
                    <div class="modal-header site-header white-text ">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="center">Add Link</h4>
                    </div>

                    <div class="modal-body transparent-bg">

                      <div id="addLinkStatus" style="text-align:center;"></div> 
                            
                                    <form id="add-useful-links-modal-form" action="" role="form"  method="post"   class="form-horizontal space-after-para" >                           
                                          <?php 
                                              $addLinkToken = sha1(time());

                                              $_SESSION["addLinkToken"]=$addLinkToken; ?>
                         
                                             <?php  //echo $_SESSION["addLinkToken"];
                                           ?>

                                          <input type="hidden" name="operation" value="add-useful-link"/>
                                          <input type="hidden" name="addLinkTokenPost" value="<?php echo $addLinkToken ;?>"/>


                                              <div id="title-0-msg" class="center error"></div> 
                                              <div class="form-group">
                                                <div class="col-sm-3"><label for="title">Title:</label></div>
                                                <div class="col-sm-7"><input  class=" form-control-link input-box-link" type="text" id="title-0"  name="title"/></div>
                                              </div>

                                              <div id = "edit-add-url-0" class="form-group">

                                                <div id="edit-add-url-0-0[]-msg" class="center error"></div> 

                                                 <div class="col-sm-3"><label for="urls[]">URL:</label></div>
                                                 <div class="col-sm-7"><input  class=" form-control-link input-box-link" type="url" id="edit-add-url-0-0[]" name="urls[]" /></div>
                                                <div class="col-sm-1"><a href="#" onClick="addInput('edit-add-url-0',1);"><span class="sign-link">+</span></a></div>
                         
                                              </div>

                                              <div id="premium_val-0-msg" class="center error"></div> 
                                              <div class="form-group">
                                                <div class="col-sm-3"><label for="premium_val">Premium Value:</label></div>
                                                <div class="col-sm-7"><select  class="form-control input-box-link"  type="select" id="premium_val-0" name="premium_val">
                                                    <option value=""></option>
                                                    <option value="0">Regular</option>
                                                    <option value="1">Premium</option>                         
                                                  </select>
                                                </div>         
                                              </div>

                                              <div id="enabled-0-msg" class="center error"></div> 
                                              <div class="form-group">
                                                 <div class="col-sm-3"><label for="enabled">Enable:</label></div>
                                                    <div class="col-sm-7"><select class="form-control input-box-link" type="select"  id="enabled-0"  name="enabled">
                                                      <option value=""></option>
                                                      <option value="1">Enable</option>
                                                      <option value="0">Disable</option>                         
                                                  </select> 
                                                  </div>
                                              </div>

                                              <div class="col-sm-offset-4 col-sm-8">                                      
                                                    <button type ="Button" onClick="javascript:updateUsefulLinks('<?php echo ACTION_ADD;?>','0');" >Submit</button>
                                                    <button type="Reset">Reset</button>
                                                    <button type="button"  data-dismiss="modal" >Cancel</button>                      
                                              </div>

                                      </form>
                                                     
                    </div>
                  </div>

                </div>
              </div>                
          </div>
          <div class="col-sm-2"></div>

        </div> 

<!--  ADD USEFUL LINKS  MODAL DIV ENDS-->

              
  <div class="row">
                   <div class="col-sm-0"></div>

               <div class="col-sm-11">

            <?php

               // $sql = "GetUsefulLinks()";
               if(is_object($db)){

                // echo "getUsefulLinks  query ::".getUsefulLinks;

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
                            <button type="button" class="" onclick="editLink('<?php echo $id; ?>')"  data-toggle="modal" data-target="#editLink<?php echo $id; ?>">Edit</button>
                             <button type ="Button" onClick="javascript:updateUsefulLinks('<?php echo ACTION_DELETE;?>','<?php echo $id ?>');" >Delete</button>

                          </div>                             

                      </div>
                            
                    <div id="deleteLinkStatus<?php echo $id; ?>" style="text-align:center;"></div>
                     <!-- <div class="row"> -->
<!--                       <div id="editLink<?php echo $id; ?>"  class="col-sm-offset-2 col-sm-8"></div>
 -->
                  

               <div id="editLink<?php echo $id; ?>" class="modal fade" role="dialog">

                </div>




               <!--      </div> -->
                            
                    
                  
                  
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


     $('#someid').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    alert('submitting');
    $('#add-useful-links-form11').submit();
});
</script>




