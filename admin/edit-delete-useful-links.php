<?php 

// if (isset($_GET["oper"]) ) {

	
	include_once "admin-operations.php";

if ($_SERVER['REQUEST_METHOD']==="GET") {
	
	if (isset($_GET["oper"]) ) {

				if ($_GET["oper"] === "edsul") {
                $urls = explode('|', $status["url"]); ?>
				

				<form id="editLink<?php echo $_GET["id"] ?>-form"  style="padding:10px;" method="post" >

					<div class="space-after-para">
                      
                       		<div class="form-group row">

                       			<label for="title<?php echo $_GET['id'] ?>" class="col-sm-4">Link Title:</label>
                       			 <input  class="input-box col-sm-8" type="text" required="" id="title<?php echo $_GET['id'] ?>"  name="title<?php echo $_GET['id'] ?>" 
                       			 value="<?php echo $status["title"]; ?> "/>
                       
								<input name="ID" type="hidden" value="<?php echo $status["ID"]; ?>"/>

            
                     		 </div> 
						

							<div id="edit-add-url-<?php echo $_GET['id']?>" class="form-group row">

							                            

	                          <?php for ($i=0; $i < count($urls); $i++) { 

	                          			$url = $urls[$i];
	                          		?>
								  <label for="urls[]" class="col-sm-4">Link URL:</label>	 
	                              <input  class="form-control input-box col-sm-6" type="text" required="" id="edit-add-url-<?php echo $_GET['id'].'-'.$i ?>[]"  name="urls[]" 
	                              value="<?php echo $url ?> "/>
	                              	
	            
	                          <?php } ?>
	                          <a href="#" class="col-sm-1"  onClick="addInput('edit-add-url-<?php echo $_GET['id']?>','<?php echo $i; ?>');"><span class="sign-link">+</span></a>
 	                          	<!-- <input  class="col-sm-1" type="button" value="+" onClick="addInput('edit-add-url-<?php echo $_GET['id']?>','<?php echo $i; ?>');">                          	 -->

									
                           </div>

                      <div class="form-group row">
                        <label for="enabled<?php echo $_GET['id'] ?>"  class="col-sm-4">Link enable:</label>
                           <select class="form-control input-box col-sm-4" type="select" required="" id="enabled<?php echo $_GET['id'] ?>"  name="enabled<?php echo $_GET['id'] ?>">
                              <option value="1" <?php if($status['enabled']== 1) { echo "selected"; } ?>>Enable</option>
                              <option value="0" <?php if($status['enabled']== 0) { echo "selected"; } ?>>Disable</option>                         
                          </select> 
                      </div>


                        <div class="form-group row">
                        <label for="premium_val<?php echo $_GET['id'] ?>"  class="col-sm-4">Link Premium Value:</label>
                          <select  class="form-control input-box col-sm-2"  type="select" required="" id="premium_val<?php echo $_GET['id'] ?>" name="premium_val<?php echo $_GET['id'] ?>">
                            <option value="0" <?php if($status['premium_val']== 0) { echo "selected"; } ?>>Regular</option>
                            <option value="1" <?php if($status['premium_val']== 1) { echo "selected";} ?>>Premium</option>                         
                          </select>         
                      </div>


							
	                            <div class="col-sm-offset-4 col-sm-8" style="padding:10px;">
<!-- 		                            <button type ="Button" onClick="javascript:updateUsefulLink('<?php echo $status["ID"];?>');" >Update</button> -->		                            
									<button type ="Button" onClick="javascript:updateUsefulLinks('<?php echo ACTION_UPDATE;?>','<?php echo $status["ID"];?>');" >Update</button>
		                            <button type ="Button" onClick="javascript:updateUsefulLinks('<?php echo ACTION_DELETE;?>','<?php echo $status["ID"];?>');" >Delete</button>

		                            <button type="Reset">Reset</button>
		                            <button type="button"  onclick="cancelForm('editLink<?php echo $status["ID"];?>');">Cancel</button>
		                     	</div>


					</div>
			</form>

	
		<?php }else if ($_GET["oper"] == "edul"){

		

		// echo "status:".$status;
		?>
				
				<div id="editLinkResult<?php echo $_GET["id"]; ?>">

					<div>
						<span><?php echo $status; ?></span>
						<button type="Button" onClick="javascript:cancelDiv('editLinkResult<?php echo $_GET["id"]; ?>')">Ok!</button>					
					</div>
				</div>
		<?php


		}

	}

		
		

} else if ($_SERVER['REQUEST_METHOD']==="POST") {    

	?>

	<div id="editLinkResult<?php echo $_POST["id"]; ?>">

					<div>
						<span><?php echo $status; ?></span>
						<button type="Button" onClick="javascript:cancelDiv('editLinkResult<?php echo $_POST["id"]; ?>')">Ok!</button>					
					</div>
				</div>
	
<?php }


?>



