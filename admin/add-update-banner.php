<?php include_once "common/header.php"; ?>
<?php 

$id=0;
 $orderErr = $linkErr = $imageErr = $enableErr = array();
 $banners = array();

      if ($_SERVER['REQUEST_METHOD']==="GET") {
                 if(isset($_GET["id"])){

                if(!empty($_GET["id"])){

                 $id = $_GET["id"];
                 $query = getBannerWithID.$id;
                  $result = $db->query($query);
                     // echo "no of rows ::".  $result->num_rows ; 
                        if ($result->num_rows > 0) { 

                          while($row = $result->fetch_assoc()) {
                           	$id= intval($row["ID"]);
 							$banners[0]['id']= intval($row["ID"]);
                            $banners[0]['order'] = $row["Image_order"];
                            $banners[0]['name'] = $row["Image_name"];
                            $banners[0]['company'] = $row["company_name"];
                            $banners[0]['link'] = $row["link"];
                            $banners[0]['enable'] = $row["enabled"];

                         }
                }

          }
                          
            
          }
      }




	if(isset($_POST["operation"]) && isset($_SESSION["addAdvtsToken"])){

		$id=$_POST["ID"];

		if ($_SESSION["addAdvtsToken"]==$_POST["addNewsEventsPost"]) {
			$_SESSION["addAdvtsToken"]="";

			$isErrored = false;
			$advertisments = $banners = $_POST["banners"];

			foreach ($banners as $i => $banner) {
			 	
// 			 	echo "i is".$i;
// 			  printf("%s %s \n",$banner['order'],$banner['link']);			 					

			 	// Validate Order 					
			 	if(empty($banner['order'])){
						$isErrored = true;
						$orderErr[$i] = "Please provide an order.";
					}else{
						$banners[$i]['order'] = $banner['order'];
						if(!ctype_digit($banner['order'])){
							$isErrored = true;
				 			$orderErr[$i] = "Order must be a number.";
				 		}
					}

				//validate Company 
				if(empty($banner['company'])) {
						$isErrored = true;
						$companyErr[$i] = "Please provide a company name.";
				}


					
				// validate link
			 	// if(empty($banner['link'])){
			 	// 	$isErrored = true;
			 	// 	$linkErr[$i] = "Please provide a link";
			 	// }

			 	if(!empty($banner['link'])) {	
			 		$banners[$i]['link']=test_input($banner['link']);
			 		// $regex ="/^(www)((\.[A-Z0-9][A-Z0-9_-]*)+.(com|org|net|dk|at|us|tv|info|uk|co.uk|biz|se)$)(:(\d+))?\/?/i"
			 		$regex = "/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\.\/\?\:@\-_=#])*/";

			 		if(!preg_match($regex, $banner['link'])){
			 				$isErrored = true;
			 				$linkErr[$i]= ERR_WEBSITE_INVALID;
			 		}
				}

				// Validate uplaoded file

				if($id == 0 ){
					$file['image']['error'] = $_FILES["banners"]["error"][$i]['image'];

				 	if($file['image']['error']){
				 		$isErrored = true;
						$imageErr[$i] = "Please upload an image.";
			 		}
			 		else {
			 			$image_info = getimagesize($_FILES["banners"]["tmp_name"][$i]['image']);
						$image_width = $image_info[0];
						$image_height = $image_info[1];
// 						 printf("%s %s \n",$image_width,$image_height);

						if($image_height < 50 OR $image_height>100){
						 	$isErrored = true;
						 	$imageErr[$i] = "Please upload an image of height between 60px-100px.";

						 }
			 	 	}
				}else{

					$banners[$i]['name'] = $banner['image'];
				}


		 	 	// Validate enabled
			 	if($banner['enable']==""){
			 		$isErrored = true;
			 		$enableErr[$i] = "Please choose a value.";
			 	}else{
		 	 		$banners[$i]['enable']=test_input($banner['enable']);
		 		}

		 		if(!$isErrored){
		 			include_once "admin-operations.php";
		 			  echo "<meta http-equiv='refresh' content='0;/admin/banners.php'>";
                         exit;

		 		}

			}
		}
	}
