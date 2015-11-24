<?php include_once "common/header.php"; ?>

<?php 

      $id=0;
      $title = $content = $enabled = $premiumVal = $status1="";
      $titleErr = $contentErr = $enableErr = $premiumValErr = "";

      if ($_SERVER['REQUEST_METHOD']==="GET") {
                 if(isset($_GET["id"])){

                if(!empty($_GET["id"])){

                  $id = $_GET["id"];
                 $query = getNewsAndEventsWithID.$id;
                 $result = $db->query($query);
                        
                        if ($result->num_rows > 0) { 

                          while($row = $result->fetch_assoc()) {
                           $id= intval($row["ID"]);
                             $title = $row["title"];
                            $content = $row["data"];
                             $enabled = $row["enabled"];
                              $premiumVal = $row["premium_val"];
               
                         }
                }

          }
                          
            
          }
      }



      if (isset($_POST["operation"]) && isset($_SESSION["addNewsEvents"])) {

        echo "token is set";

         $id=$_POST["id"];

           if($_SESSION["addNewsEvents"]==$_POST["addNewsEventsPost"]){

                    $_SESSION["addNewsEvents"]='';

                    $isErrored = false;

                    if (empty($_POST["title"])) {
                        $titleErr = ERR_TITLE_REQUIRED;
                        $isErrored = true;
                    }else {
                        $title = test_input($_POST["title"]);

                    }

                    if (empty($_POST["content"])){
                        $isErrored = true;                      
                        $contentErr = ERR_CONTENT_REQUIRED;
                    }else {
                        $content = ($_POST["content"]);
                    }

                  if ($_POST["premium_val"]==""){
                         $isErrored = true;
                        $premiumValErr = ERR_DROP_DOWN_REQUIRED;
                    }else {
                        $premiumVal = $_POST["premium_val"];
                    }




                    if ($_POST["enabled"]==""){
                        $isErrored = true;
                        $enableErr = ERR_DROP_DOWN_REQUIRED;
                    }else {
                        $enabled = $_POST["enabled"];
                    }


                      if (!$isErrored) {
                        include_once "admin-operations.php";
                          $status1 = $status;
                      }
          }



      }

?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="" class="page-contents"> <!---page div starts  -->


       <!--  <?php //$pageName="Notice Board" ?> -->
        
        <?php include_once "common/inner-nav-bar.php"; ?>
        <div class="row">
            <div class="col-sm-offset-1  col-sm-8 page-content-style">
              
              <div class="status-msg"><?php echo $status1; ?></div>
              
              <form  role="form" method="post">
                  

              <?php 
                   $addNewsEventsToken = sha1(time());
                  $_SESSION["addNewsEvents"]=$addNewsEventsToken; ?>

                <input type="hidden" name="operation" value="add-news-events"/>
                <input type="hidden" name="addNewsEventsPost" value="<?php echo $addNewsEventsToken ;?>"/>
                <input type="hidden" name="id" value="<?php echo $id ;?>">

                    
                    <div id="title-msg" class="error"><?php echo $titleErr ?></div> 
                    <div class="form-group">
                      <label for="title">Title:</label><br />
                       <input type="text" name="title" class="input-box-link" value ="<?php echo $title ?>" > </input>
                    </div>


                  <div id="content-msg" class="error"><?php echo $contentErr ?></div> 
                  <div class="form-group row">
                     <div class="col-sm-12"><label>Contents:</label></div>
                     <div class="col-sm-12"><textarea name="content" id="content"  class="input-box">
                      <?php echo $content ?>
                    </textarea>
                      </div>
                  </div>
                
                     <div id="premium_val-msg" class="error"><?php echo $premiumValErr?></div> 
                     <div class="form-group row">
                       <div class="col-sm-3"><label for="premium_val">Premium Value:</label></div>
                       <div class="col-sm-4"><select  class="form-control input-box-link"  type="select" id="premium_val" name="premium_val">
                           <option value=""></option>
                           <option value="0" <?php if ($premiumVal=='0') {echo 'selected' ;} ?> >Regular</option>
                           <option value="1" <?php if ($premiumVal=='1') {echo 'selected' ;} ?>>Premium</option>                         
                         </select>
                       </div>       
                     </div>

                     <div id="enabled-msg" class="error"><?php echo $enableErr?></div> 
                     <div class="form-group row">
                        <div class="col-sm-3"><label for="enabled">Enable:</label></div>
                           <div class="col-sm-4"><select class="form-control input-box-link" type="select"  id="enabled"  name="enabled">
                             <option value=""?></option>
                             <option value="1"  <?php if ($enabled=='1') {echo 'selected' ;} ?> >Enable</option>
                             <option value="0" <?php if ($enabled=='0') {echo 'selected' ;} ?> >Disable</option>                         
                         </select> 
                         </div>
                     </div>

                <div class="row form-group center">                                      
                     <button type ="submit" >Submit</button>
                      <button type="button" onclick="location.href='news-events.php'" >Cancel</button>                      
                </div>                   



                </form>


            </div>

            <div class="col-sm-2"></div>

        </div>
    



<?php include_once "common/footer.php"; ?>

<script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
      CKEDITOR.replace( 'content' );
</script>