<?php include_once "common/headerNew.php"; ?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="" class="page-contents"> <!---page div starts  -->


       <!--  <?php //$pageName="Notice Board" ?> -->
        <?php include_once "common/inner-nav-bar.php"; ?>

    <div class="col-sm-offset-2 " style= "padding:10px;">
           <button type="button" onClick="location.href='?oper=addPost'">Add Post</button>
    </div>

	<?php 

   $category= $name = $email = $message = $totalPages = $pageNumber = "";
   $categoryErr = $nameErr = $emailErr = $messageErr = "";

   if(isset($_POST["operation"])){

        $isErrored = false;

 

        if(empty($_POST["message"])){
             $isErrored = true;
             $messageErr = "Please write your message";

        }else {
            $message = $_POST["message"];
        }


        if(empty($_POST["category"])){
             $isErrored = true;
             $categoryErr = "Please choose a category";

        }else {
            $category = $_POST["category"];
        }

        if(!$isErrored){

        	$serialNo = $_SESSION["userSrNo"];

        	$sql = "SELECT * FROM Members_Profile WHERE serial_no='$serialNo'";
       	$result = $db->query($sql);

       // echo "result: ". $result;

      	if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) 

         {
            $companyName = $row["company_name"];
            $contactPerson = $row["contact_person"];
            $phone = $row["phone"];
            $email=$row["email"];

         }

         $_POST["email"]=$email;
         $_POST["name"]=$contactPerson;
         $_POST["companyName"] = $companyName;
         $_POST["phone"] = $phone;

            include_once "user-operations.php";
              // echo "<meta http-equiv='refresh' content='0;messages.php'>";
              //  exit;

 		   }

        	


        }

   }


