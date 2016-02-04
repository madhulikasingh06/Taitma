<?php 
 include_once "common/constants.db.php";
 include_once "common/db_connect.php";
 include_once "constants.inc.php";
 include_once "swiftmailer-5/lib/swift_required.php";



class taitmaMembersOperation {

	/**
     * The database object
     *
     * @var object
     */
    private $_db;


    private $ADMIN_EMAILS  = array('madhulikasingh06@gmail.com');

    /**
     * Checks for a database object and creates one if none is found
     *
     * @param object $db
     * @return void
     */
    public function __construct($db=NULL)
    {

        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (mysqli_connect_error()) {
			  die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
 			}
        }
    }



    public function processRequest($operation){

    	if($operation=="register-user"){
    		 return $this->registerUser();
    	}else if ($operation=="log-in"){
            return $this->login1();
        }else if ($operation=="log-out"){
            return $this->logOut();
        }else if ($operation=="emailExists"){
            // return $this->checkIfEmailExistsOld();
           return $this-> validateEmail();
        }else if ($operation == "ver"){
            return $this -> verfityAccount();
        }else if ($operation == "edit-profile"){
            return $this -> updateProfile();
        }else if ($operation == "newPwd"){
          return $this -> generateNewPassword();
        }else if ($operation == "drop-message"){
          return $this -> dropMessage();
        }else if($operation == "forwardMessage"){
         return $this -> forwardMessage();
        }


    }


    private function registerUser() {

        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $company_name = $_POST["companyName"];
        $contact_person = $_POST["contactPerson"];
        $address_1 = $_POST["address1"];
        $address_2 = $_POST["address2"];
        $city = $_POST["city"];
        $pincode = $_POST["pincode"];
        $state = $_POST["state"];
        $phone = $_POST["phone"];
        $mobile = $_POST["mobile"];
        $website = $_POST["website"];
        $region = $_POST["region"];
        $category = $_POST["category"];
        $member_specified_category = $_POST["memberSpecifiedCategory"];
        $member_type = $_POST["memberType"];
        $other_details = $_POST["otherDetails"];
        // $doc_1 = file_get_contents($_POST["doc1"]) ;
        $doc_1 = NULL;
        $doc_2 = NULL;
        $doc_2_size=0;

        $serial_number ="";
        $verCode= sha1(time());       
        $returnMessage = array();
        $result =  array();


        $email = stripslashes($email);


        try {

           // encrypt the password
            $password = md5(stripslashes($password));

            $stmt = $this->_db->prepare("CALL RegisterNewMemeber(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@serialNumber)");
            $stmt -> bind_param("ssssssssssssssssss",$password, 
                                                       $company_name , 
                                                        $contact_person, 
                                                        $address_1, 
                                                        $address_2, 
                                                        $city, 
                                                        $pincode,
                                                        $state, 
                                                        $phone,
                                                        $mobile,
                                                        $email, 
                                                        $website, 
                                                        $region, 
                                                        $category,
                                                        $member_specified_category, 
                                                        $member_type,
                                                        $other_details,
                                                        $verCode);


                    
                if($select=$stmt->execute()) {

                        $stmt->bind_result($serialNumber);

                            while ($stmt->fetch()){

                                 // echo "user created with  id : $serialNumber";

                               //create the verification link link


                                // echo $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
//                                  $verificationLink = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/verifyAccount.php?oper=ver&ver=$verCode&em=$serialNumber";
                                 
                                $verificationLink = $_SERVER["SERVER_NAME"]."/verifyAccount.php?oper=ver&ver=$verCode&em=$serialNumber";


                                // echo "Verification link is :: ".$verificationLink;

                                 //send the email 



                                         if(!empty($_FILES["doc1"]['tmp_name'])) {
                                            
                                              $doc1_tmpname=$_FILES['doc1']['tmp_name'];
                                              $doc_1 = file_get_contents($doc1_tmpname);
                                              $doc_1_filename=$serialNumber."_1_".$_FILES["doc1"]["name"];
                                               move_uploaded_file($doc1_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc_1_filename);


                                         
                                        }
                                        if(!empty($_FILES["doc2"]['tmp_name'])) {
                                                   $doc2_tmpname=$_FILES['doc2']['tmp_name'];
                                                  $doc_2 = file_get_contents($doc2_tmpname);
                                                  $doc_2_filename= $serialNumber."_2_".$_FILES["doc2"]["name"];
                                                  move_uploaded_file($doc2_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc_2_filename);

                                        }


                                        $this->sendVerificationEmail($email,$verificationLink);

                                $returnMessage1 = MSG_ACCOUNT_REGISTRATION_SUCCESS."\n User created with verfication  link : $verificationLink ";
                                // $returnMessage[] = MSG_ACCOUNT_REGISTRATION_SUCCESS;

                                $result =  array(SUCCESS ,$returnMessage1);

                            }




                }else {
                         echo "error  ::". $this->_db->error;
                         $returnMessage[] ="Error occurred : ". $this->_db->error;                         
                         $result= array(ERROR ,ERR_ACCOUNT_REGISTRATION_FAILED);

                }


           $stmt->close();  
        } catch (Exception $pe) {
            echo "in registerUser method error msg: ".$pe->getMessage();
            die("Error occurred:" . $pe->getMessage());
            $result =  array(ERROR ,ERR_ACCOUNT_REGISTRATION_FAILED);
        }

        return  $result;
    }



    private function sendVerificationEmail($email,$verificationLink){
            
             $subject = EMAIL_VERIFICAITON_SUBJECT;
            $from = array(EMAILID_FROM =>EMAIL_FROM);
            $to = array( $email => $email);

            $text = "Please verify by clicking on below link :". $verificationLink;
            $html = "Please verify by clicking on below link <br/>"."http://".$verificationLink;

            $transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT);
            $transport->setUsername(SMTP_USER);
            $transport->setPassword(SMTP_PASSWORD);
            $swift = Swift_Mailer::newInstance($transport);

            $message = new Swift_Message($subject);
            $message->setFrom($from);
            $message->setBody($html, 'text/html');
            $message->setTo($to);
            $message->addPart($text, 'text/plain');

            if ($recipients = $swift->send($message, $failures))
            {
             // echo 'Message successfully sent!';
            } else {
             // echo "There was an error:\n";
             // print_r($failures);
            }
    }


