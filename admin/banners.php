  
<?php include_once "common/header.php"; ?>
<?php 

 $orderErr = $linkErr = $imageErr = $enableErr = array();
 $banners = array();
 $index =0;

  $result = $db->query(getBanners);
                

                if ($result->num_rows > 0) { 

                  while($row = $result->fetch_assoc()) {
                            $banners[$index]['id']= intval($row["ID"]);
                            $banners[$index]['order'] = $row["Image_order"];
                            $banners[$index]['name'] = $row["Image_name"];
                            $banners[$index]['company'] = $row["company_name"];
                            $banners[$index]['link'] = $row["link"];
                            $banners[$index]['enable'] = $row["enabled"];
                            $index++;
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
		 
    <div class="space-after-para">
           <button type="button" onClick="location.href='add-update-banner.php'">Add Banners</button>
    </div>

			<form action="banners.php" id="toy-guide-form" role="form"  method="post"   class="form-horizontal"  enctype="multipart/form-data">
					
					 <?php 
		                   $addAdvtsToken = sha1(time());
		                  $_SESSION["addAdvtsToken"]=$addAdvtsToken; 

                  		?>

	                <input type="hidden" name="operation" value="add-banners"/>
	                <input type="hidden" name="addNewsEventsPost" value="<?php echo $addAdvtsToken ;?>"/>

        					<div class="form-group row" id="banners-div">
                  <div class="row heading">
                    <div class="col-sm-1">Order</div>
                    <div class="col-sm-3">Company</div>
                    <div class="col-sm-3">Link</div>
                    <div class="col-sm-2">Image</div>
                    <div class="col-sm-1">Enable</div>
                    <div class="col-sm-2">Update</div>
                  </div>
        				<?php 
        							if(empty($banners)){
        								$arrSize = count($banners);
        								$banners = new SplFixedArray(1);
        							}
        							foreach ($banners as $i => $banner)
        						
        							{ ?>
        								<div id="banners-div-<?php echo $i?>" class="row" style="padding-bottom:10px;">												
        										<div class="" id="">
        											<div class="col-sm-1 center"><?php echo $banners[$i]['order'] ?></input></div>
        											<div class="col-sm-3"><?php echo $banners[$i]['company'] ?></input></div>					
        											<div class="col-sm-2"><a href="<?php  if(!(substr($banners[$i]['link'],0,4)=="http")){echo "http://" ;}echo $banners[$i]['link'] ;?>" target="_blank"><?php echo $banners[$i]['link'] ?></a></input></div>
        											<div class="col-sm-3 center">
                                                        <img src="<?php echo BANNER_FOLDER.$banners[$i]['name'] ?>"  class="img-thumbnail">
<!--                                                         <a href="<?php echo BANNER_FOLDER.$banners[$i]['name'] ?>" target="_blank"><?php echo $banners[$i]['name'] ?></a> -->
                                                    </div>

        											<div class="col-sm-1">
                                                        <?php if($banners[$i]['enable']){echo 'Enabled' ; }else {echo 'Disabled' ;} ?>
        											</div>

        					             <div class="col-sm-2">
                                    <button onclick="location.href='add-update-banner.php?oper=edit&amp;id=<?php echo $banners[$i]['id']; ?>'" type="button">Edit</button>
                                    <button onClick="javascript:deleteNewsAndNotice('<?php echo ACTION_DELETE_BANNER;?>','<?php echo $banners[$i]['id'] ?>');" >Delete</button>
                                </div>												
        										</div>												
        								</div>			
        										
        						<?php	}  ?>

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