?>


           <?php
           
           	if (isset($_GET["oper"]) && $_GET["oper"]=="addPost"){

           		// echo "get request";
           	//Show the form ?>	

				 <form  role="form" action="" method="post"  class="form-horizontal" class="row" >
                      
                        <input type="hidden" name="operation" value="drop-message"/>
                        <input type="hidden" name="premium_val" value="1"/>

                               <!-- <span  id="nameMessage" class="col-sm-offset-2 error" ><?php echo $nameErr;?></span>
                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Your Name:<sup>*</sup></label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control input-sm <?php if(!$nameErr==""){echo " errorBox" ;} ?>" id="name" name="name">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                   <span  id="emailMessage" class="col-sm-offset-2 error" ><?php echo $emailErr;?></span>
                                    <div class="form-group">
                                        <label for="email" class="control-label col-sm-2">Your e-mail address:<sup>*</sup></label>
                                        <div class="col-sm-9">
                                          <input type="email" class="form-control  input-sm <?php if(!$emailErr==""){echo " errorBox" ;} ?>" id="email" name="email">
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>-->

                            <span  id="categoryMessage" class="col-sm-offset-2 error" ><?php echo $categoryErr; ?></span>
                             <div class="form-group">
                              <label for="category" class="control-label col-sm-2">Category:&nbsp;<sup>*</sup></label>
                                <div class="col-sm-6">
                                <select class="input-box  input-sm form-control<?php if(!$categoryErr==""){echo " errorBox" ;} ?>" id="category"  name="category" >
                                <option value="" ></option>

                                <?php
                                 // $sql="select * from Members_Categories" ;

                                    $result = $db->query(getMembersCategories);

                                    if ($result->num_rows > 0) {

                                         while($row = $result->fetch_assoc()) {

                                         //    echo "id: " . $row["ID"]. " - category_ID: " . $row["category_ID"]. "  - category_desc:" . $row["category_desc"]. "<br>";
                                        
                                        ?>
                                 <option value= "<?php echo $row["category_desc"]; ?>" <?php if($category==$row["category_desc"]){echo "selected";} ?> ><?php echo $row["category_desc"]; ?></option>

                                        <?php }
                                    } 
                                 ?>
                             </select>
                             </div>
                              <div class="col-sm-1"></div>
                          </div> 

                                   <span  id="messageMessage" class="col-sm-offset-2 error" ><?php echo $messageErr;?></span>
                                    <div class="form-group">
                                        <label for="message" class="control-label col-sm-2">Message:<sup>*</sup></label>
                                        <div class="col-sm-9">
                                        <textarea type="text" class="form-control input-sm <?php if(!$messageErr==""){echo " errorBox" ;} ?>"  id="message" rows="5" columns="5" name="message"></textarea>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                    <div class="col-sm-offset-9 col-sm-3">
                                          <button type="submit" class="btn btn-default">Submit</button>
                                    </div>

                        </form>

		<?php 
           }else {


             $start = 0;
              $range = 10;

                if (isset($_GET["oper"]) && $_GET["oper"]=="showMessage"){  
                    $start = $_GET["start"];
                 }


              $totalMessages = $db -> query("SELECT ID FROM Messages where disable=0");
                
                if ($totalMessages->num_rows > 0) {
                   $messageCount=$totalMessages->num_rows;
                   // echo (floor($totalPages/10));
                    $totalPages = (floor($messageCount/10) + 1);
                    

                }
           	    
                $pageNumber = (floor($start/10)+1);

           	    $result = $db->query("SELECT *  FROM Messages where disable=0  ORDER BY created_date DESC LIMIT ".$start." , ".$range. ";");
                

                if ($result->num_rows > 0) { 

                  while($row = $result->fetch_assoc()) {?>




               <div class="row">
                          <div class="col-sm-offset-2  col-sm-9 trasparent-bg  page-content-style">
                          
                          <div id="message-<?php echo $row["ID"];  ?>"></div>
                          <div  class="center" ><b><?php if($row["premium_val"]==1)
                          {echo "Member Inquiry" ; }else {echo "Visitor Inquiry" ; } ?></b>&nbsp;for&nbsp;<b><?php echo $row["category"];?>.&nbsp;</b></div><br />
                         
                          <div class="row">
                              <div class="col-sm-4"><i>From&nbsp;:&nbsp;</i><b><?php echo $row["name"];?></b></div>
                              <div class="col-sm-4"><i>Company name&nbsp;:&nbsp;</i><b><?php echo $row["company_name"];?></b></div>
                              <div class="col-sm-4"><i>Email&nbsp;:&nbsp;</i><b><?php echo $row["email"];?></b></div>
                          </div>
<!--                           	<div class="" id="message-<?php echo ""  ?>"><b><i>Inquiry&nbsp;:&nbsp;</i></b></div>
 -->                            <div class="row">
                              <div class="col-sm-10">                               
                            		<p><?php echo nl2br(str_replace('\\r\\n', "\r\n", $row["message"])); ?></p>
                            </div>                        
                            </div>
                            <div class="row">
                            	<div class="col-sm-offset-9 col-sm-3">
                            		<button type="button" onClick="forwardMessage(<?php echo $row["ID"];  ?>,'message-<?php echo $row["ID"];  ?>')">Send to my email</button>
                          	</div>
                            </div>

                          </div>
                          <div class="col-sm-1"></div>

              </div>
                <?php }

              }



           }






  ?>
    <div class="center"><ul id="paginator"></ul></div>

    </div> <!-- -page div ends -->  

    <script type='text/javascript'>
        var options = {
            size:"small",
            bootstrapMajorVersion:3,
            // currentPage: 1,
            // totalPages: 3,
            currentPage: <?php echo $pageNumber ; ?>,
            totalPages: <?php echo $totalPages ; ?>,
            onPageClicked : function(e, originalEvent, type, page) {
               fetchMessages(page)
            },
        }


        $('#paginator').bootstrapPaginator(options);

          function fetchMessages(page) {
            var start = (page * 10) - 10;
          window.location.href="?oper=showMessage&start="+start+"&range=10";
          }
    </script>


<?php include_once "common/footer.php"; ?>