/**
*   function verfityAccount
*   Called when a user verifies the account .
*
*
**/

    private function verfityAccount(){

       $verification_code = $_GET['ver'] ;
       $serialNumber = $_GET['em'];


        $returnMessage = array();


        // echo "account verified verification_code : $verification_code and serialNumber : $serialNumber";

        try {
            
            $stmt = $this->_db->prepare("CALL verifyMemberAccount(?,?,@verified)");
            $stmt -> bind_param ("ss",$serialNumber,$verification_code);

             if ($select=$stmt->execute()) {

                        $stmt->bind_result($verified);

                            while ($stmt->fetch()){
                          
                                if($verified==1){

                                   $result= array(SUCCESS ,MSG_ACCOUNT_VERIFIED_SUCCESS);

                                }else if ($verified==0) {
                                     $result= array(ERROR ,ERR_ACCOUNT_ALREADY_VERIFIED);

                                }
                                else if ($verified==-1){
                                    $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

                                }

                            }

                         $returnMessage[] = "User verified with serialNumber : $serialNumber";


            }else {
                          echo "error  ::". $this->_db->error;
                         $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

            }

             $stmt->close();

        } catch (Exception $pe) {
            echo "in verfityAccount method error msg: ".$pe->getMessage();
              die("Error occurred:" . $pe->getMessage());
            $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

        }

            return $result;
    }