?>

    
  <div id=""  class="page-background"> <!--home-main starts -->

    <div id="toy-guide-page" class="page-contents"> <!--toy-guide-page div starts  -->

          <?php include_once "common/inner-nav-bar.php"; ?>

			<div class="col-sm-offset-1  col-sm-10 trasparent-bg  page-content-style">

			 <!-- <button type="button" data-toggle="modal" data-target="#addBanners">Add Banners</button> -->

	
	<!-- 	<div id="addBanners" name="addBanners" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog "> -->

              	<!-- Modal content-->
                <!-- <div class="modal-content custom-modal" style="border:1px solid #0ABDC8">
                    <div class="modal-header site-header white-text ">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="center">Add Banner</h4>
               </div>

                <div class="modal-body transparent-bg"> -->
			<form action="" id="toy-guide-form" role="form"  method="post"   class="form-horizontal"  enctype="multipart/form-data">
					
					 <?php 
		                   $addAdvtsToken = sha1(time());
		                  $_SESSION["addAdvtsToken"]=$addAdvtsToken; 

                  		?>

	                <input type="hidden" name="operation" value="add-banners"/>
	                <input type="hidden" name="addNewsEventsPost" value="<?php echo $addAdvtsToken ;?>"/>
	                <input type="hidden" name="ID" value ="<?php echo $id?>" />

					<!-- <div class="row">
						<div class="col-sm-1"><h6>Order</h6></div>
						<div class="col-sm-3"><h6>Company</h6></div>
						<div class="col-sm-3"><h6>Link</h6></div>
						<div class="col-sm-2"><h6>Image</h6></div>
						<div class="col-sm-2"><h6>Enable</h6></div>
					</div> -->


					<div class="form-group row" id="banners-div">
				<?php 
							if(empty($banners)){
								$arrSize = count($banners);
								$banners = new SplFixedArray(1);
							}
							foreach ($banners as $i => $banner)
						
							{ ?>
								<div id="banners-div-<?php echo $i?>" class="col-sm-11">


									<div class="col-sm-offset-5 error" ><?php if(!empty($orderErr[$i])) echo $orderErr[$i]; ?></div>
									<div class="form-group row">
										<div class="col-sm-offset-1 col-sm-2" ><label for="order">Order&nbsp;:<sup>*</sup></label></div>
										<div class="col-sm-6"><input class="form-control  input-box-link <?php if(!empty($orderErr[$i])) echo 'errorBox'; ?>" name="banners[<?php echo $i?>][order]" value="<?php echo $banners[$i]['order'] ?>" type="text" size="10"></div>
									
									</div>


									<div class="col-sm-offset-5 error" ><?php if(!empty($companyErr[$i])) echo $companyErr[$i]; ?></div>
									<div class="form-group row">
										<div class="col-sm-offset-1 col-sm-2" ><label for="order">Company&nbsp;:<sup>*</sup></label> </div>
										<div class="col-sm-6"><input class="form-control input-box-link <?php if(!empty($companyErr[$i])) echo 'errorBox'; ?>" name="banners[<?php echo $i?>][company]" value="<?php echo $banners[$i]['company'] ?>" type="text" ></div>
									
									</div>

									<div class="col-sm-offset-5 error" ><?php if(!empty($linkErr[$i]))echo $linkErr[$i]; ?></div>
									<div class="form-group row">
										<div class="col-sm-offset-1 col-sm-2" ><label for="link">Link</label></div>
										<div class="col-sm-6"><input class="form-control  input-box-link <?php if(!empty($linkErr[$i]))echo 'errorBox'; ?>" name="banners[<?php echo $i?>][link]" type="text"  value="<?php echo $banners[$i]['link'] ?>"></input></div>
									
									</div>
									
									<div class="col-sm-offset-5 error" ><?php if(!empty($imageErr[$i]))echo $imageErr[$i]; ?></div>
									<div class="form-group row">
										<div class="col-sm-offset-1 col-sm-2" ><label for="image">Image&nbsp;:<sup>*</sup></label></div>
										<div class="col-sm-6">
											<?php if($id == 0){?>
												<input class=" input-box-link <?php if(!empty($imageErr[$i]))echo 'errorBox'; ?>" name="banners[<?php echo $i?>][image]" type="file" value="<?php echo $banners[$i]['image'] ?>"></input>
											<?php }else {?>
												<input type = "hidden" name="banners[<?php echo $i?>][image]" value="<?php echo $banners[$i]['name'] ?>">
                                                        <img src="<?php echo BANNER_FOLDER.$banners[$i]['name'] ?>"  class="img-thumbnail">
											<?php }?>

										</div>
									
									</div>
									
									<div class="col-sm-offset-5 error" ><?php if(!empty($enableErr[$i]))echo $enableErr[$i]; ?></div>
									<div class="form-group row">
										<div class="col-sm-offset-1 col-sm-2" ><label for="enable">Enable&nbsp;:<sup>*</sup></label></div>
										<div class="col-sm-6">
											<select class="form-control input-box-link <?php if(!empty($enableErr[$i]))echo 'errorBox'; ?>" type="select"  name="banners[<?php echo $i?>][enable]" >
						                            <option value=""  >Please choose an option.</option>
						                            <option value="1" <?php if(isset( $banners[$i]['enable']) && $banners[$i]['enable']=="1")  echo 'selected' ?> >Enable</option>
						                            <option value="0" <?php if(isset( $banners[$i]['enable']) && $banners[$i]['enable']=="0")  echo 'selected'?> >Disable</option>                         
						                        </select> 
										</div>
									
									</div>
									
								
								</div>			
										
						<?php	}  ?>

					</div>					

				<div class="form-group row center">
					<button type="submit">Submit</button>
					<button type="Reset">Reset</button>
					<button type="Button" onCLick="location.href='banners.php'">Cancel</button>
				</div>
				</form>

                <!-- </div>
            </div>                
        </div> -->

			</div>



  
    </div> <!--toy-guide-page div ends  -->
  
<?php include_once "common/footer.php"; ?>

<script type="text/javascript">



</script>
