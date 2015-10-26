<?php 
	
	$isErrored=false;

 		$email = test_input($_POST["email"]);
 
 		if (empty($_POST["email"])) {
 		  $isErrored = true;
    	  $emailErr = "Email is required";
    	}

		//validate password
	   if (empty($_POST["password"])) {
	   	   	$isErrored = true;
	   		$passwordErr=ERR_PASSWORD_REQUIRED;

	   } else{
	   	   	 $password = test_input($_POST["password"]);
	   	 
	   	 if(strlen($password)<6){
	   	 	$isErrored = true;
	   	 	$passwordErr= ERR_PASSWORD_LENGTH;
	   	 }

	   }

	   //validate confirm password 
	   if (empty($_POST["confirmPassword"])) {
	   	 	$isErrored = true;	   	
	   		$confirmPasswordErr=ERR__CONFIRM_PASSWORD_REQUIRED;

	   } else{
	   		$confirmPassword= test_input($_POST["confirmPassword"]);
	   		if(strcmp($password,$confirmPassword)){
	   	 		$isErrored = true;	   	
	   			$confirmPasswordErr=ERR_PASS_NO_MATCH;
	   		}
	   }




	 	if (empty($_POST["companyName"])) {
	   	 	$isErrored = true;	   	
	 		$companyNameErr= ERR_COMPANY_REQUIRED;
	   	}else {
	   		$companyName = test_input($_POST["companyName"]);
	   	}

	   	if(!empty($_POST["contactPerson"])) {
			$contactPerson = test_input($_POST["contactPerson"]);
		}


	   	 if (empty($_POST["address1"])) {
	   	 	$isErrored = true;	   	
	   	 	$address1Err= ERR_ADDRESS1_REQUIRED;
	   	 }else {
	   	 	$address1=test_input($_POST["address1"]);
	   	 	$address1=($_POST["address1"]);

	   	 }

	   	 if (!empty($_POST["address2"])){

	   	   	 	$address2=test_input($_POST["address2"]);
	   	 }


	   	 if (empty($_POST["city"])) {
	   	 	$isErrored = true;	   	
	   	 	$cityErr=ERR_CITY_REQUIRED;
	   	} else {
	   		$city = test_input($_POST["city"]);
	   	}

	   	 if (empty($_POST["pincode"])) {
	   	 	$isErrored = true;	   	
	   	 	$pincodeErr=ERR_PINCODE_REQUIRED;
	   } else {
	   		$pincode = test_input($_POST["pincode"]);
	   		// if(! preg_match('/^\[0-9]$/', $pincode) ){
	   	 // 		$isErrored = true;	   	
	   		// 	$pincodeErr=ERR_PINCODE_INVALID;
	   		// }

	   }

	   	 if (empty($_POST["state"])) {
	   	 	$isErrored = true;	   	
	   	 	$stateErr=ERR_STATE_REQUIRED;
	   } else {
	   		$state = test_input($_POST["state"]);	   	
	   }

	   	if (empty($_POST["phone"])) {
	   	 	$isErrored = true;	   	
	   	 	$phoneErr=ERR_PHONE_REQUIRED;
	   } else {
	   		$phone=test_input($_POST["phone"]);
	   		// if(! preg_match('/^\d{10}$/', $mobile) ){
	   		// 	// $mobileErr=ERR_MOBILE_INVALID;
	   		// 	$mobileErr=ERR_MOBILE_LENGTH;
	   		// }

	   }

	   if (!empty($_POST["mobile"])) {

	   		$mobile = test_input($_POST["mobile"]);

	   		if(! preg_match('/^\d{10}$/', $mobile) ){
	   	 		$isErrored = true;	   	
	   			$mobileErr=ERR_MOBILE_LENGTH;
	   		}
	   	
	   	}

	   	if(!empty($_POST["website"])){

	   		$website = test_input($_POST["website"]);

	   		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)){
	   	 		$isErrored = true;	   	
	   			$websiteErr=ERR_WEBSITE_INVALID;
	   		}


	   	}


	   	if(empty($_POST["region"])){
	   	 	$isErrored = true;	   	
	   		$regionErr=ERR_REGION_REQUIRED;

	   	}else{
	   		$region=test_input($_POST["region"]);
	   	}

	   	if(empty($_POST["category"])){
	   	 	$isErrored = true;	   	
	   		$categoryErr=ERR_CATEGORY_REQUIRED;
	   	}else {
	   		$category = test_input($_POST["category"]);
	   	}


   		if(empty($_POST["memberType"])){
	   	 	$isErrored = true;	   	
	   		$memberTypeErr=ERR_MEMBER_TYPE_REQUIRED;
	   	}else{
	   		$memberType = intval($_POST["memberType"]);
	   	}



   		if(!empty($_POST["memberSpecifiedCategory"])){
	   		$memberSpecifiedCategory = test_input($_POST["memberSpecifiedCategory"]);
		}



	   	   	if(!empty($_POST["otherDetails"])){
	   	   		$otherDetails = test_input($_POST["otherDetails"]);
	   		
	   	}


			
		if(!empty($_FILES["doc1"]["tmp_name"])){
			$filename = $_FILES["doc1"]["tmp_name"];
			
			$fileSize = $_FILES["doc1"]["size"];

			 echo $fileSize;
			if($fileSize>1048576){
				$doc1Err = ERR_DOC_INVALID_SIZE;
			}
		}

		if(!empty($_FILES["doc2"]["tmp_name"])){
			$filename = $_FILES["doc2"]["tmp_name"];
			
			$fileSize = $_FILES["doc2"]["size"];

			 echo $fileSize;
			if($fileSize>1048576){
				$doc2Err = ERR_DOC_INVALID_SIZE;
			}
		}






	
if (!$isErrored) {
	include_once "register-success.php"; ?>
<!-- 	                 <div class="row">
                  <div  id ="message" class="col-sm-offset-2 col-sm-10"  > 
                    <ul>
                    <?php 



                      $statusCode = $status[0]; 

                   if(!$statusCode){
                   	 echo "<meta http-equiv='refresh' content='0;/taitma/register-success.php'>";
                   exit;

                    }
                      if($statusCode) { ?><div style="color:red;"> <?php }
                        
                    foreach ($status[1] as $key) {?>

                        <li><?php echo "\n$key\n"; ?></li>
                      
                       <?php }
                      
                       if($statusCode) { ?></div>  <?php }                   
                    ?>
                    </ul>
                 </div>
                 </div> -->
<?php }


   function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>