/**
*   function login
*   Called when a user logs in.
*
*
**/

    private function login() {

        $email = $_POST["email"];
        $password = $_POST["pwd"];  
        $result = "";


        // echo "email : $email | password :  $password.";
        $password = md5(stripslashes($password));

        // $sql = "SELECT email FROM Members_Profile WHERE email=? and password =?";


        try {

            $stmt = $this->_db->prepare("CALL verifyMemberLogin(?,?,@accountStatus)");
            $stmt -> bind_param ("ss",$email,$password);


            
                     if ($select=$stmt->execute()) {

                         $stmt->bind_result($accountStatus);

                            while ($stmt->fetch()){

                                // echo "account Status   : $accountStatus";
                                         
                                if($accountStatus== -1 ){

                                    $result= array(ERROR ,ERR_ACCOUNT_LOGIN_FAILED);

                                }else if ($accountStatus == 0) {
                                    
                                    $result= array(ERROR ,ERR_ACCOUNT_LOGIN_UNVERIFIED);

                                }else if ($accountStatus==1 OR $accountStatus==2){
                                    if($accountStatus==1){
                                        $_SESSION["accountStatus"]=$accountStatus;

                                    }
                                    $_SESSION["loggedIN"]=1;
                                    $_SESSION['userID']="$email";

                                    $result= array(SUCCESS ,MSG_ACCOUNT_LOGIN_SUCCESS);


                                }

                            }

                $stmt->close();

            }else {
                          echo "error  ::". $this->_db->error;
                         $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

            }



        } catch (Exception $pe) {
            echo "in login method error msg: ".$pe->getMessage();
              die("Error occurred:" . $pe->getMessage());
            $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

        }

            return $result;


    }


/**
*   function logOut
*   Called when a user logs out.
*
*
**/

    private function logOut() {

        


    }


/**
*   function checkIfEmailExists
*   Called when a user logs out.
*
*
**/

    private function checkIfEmailExistsOld() {

        $returnCode = 0;
        $returnMessage= "sucess checkIfEmailExists";

        $email = $_GET["email"];
       // echo "$email";
       // echo "checkIfEmailExists  $returnMessage";

        
        $sql = "SELECT email FROM Members_Profile WHERE email=?";

            if($stmt = $this->_db->prepare($sql)) {

               $stmt->bind_param("s", $email);
                
                if($stmt->execute()){


                    $stmt->store_result();

                   // echo "no of rows : ".$rows=$stmt->num_rows; 

                $rows=$stmt->num_rows; 
                    if($rows == 1){

                        //echo "user exists";
                        $returnCode = 1;
                        $returnMessage = "Member already exists.";


                    }else {
                           
                        $returnCode = 0;
                        $returnMessage = "Member email valid.";
                    }

                }else {
                    echo "error  ::". $this->_db->error;
                }   

                $stmt->close();

            }else {
                echo "something wrong in SQL!\n";
                echo "error  ::". $this->_db->error;
            }

         $StatusArray = array("statusCode" => $returnCode ,"statusMessage" => $returnMessage);


        return $StatusArray;


    }

     public function checkIfEmailExists($email) {

        $flag = false;
        
        $sql = "SELECT email FROM Members_Profile WHERE email=?";

            if($stmt = $this->_db->prepare($sql)) {

               $stmt->bind_param("s", $email);
                
                if($stmt->execute()){

                    $stmt->store_result();
                   // echo "no of rows : ".$rows=$stmt->num_rows; 

                    $rows=$stmt->num_rows;


                    if($rows == 1){
                        $flag=true;
                    }

                }else {
                    echo "error  ::". $this->_db->error;
                }   


                $stmt->close();

            }else {
                echo "something wrong in SQL!\n";
                echo "error  ::". $this->_db->error;
            }

         // $StatusArray = array("statusCode" => $returnCode ,"statusMessage" => $returnMessage);


        return $flag;


    }


    private function validateEmail(){

                $email = $_GET["email"];

     $emailErr="";
        if (empty($email) || strlen(trim($email))<1  ) {
          $emailErr = "Email is required";
        } else {
         $email = $this->test_input($email);
         // check if e-mail address is well-formed
         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            if($this->checkIfEmailExists($email)){
                   $emailErr = ERR_EMAIL_EXISTS; 
            }

         }else {
               $emailErr = "Invalid email format!"; 
         }
        }

        return $emailErr ;
    }

   private function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }


    private function updateProfile(){

        $result =  array();
             $password = "";
        $confirmPassword = "";
  
         $email = $_POST["email"];
         $serial_no =intval($_POST["serial_no"]);
        $company_name = $_POST["companyName"];
        $contact_person = $_POST["contactPerson"];
        $address_1 = $_POST["address1"];
        $address_2 = $_POST["address2"];
        $city = $_POST["city"];
        $pincode = $_POST["pincode"];
        $state = $_POST["state"];
        $phone = $_POST["phone"];
        $mobile = $_POST["mobile"];
        $website = $_POST["website"];
        $region = $_POST["region"];
        $category = $_POST["category"];
        $member_specified_category = $_POST["memberSpecifiedCategory"];
        $member_type = $_POST["memberType"];
        $other_details = $_POST["otherDetails"];
        $doc_1 = NULL;
        $doc_2 = NULL;
        $oldFile1 = "";
        $oldFile2 = "";

        $result =  array();

        $email = stripslashes($email);

        if(!empty($_POST["password"])){
                  $password = $_POST["password"];
                  $confirmPassword = $_POST["confirmPassword"];
                  $password = md5(stripslashes($password));

        }




        try {

           // encrypt the password
           
            $stmt = $this->_db->prepare("CALL updateMemberProfile(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@status)");
            $stmt -> bind_param("isssssssssssssssss",
                                                      $serial_no,
                                                      $password,
                                                       $company_name , 
                                                        $contact_person, 
                                                        $address_1, 
                                                        $address_2, 
                                                        $city, 
                                                        $pincode,
                                                        $state, 
                                                        $phone,
                                                        $mobile,
                                                        $email, 
                                                        $website, 
                                                        $region, 
                                                        $category,
                                                        $member_specified_category, 
                                                        $member_type,
                                                        $other_details
                                                        );


                    
                if ($select=$stmt->execute()) {

                        $stmt->bind_result($status);

                            while ($stmt->fetch()){
                              // echo " status : $status";
                              if($status==1){

                                  //update the files 


                                  // Get the local files 



                                   $iterator = new FilesystemIterator(MEMBER_FILE_UPLOAD_FOLDER);
                                   $filter = new RegexIterator($iterator, "/($serial_no)_*.*$/");
                                      if (iterator_count( $filter)>0) {
                                                foreach($filter as $entry) {

                                                        $filename = $entry->getFilename();
                                                        $filenameArray = explode("_", $filename);
                                                 
                                                        if($filenameArray[1]=="1"){
                                                            $oldFile1 = $filename;
                                                        }else if ($filenameArray[1]=="2"){
                                                          $oldFile2 = $filename;
                                                        }

                                                     }
                                                        

                                              }


                                    if(!empty($_FILES["doc1"]['tmp_name'])) {

                                          if(!empty($oldFile1)){
                                          
                                            // Delete the old file and store new file
                                            $docNew_tmpname=$_FILES['doc1']['tmp_name'];
                                            $docNew_filename=$serial_no."_1_".$_FILES["doc1"]["name"];

                                            echo "updating doc 1";
                                            unlink(MEMBER_FILE_UPLOAD_FOLDER.$oldFile1);
                                            move_uploaded_file($docNew_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$docNew_filename);
                                                      

                                          }else {

                                            // store the new file
                                             $doc1_tmpname=$_FILES['doc1']['tmp_name'];
                                             $doc_1_filename=$serial_no."_1_".$_FILES["doc1"]["name"];
                                             move_uploaded_file($doc1_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc_1_filename);

                                         

                                          }


                                    }


                                  if(!empty($_FILES["doc2"]['tmp_name'])) {

                                          if(!empty($oldFile2)){

                                                $doc2New_tmpname=$_FILES['doc2']['tmp_name'];
                                                $doc2New_filename=$serial_no."_2_".$_FILES["doc2"]["name"];

                                               // echo "updating doc 2";

                                                 unlink(MEMBER_FILE_UPLOAD_FOLDER.$oldFile2);
                                                 move_uploaded_file($doc2New_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc2New_filename);
                                                   
                                          }else {

                                                  //echo "inside class doc 2";
                                                  $doc2_tmpname=$_FILES['doc2']['tmp_name'];
                                                  $doc_2_filename= $serial_no."_2_".$_FILES["doc2"]["name"];
                                                  move_uploaded_file($doc2_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc_2_filename);
                                           
                                          }
                                    }
                                         
                                  $result = array(SUCCESS ,MSG_ACCOUNT_EDIT_PROFILE_SUCCESS);
                              } else {
                                  $result = array(ERROR ,ERR_ACCOUNT_EDIT_PROFILE);

                              }

                            }




                }else {
                         echo "error  ::". $this->_db->error;
                         $returnMessage[] ="Error occurred : ". $this->_db->error;                         
                         $result= array(ERROR ,ERR_ACCOUNT_EDIT_PROFILE);

                }


           $stmt->close();  
        } catch (Exception $pe) {
            echo "in registerUser method error msg: ".$pe->getMessage();
            die("Error occurred:" . $pe->getMessage());
            $result =  array(ERROR ,ERR_ACCOUNT_EDIT_PROFILE);
        }


       

        return $result;

    }




    private function generateNewPassword(){ 

        // echo "inside generateNewPassword";

        $username = $_GET["username"];

        $newPassword = bin2hex(openssl_random_pseudo_bytes(4));

        $pwd = md5(stripslashes($newPassword));

        $statusMsg = "";

        //update new password in DB 
            $stmt = $this->_db->prepare("CALL updateNewPassword(?,?,@status)");
            $stmt -> bind_param ("ss",$username,$pwd);
                
                 if ($select=$stmt->execute()) {

                        $stmt->bind_result($status);

                            while ($stmt->fetch()){

                               // echo "account Status   : $status";
                                         
                                if($status== 0 ){

                                    $result= array(ERROR ,PASSWORD_UPDATE_FAILED);
                                }else if ($status==1){



                                      if(strpos($username, '@')){

                                         $html = "Hi,<br/>Your Temporary password is - <b><i>". $newPassword."</i></b><br/>
                                         Please change the password once you login.<br/>Thanks.<br/>Taitma";

                                        $text = "Hi,\nYour Temporary password is - ". $newPassword."\nPlease change the password once you login.\nThanks.\nTaitma";

                                       $subject = PASSWORD_UPDATE_SUBJECT;

                                          $this->sendMail($username,$subject,$html,$text,"");
                                          $statusMsg = PASSWORD_UPDATE_SUCCESS;

                                      }else {

                                           $statusMsg = PASSWORD_UPDATE_SUCCESS;
                                        
                                      }



                                    $result= array(SUCCESS ,$statusMsg);


                                }

                            }

                }else {
                         echo "error  ::". $this->_db->error;
                         $returnMessage[] ="Error occurred : ". $this->_db->error;                         
                         $result= array(ERROR ,ERR_ACCOUNT_EDIT_PROFILE);

                }

                $stmt->close();



                    return $result;




        


    }




      private function sendMail($email,$subject,$html,$text,$replyto){
            
            $from = array(EMAILID_FROM =>EMAIL_FROM);
            
            if(is_array($email)){
              $to = $email;
            }else {
              $to = array( $email=> $email);
            }
            

            
            $transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT);
            $transport->setUsername(SMTP_USER);
            $transport->setPassword(SMTP_PASSWORD);
            $swift = Swift_Mailer::newInstance($transport);

            $message = new Swift_Message($subject);
            $message->setFrom($from);
            $message->setBody($html, 'text/html');
            $message->setTo($to);
            $message->addPart($text, 'text/plain');



            if(!$replyto==""){

              $message->setReplyTo($replyto);
            }


            if ($recipients = $swift->send($message, $failures))
            {
             // echo 'Message successfully sent!';
             return true;
            } else {
              // echo "There was an error:\n";
              // print_r($failures);
               return false;
            }
      }




        private function login1() {

        $email = $_POST["email"];
        $password = $_POST["pwd"];  
        $result = "";


        // echo "email : $email | password :  $password.";
        $password = md5(stripslashes($password));

        // $sql = "SELECT email FROM Members_Profile WHERE email=? and password =?";


        try {

            $stmt = $this->_db->prepare("CALL verifyMemberLogin1(?,?,@accountStatus,@memberType,@serialNo)");
            $stmt -> bind_param ("ss",$email,$password);


            
                     if ($select=$stmt->execute()) {

                        $stmt->bind_result($accountStatus,$memberType,$serialNo);
    
                      /* instead of bind_result: */
                        // $result = $stmt->get_result();

                        /* now you can fetch the results into an array - NICE */
                        // while ($myrow = $result->fetch_assoc()) {
                        //     // printf("%s %s\n", $myrow['accountStatus'], $myrow['memberType']  ,$myrow["serialNo"]);
                        //     echo ("account status ::".$myrow['accountStatus']." and member type ::".$myrow['memberType']."and serial no ::".$myrow["serialNo"]);
                        // }

        

                        while ($stmt->fetch()) {
                          // printf("%s %s %s\n", $accountStatus,$memberType,$serialNo);
                              

                              if($accountStatus== -1 ){

                                    $result= array(ERROR ,ERR_ACCOUNT_LOGIN_FAILED);

                                }else if ($accountStatus == 0) {
                                    
                                    $result= array(ERROR ,ERR_ACCOUNT_LOGIN_UNVERIFIED);

                                }else if ($accountStatus==1 OR $accountStatus==2){
                                       
                                    $_SESSION["accountStatus"]=$accountStatus;
                                    $_SESSION["loggedIN"]=1;
                                    $_SESSION["userID"]=$email;
                                    $_SESSION["userSrNo"]=$serialNo;
                                    $_SESSION["memberType"] = $memberType;

                                    $result= array(SUCCESS ,MSG_ACCOUNT_LOGIN_SUCCESS);


                                }





                      }

                $stmt->close();

            }else {
                          echo "error  ::". $this->_db->error;
                         $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

            }



        } catch (Exception $pe) {
            echo "in login method error msg: ".$pe->getMessage();
              die("Error occurred:" . $pe->getMessage());
            $result= array(ERROR ,ERR_ACCOUNT_VERIFIED_FAILED);

        }

            return $result;


    }


    private function dropMessage(){

        $name=stripslashes($_POST["name"]);
        $email=$_POST["email"];
        $premium_val=stripslashes($_POST["premium_val"]);
        $message=$this->_db->real_escape_string($_POST["message"]);
        $category="";
        if(isset($_POST["category"])){
                  $category=stripslashes($_POST["category"]);

        }
        $companyName = stripcslashes($_POST["companyName"]);
        $phone = stripcslashes($_POST["phone"]);

        $verCode= sha1(time());  
        // By default the message will be disabled, admin will have to approve the message
        $disable = 1;


          $sql = "INSERT INTO Messages(name,email,company_name,phone,message,premium_val,category,disable,verification_code)
                VALUES(?, ?,?,?,?,?,?,?,?)";

                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bind_param("sssssisis", $name, $email,$companyName,$phone, $message, $premium_val,$category,$disable,$verCode);
                   
                    if($stmt->execute()){
                      $status = SUCCESS;
                       $messageId = $this->_db->insert_id;
                       // echo "insert ID ".$userID;
                       //create and send link to admin for approval

                      
                      

//                       $message_approve_link = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/taitma/admin/messages.php?oper=verMes&id=".$messageId."&ver=".$verCode."&ena=0";

                     $message_approve_link = $_SERVER["SERVER_NAME"]."/admin/messages.php?oper=verMes&id=".$messageId."&ver=".$verCode."&ena=0";
                      $message_delete_link = $_SERVER["SERVER_NAME"]."/admin/messages.php?oper=delMes&id=".$messageId;

                      $subject = ADMIN_MESSAGE_APPROVE;

                     $html = "<p>Hi,<br/>A new message has been added as below. <br> <b><i>From: </i></b>".$name." 
                                <br/><b><i>Email: </i></b>".$email."
                                <br/><b><i>Categoty: </i></b>".$category."
                                <br/><b><i>Company Name:</i></b> ".$companyName."
                                <br/><b><i>Phone: </i></b>".$phone."
                                <br/><b><i>Message: </i></b>".nl2br(str_replace('\\r\\n', "\r\n", $message))."<br/></p>

 
                                <br>Please take neccessary action. <br/>
                                <p>For approval Please click on below link - <br/>http://".$message_approve_link."</p>
                                <p>For deletion Please click on below link - <br/>http://".$message_delete_link."</p>";


                      $text = "Hi,\nA new message has been added as below. Please take the neccessary action. 
                                \nFrom : ".$name.
                                "\nEmail : ".$email.
                                "\nCategory : ".$category.
                                "\nCompany Name : ".$companyName.
                                "\nPhone : ".$phone.
                                "\nMessage : ".str_replace('\\r\\n', "\r\n", $message).
                                "\nFor approval Please click on below link - \nhttp://".$message_approve_link.
                                "\nFor deletion Please click on below link - \nhttp://".$message_delete_link;


                      $toEmail = $this->ADMIN_EMAILS;

                      if($this->sendMail($toEmail,$subject,$html,$text,"")){


                        echo "Message was sent to your email.";

                        
                      
                       }else {

                        echo  "There was some error sending email.";
                       }




                    }else {
                       $status = ERROR;
                      $status =" ERR_LINK_ADD_FAILED";
                        // echo "error  ::". $this->_db->error;

                    }     
      
                 }else {

                   $status = ERROR;
                    echo "error  ::". $this->_db->error;

                 }

    }


    private function forwardMessage(){

      $id = $_GET["id"];
      $replyto  = $text = $name = $companyName = $phone = $message = $category ="";

      $toEmail = $_SESSION["userID"];
      $sql="SELECT * FROM Messages WHERE ID =".$id;

   
      $result = $this->_db->query($sql);
       
        if ($result->num_rows > 0) { 
        
            while($row = $result->fetch_assoc()) {
                $replyto = $row["email"];
                $name = $row["name"];
                $companyName = $row["company_name"];
                $phone = $row["phone"];
                $message = $row["message"];
                $category = $row["category"];
                


            }

        }

        $html = "Hi<br />You forwarded below message from Taitma.<br /><b><i>Name : </i></b>".$name."<br><b><i>Company Name : </i></b>".$companyName.
                "<br/><b><i>Phone : </i></b>".$phone."<br /><b><i>Categoty : </i></b>".$category."<br/>".nl2br(str_replace('\\r\\n', "\r\n", $message));

        $text = "Hi\n You forwarded below message from Taitma.\n Name : ".$name."\n Company Name :".$companyName.
                "\n Phone : ".$phone."\n Categoty : ".$category."\n".str_replace('\\r\\n', "\r\n", $message);

        $subject = MESSAGE_FORWARD_SUBJECT;

         if($this->sendMail($toEmail,$subject,$html,$text, array($replyto))){

          echo "Message was sent to your email.";

          
        
         }else {

          echo  "There was some error sending email.";
         }

         return;


    }






 }

?>