<?php 

/**
*Handles admin operation
**/

include_once "common/constants.db.php";
include_once "common/db_connect.php";
include_once "constants.inc.php";
include_once "../swiftmailer-5/lib/swift_required.php";
require_once "tcpdf/config/tcpdf_config.php";
require_once "tcpdf/tcpdf.php";




class taitmaAdminOperation {

	/**
     * The database object
     *
     * @var object
     */
    private $_db;

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
             $this->_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (mysqli_connect_error()) {
                echo "Error in __construct of taitmaAdminOperation\n";
			  die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
 			}
        }
    }



    public function processRequest($operation){

        if ($operation=="log-in"){
            return $this->login();
        }else if($operation == "approve-member"){
            return $this -> approveAndUpdateMembersProfile();
        }else if($operation === "add-useful-link"){
      		 return $this->addUsefulLinks();
    	}else if ($operation === "edsul"){
            return $this->editShowUsefulLinks();
        }else if ($operation === "edul"){
            return $this->updateUsefulLinks();
        }elseif ($operation=="valMemberNo") {
            return $this->validateMembershipNumber();
        }elseif ($operation=="add-news-events") {
            return $this->addUpdateNewsAndEvents();
        }else if ($operation=="emailExists"){
           return $this-> validateEmail();
        }else if($operation=="register-user"){
          // echo "registerUserByAdmin";
         return $this->registerUserByAdmin();
        }else if ($operation == "delNE") {
          return $this -> deleteNewsAndNotice();  
        }else if ($operation == "add-banners"){
          return $this -> addUpdateBanners();
        }else if ($operation == "edit-profile"){
            return $this -> updateProfile();
        }elseif ($operation == "changeAccount") {
            return $this -> updateUserStatus();
        }elseif ($operation == "addPaymentDetails") {
             return $this -> addPaymentDetails();
        }elseif ($operation == 'updateMessage') {
            return $this -> updateMessageStatus();
        }elseif ($operation == 'verMes') {
          return $this -> approveMessage();
        }elseif ($operation == "delMes") {
           return $this -> deleteMessage();
        }elseif ($operation == "testBill") {
            return $this ->testBill();
          }elseif ($operation == "rejectMembershipRequest") {
            return $this -> rejectMembershipRequest();
          }

    }

    /**
    *    
    * For Approving  and updating Member Profile
    *
    **/
     private function approveAndUpdateMembersProfile(){

//         echo "inside approveAndUpdateMembersProfile";

        $result =  array();
        $password = "";
        $confirmPassword = "";
       $membeship_number = null;
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

    	$memebershipNoOld= $_POST["membershipNumberOld"];

          if( $member_type != "Regular"){
           $membeship_number = $_POST["membershipNumber"];
          }
         $reminder = intval($_POST["reminder"]);

        $result =  array();

        $email = stripslashes($email);

        if(!empty($_POST["password"])){
                  $password = $_POST["password"];
                  $confirmPassword = $_POST["confirmPassword"];
                    $password = md5(stripslashes($password));

        }

        try {

            if($membeship_number==null OR trim($membeship_number)==""){
               // echo "without membershipNumber";
            $stmt = $this->_db->prepare("CALL approveAndUpdateMemberProfile(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@status)");

            }else{
               // echo "with membershipNumber".$membeship_number;
            $stmt = $this->_db->prepare("CALL updateMemberProfileWithMembershipNo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@status)");

            }


            $stmt -> bind_param("issssssssssssssssssi",
                                                      $serial_no,
                                                      $membeship_number,
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
                                                        $other_details,
                                                        $reminder
                                                        );


                    
                if ($select=$stmt->execute()) {

                        $stmt->bind_result($status);

                            while ($stmt->fetch()){
                              // echo " status : $status";
                              if($status==1){

                                  //update the files 
  
                                          
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

                                            // echo "updating doc 1";
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


                                     if(strcasecmp($membeship_number, $memebershipNoOld)!=0){

                                         $subject = MEMBERSHIP_NUMBER_CHANGED_SUBJECT;
                                         $text = "Dear Taitma Member,\nThis is to inform you that your membership is changed.\nYour new Membership number is -".$membeship_number."\nFrom \nTaitma";
                                         $html = "Dear Taitma Member,<br/> This is to inform you that your membership is changed.
                                                Your new Membership number is -<b><i>".$membeship_number."</i></b>.<br/>-Taitma";

                                       $this->sendMail($email,$subject,$html,$text);
                                     }

                                  $result = array(SUCCESS ,MSG_ACCOUNT_EDIT_PROFILE_SUCCESS);
                              }else {
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



    private function registerUserByAdmin() {

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
        $doc_1_size=0;
        $doc_1_filename=NULL;
        $doc_2_filename=NULL;
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

            $stmt = $this->_db->prepare("CALL RegisterNewMemeberFromAdmin(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@serialNumber)");
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
                                 $verificationLink = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/taitma/verifyAccount.php?oper=ver&ver=$verCode&em=$serialNumber";

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


                                        // $this->sendVerificationEmail($email,$verificationLink);

                                // $returnMessage1 = MSG_ACCOUNT_REGISTRATION_SUCCESS."\n User created with verfication  link : $verificationLink ";

                                $result =  array(SUCCESS ,MSG_ACCOUNT_REGISTRATION_BYADMIN_SUCCESS);

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



    /**
*   function login
*   Called when a user logs in.
*
*
**/

    private function login() {

        $email = $_POST["email"];
        $password = $_POST["pwd"];  
        // $result = "";


        // echo "email : $email | password :  $password.";
        $password = md5(stripslashes($password));

        // $sql = "SELECT email FROM Members_Profile WHERE email=? and password =?";


        try {

            $stmt = $this->_db->prepare("CALL verifyAdminLogin(?,?,@accountStatus,@memberType,@serialNo)");
            $stmt -> bind_param ("ss",$email,$password);


            
                     if ($select=$stmt->execute()) {

                        $stmt->bind_result($accountStatus,$memberType,$serialNo);

                            while ($stmt->fetch()){

                                // echo "account Status   : $accountStatus";
                                         
                                if($accountStatus== 0 ){

                                    $result= array(ERROR ,ERR_ACCOUNT_ADMIN_LOGIN_FAILED);

                                }else if ($accountStatus == -1 ){

                                  $result= array(ERROR ,ERR_ACCOUNT_LOGIN_FAILED);


                                }else if ($accountStatus==1){

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



    /**
    *
    **/

    private function addUsefulLinks() {

        $status = "";
        $title=stripslashes($_POST["title"]);
        $urls=$_POST["urls"];
        $premium_val=stripslashes($_POST["premium_val"]);
        $enabled=stripslashes($_POST["enabled"]);

        $urlsCount = count($urls);
        $urlsConcatinated = "";
        for ($i=0; $i < $urlsCount; $i++) { 
           $urlsConcatinated =$urlsConcatinated.stripslashes($urls[$i]);
           if($i<($urlsCount-1)){
              $urlsConcatinated=$urlsConcatinated."|";
           }
         } 
         // echo "$urlsConcatinated";
         if(strlen($title) > 0 &&
            strlen($urlsConcatinated)>0 &&
            strlen($premium_val) > 0 &&
            strlen($enabled)>0) {

              
              $sql = "INSERT INTO Useful_links(title, url,premium_val,enabled)
                VALUES(?, ?,?,?)";

                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bind_param("ssii", $title, $urlsConcatinated, $premium_val,$enabled);
                   
                    if($stmt->execute()){
                      $status = MSG_LINK_ADD_SUCCESS;
                      // $userID = $this->_db->insert_id;

                    }else {
                      $status = ERR_LINK_ADD_FAILED;
                    }              
                }else {
                      $status = ERR_LINK_ADD_FAILED;

                }
                 $stmt->close();


         }else {
              
              $status = ERR_LINK_ADD_FAILED;

         }


    	 // return  "<p>Successfully added new links - $title - $urlsConcatinated - $premium_val - $enabled with id -$userID</p>";;
        return $status;

    }


    private function editShowUsefulLinks(){

        $id= intval($_GET["id"]);
        $sql = "SELECT * FROM Useful_links WHERE id=$id";
        $result = $this->_db->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                         return $row;
                }
            }
    }

    private function updateUsefulLinks(){

         $status="";

         if ($_SERVER['REQUEST_METHOD']==="POST"){
               
                $action= $_POST["action"];


                    $id= intval($_POST["id"]);
                    $title = $_POST["title"];
                    $urls=$_POST["urls"];
                    $urlsCount = count($urls);           
                    $urlsConcatinated=str_replace(",", "|", $urls[0]);           
                    $premium_val = intval($_POST["premium_val"]);
                    $enabled = intval($_POST["enabled"]);


                if($action==ACTION_ADD ){

                  // $status = $this ->addUsefulLinks();

                            $sql = "INSERT INTO Useful_links(title, url,premium_val,enabled)
                        VALUES(?, ?,?,?)";

                        if($stmt = $this->_db->prepare($sql)) {
                            $stmt->bind_param("ssii", $title, $urlsConcatinated, $premium_val,$enabled);
                           
                            if($stmt->execute()){
                              $status = MSG_LINK_ADD_SUCCESS;
                              // $userID = $this->_db->insert_id;

                            }else {
                              $status = ERR_LINK_ADD_FAILED;
                            }              
                        }else {
                              $status = ERR_LINK_ADD_FAILED;

                        }
                         $stmt->close();


                }else    if ($action==ACTION_UPDATE) {       

                    // $id= intval($_POST["id"]);
                    // $title = $_POST["title"];
                    // $urls=$_POST["urls"];
                    // $urlsCount = count($urls);           
                    // $urlsConcatinated=str_replace(",", "|", $urls[0]);           
                    // $premium_val = intval($_POST["premium_val"]);
                    // $enabled = intval($_POST["enabled"]);

                    $sql = "UPDATE Useful_links set title=?, url=?,premium_val=?,enabled=? where id=?";

                    if($stmt = $this->_db->prepare($sql)) {
                        $stmt->bind_param("ssiii", $title, $urlsConcatinated, $premium_val,$enabled,$id);
                        
                        if($stmt->execute()){
                               $status = MSG_LINK_UPDATE_SUCCESS;
                        }else {
                              $status = ERR_LINK_UPDATE_FAILED;
                        }
              
                    }else {
                          $status = ERR_LINK_UPDATE_FAILED;
                    }
                        $stmt->close();
                    }

              }else if ($_SERVER['REQUEST_METHOD']==="GET"){

                  $action= $_GET["action"];
                  
                  if ($action==ACTION_DELETE){
          
                    $id= intval($_GET["id"]);
                    $sql = "DELETE FROM Useful_links WHERE id=$id";
                    $result = $this->_db->query($sql);
                    $status = MSG_LINK_DELETE_SUCCESS;

                    // echo "<meta http-equiv='refresh' content='0;/taitma/admin/useful-links-modal.php'>";
                    // exit;
                 }
              }
             return $status;
    }



    private function validateMembershipNumber(){

      // echo "validateMembershiipNumber";

      $membershipNo = trim($_GET["MemNo"]);
      $serial_no =intval($_GET["id"]);
      $email = trim($_GET["email"]);
      $result = "";
      $isErrored = false ;

       if($membershipNo==""){
         $result = ERR_MEMBERSHIP_NO_REQUIRED;

       }else {

         if(strlen($membershipNo)>7) {

          if($this->checkIfMembershipNoExists($membershipNo)){
             $result = ERR_MEMBERSHIPNO_EXISTS;
            }

         }else {
                  $result = ERR_MEMBERSHIPNO_LENGTH;

        }


       }

       //if no error update the DB
       if($result == ""){

            $stmt = $this->_db->prepare("CALL approveMember(?,?,@status)");
            $stmt -> bind_param ("is",$serial_no,$membershipNo);
                
                 if ($select=$stmt->execute()) {

                        $stmt->bind_result($status);

                            while ($stmt->fetch()){

                               // echo "account Status   : $status";
                                         
                                if($status== 0 ){

                                   
                                }else if ($status==1){

                                    $subject = MEMBER_APPROVED_SUBJECT;
                                     $text = "Dear Taitma Member,\nWe are glad to inform you that your membership is now approved.\nYour Membership number is -".$membershipNo."\nFrom \nTaitma";
                                     $html = "Dear Taitma Member,<br/> We are glad to inform you that your membership is now approved.
                                            Your Membership number is -<b><i>".$membershipNo."</i></b>.<br/>-Taitma";

                                   $this->sendMail($email,$subject,$html,$text);
                                    


                                }

                            }



                $stmt->close();

            }else {
                echo "something wrong in SQL!\n";
                echo "error  ::". $this->_db->error;
            }


       }

      return $result;
    }


    private function checkIfMembershipNoExists($num) {

      $flag = false;

      $sql = "SELECT serial_no FROM Members_Profile WHERE membership_no=?";

            if($stmt = $this->_db->prepare($sql)) {

               $stmt->bind_param("s", $num);
                
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

                return $flag;

    }

        private function sendMail($email,$subject,$html,$text){
            
            $from = array(EMAILID_FROM =>EMAIL_FROM);
            // $to = array( $email => $email);

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

            if ($recipients = $swift->send($message, $failures))
            {
             // echo 'Message successfully sent!';
            } else {
             // echo "There was an error:\n";
             // print_r($failures);
            }
        return;
    }


    private function addUpdateNewsAndEvents(){

        // echo "inside addNewsAndEvents";
        $status = "";
        $title=stripslashes($_POST["title"]);
        $content=$_POST["content"];
        $premium_val=stripslashes($_POST["premium_val"]);
        $enabled=stripslashes($_POST["enabled"]);
        $id=intval($_POST["id"]);
        $articleType=$_POST["articleType"];

        $eventDate = $_POST["eventDate"];

        $eventDateSQL = null;
        if(!empty($eventDate)){
            $eventDateSQL = date("Y-m-d H:i:s", strtotime($eventDate));
        }



        echo $id;



          if ($id>0) {
            # code...
              $sql = "UPDATE News_And_Notices set title=?, data=?,premium_val=?,enabled=?,article_type=?,event_date=? where id=?";
          
                    if($stmt = $this->_db->prepare($sql)) {
                        $stmt->bind_param("ssiissi", $title, $content, $premium_val,$enabled,$articleType,$eventDateSQL,$id);
                        
                        if($stmt->execute()){
                               $status = MSG_LINK_UPDATE_SUCCESS;
                        }else {
                              $status = ERR_LINK_UPDATE_FAILED;
                        }
              
                    }else {
                          $status = ERR_LINK_UPDATE_FAILED;
                    }
                        $stmt->close();
                

          }else {
              $sql = "INSERT INTO News_And_Notices(title,data,premium_val,enabled,article_type,event_date)
                VALUES(?, ?,?,?,?,?)";

                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bind_param("ssiiss", $title, $content, $premium_val,$enabled,$articleType,$eventDateSQL);
                   
                    if($stmt->execute()){
                      $status = MSG_LINK_ADD_SUCCESS;
                       $userID = $this->_db->insert_id;

                    }else {
                      $status = ERR_LINK_ADD_FAILED;
                       // echo "error  ::". $this->_db->error;

                    }              
                }else {                  


                       // echo "error  ::". $this->_db->error;
                      $status = ERR_LINK_ADD_FAILED;

                }
                $stmt->close();

          }

            
       


        return $status;


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


    private function deleteNewsAndNotice(){

          $status ="";
          $action= $_GET["action"];

            if ($action==ACTION_DELETE_NEWS){
          
                    $id= intval($_GET["id"]);
                    $sql = "DELETE FROM News_And_Notices WHERE id=$id";
                    $result = $this->_db->query($sql);
                    $status = MSG_LINK_DELETE_SUCCESS;

                    // echo "<meta http-equiv='refresh' content='0;/taitma/admin/news-events.php'>";
                    // exit;
            }else if($action == ACTION_DELETE_BANNER){
                    $id= intval($_GET["id"]);
                    $sql = "DELETE FROM Banners WHERE id=$id";
                    $result = $this->_db->query($sql);
                    $status = MSG_LINK_DELETE_SUCCESS;

            }


          return $status;


    }


    private function addUpdateBanners(){

      $banners = $_POST["banners"];

      $id=intval($_POST["ID"]);

  
          if ($id>0) {
            # code...
              $order = $banners[0]['order'];
              // $image_name = $banners[0]['name'];
               $company =  $banners[0]['company'];
                $link = $banners[0]['link'];
                $enable = $banners[0]['enable'];



              $sql = "UPDATE Banners set Image_order=?,company_name=?,link=?,enabled=? where id=?";
          
                    if($stmt = $this->_db->prepare($sql)) {
                        $stmt->bind_param("issii", $order, $company,$link,$enable,$id);
                        
                        if($stmt->execute()){
                               $status = MSG_LINK_UPDATE_SUCCESS;
                        }else {
                              $status = ERR_LINK_UPDATE_FAILED;
                        }
              
                    }else {
                          $status = ERR_LINK_UPDATE_FAILED;
                    }
                        $stmt->close();
                

          }else {
              $sql = "INSERT INTO Banners(Image_order,Image_name,company_name,link,enabled)
                VALUES(?, ?,?,?,?)";

                if($stmt = $this->_db->prepare($sql)) {

                  foreach ($banners as $key => $banner) {
                    # code...
                      $order = $banner['order'];
                      $name = $_FILES["banners"]["name"][$key]['image'];
                      $company =$banner['company'];
                      $link= $banner['link'];
                      $enable=$banner['enable'];
                      $stmt->bind_param("isssi", $order,$name, $company,$link,$enable);
                      $stmt->execute();

                      move_uploaded_file($_FILES["banners"]["tmp_name"][$key]['image'], BANNER_FOLDER.$name);
                  }


                    
                   
                    // if($stmt->execute()){
                    //   $status = MSG_LINK_ADD_SUCCESS;
                    //    $userID = $this->_db->insert_id;

                    // }else {
                    //   $status = ERR_LINK_ADD_FAILED;
                    //    // echo "error  ::". $this->_db->error;

                    // }              
                }else {                  


                        echo "error  ::". $this->_db->error;
                      $status = ERR_LINK_ADD_FAILED;

                }
                $stmt->close();

          }

            
       


        // return $status;

          return;

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
          echo "Setting new password";
                  $password = $_POST["password"];
                  $confirmPassword = $_POST["confirmPassword"];
                  $password = md5(stripslashes($password));
                 echo $password; 

        }

        echo "$other_details";


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
                               echo " status : $status";
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

                                            // echo "updating doc 1";
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

                                                echo "updating doc 2";

                                                 unlink(MEMBER_FILE_UPLOAD_FOLDER.$oldFile2);
                                                 move_uploaded_file($doc2New_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc2New_filename);
                                                   
                                          }else {

                                                  echo "inside class doc 2";
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


    private function updateUserStatus(){

      $status = "";
      $accountStatus = $_POST["status"];
      $serialNumber  = $_POST["serialNo"];
      $disabledDesc = "";
      $newStatus = 1;
      if(!$accountStatus){
          $disabledDesc = $_POST["disableDesc"];
      }


      if(intval($accountStatus)){
        $newStatus = 0;
      }
      
      $disableDate =date("Y-m-d H:i:s");
      $sql = "UPDATE Members_Profile SET disable = ?,disabled_desc=?, disabled_date=? WHERE serial_no = ?";


           if($stmt = $this->_db->prepare($sql)) {
                        $stmt->bind_param("issi", $newStatus, $disabledDesc,$disableDate,$serialNumber);
                        
                        if($stmt->execute()){
                               // $status = MSG_LINK_UPDATE_SUCCESS;
                        }else {
                              $status = ERR_LINK_UPDATE_FAILED;
                        }
              
                    }else {
                          $status = ERR_LINK_UPDATE_FAILED;
                    }
            
            $stmt->close();


            return $status;
            
      

    }

    /**
    * This method insert the payment details in payment_details table, 
    * upgrades the membership and 
    * payment id in Members_Profile.
    * Create the bill in pdf format and Send it to the members.
    * 
    **/


    private function addPaymentDetails(){

      $serialNo       = intval($_POST["serialNo"]);
      $paymentDate    = $_POST["paymentDate"];
      $memStartDate   = $_POST["membershipStartDate"];
      $memExpiryDate  = $_POST["membershipEndDate"];
      $paymentMode    = $_POST["paymentMode"];
      $amount         = $_POST["amount"];
      $paymentNumber  = $_POST["paymentNumber"];
      $paymentAgainst = $_POST["paymentAgainst"];
      $otherDetails   = $_POST["otherDetails"];
      $memberType     = trim($_POST["memberType"]);
      $status = "";
      $email = "";
      $address = "";
      $companyName = "";

      $billNumber = $_POST["billNumber"];

      $tax1 = floatval($_POST["tax1"]);
      $tax2 = floatval($_POST["tax2"]);


      if(strcasecmp($memberType,"Regular")==0){
        $memberTypeSQL = MEMBERSHIP_TYPE_REGULAR;
      }else if(strcasecmp($memberType,"Premium Yearly")==0){
        $memberTypeSQL = MEMBERSHIP_TYPE_YEARLY;
      }else if(strcasecmp($memberType,"Premium Lifetime")==0){
        $memberTypeSQL = MEMBERSHIP_TYPE_LIFETIME;
      }

      $paymentDateSQL = date("Y-m-d H:i:s", strtotime($paymentDate));
      $memStartDateSQL = date("Y-m-d H:i:s", strtotime($memStartDate));
      $memExpiryDateSQL = date("Y-m-d H:i:s", strtotime($memExpiryDate));

      $transId = md5(uniqid());

      $stmt = $this->_db->prepare("CALL addPaymentDetails(?,?,?,?,?,?,?,?,?,?,?,?,@out_payment_id)");

      $stmt -> bind_param("iissssdsssss",$serialNo,
                                        $memberTypeSQL,
                                        $paymentDateSQL,
                                        $memStartDateSQL,
                                        $memExpiryDateSQL,
                                        $paymentMode,
                                        $amount,
                                        $billNumber,
                                        $paymentNumber,
                                        $transId,
                                        $paymentAgainst,
                                        $otherDetails);

               if ($select=$stmt->execute()) {

                           do {

                              if (!$stmt->bind_result($out_payment_id)) {
                                  echo "Bind failed: (" . $stmt->errno . ") " . $stmt->error;
                              }
                           
                              while ($stmt->fetch()) {
                                  // echo "id = $out_payment_id\n";
                              }
                           } while ($this->_db->more_results() && $this->_db->next_result());

                     }
 
                  if($out_payment_id>0){
                                $sql = "SELECT * FROM Members_Profile WHERE serial_no=$serialNo";    
                                  if($result = $this->_db->query($sql)){

                                         while ($row = $result->fetch_assoc()) {
                                                   $email =  $row["email"];
                                                   $companyName=$row["company_name"];
                                                   $address = $row["address_1"].','.$row["city"].','.$row["pincode"];
                                         }

                                     }else {
                                       die("Some error has occured : " .$this->_db->error);

                                     }                                     
                                    // echo "email is ".$address;     
                                   //create the bill   
                                   $attach = $this-> createBill($serialNo,$companyName,$address,$amount,$tax1,$tax2,$paymentDate,$billNumber);

                                  //send a mail to the user with bill attachemnent

                                     if(!empty($email)){
                                        $subject = EMAIL_PAYMENT_RECEIVED_SUBJECT;
                                        $text = "Dear Taitma Member,\nWe are glad to inform you that your payment of is received.
                                                    Please find the invoive attached.
                                                    \nYour Membership type is -".$memberType. ". And its valid upto ".$paymentDate."\n\nFrom \nTaitma";
                                        $html = "Dear Taitma Member,<br/> We are glad to inform you that your payment is received. Please find the invoive attached.
                                              Your Membership type is -<b><i>".$memberType."</i></b>.And its valid upto <b><i>".$paymentDate."</i></b>.<br/>-Taitma";

                                        $this->sendMailWithAttachment($email,$subject,$html,$text,$_SERVER['DOCUMENT_ROOT'].$attach);
                                      
                                     }

                    }
        $stmt->close();
        return $status;


      }




      private function updateMessageStatus(){

        $messageStatus = $_POST["status"];
        $messageID  = $_POST["messageID"];
        $newStatus = 1;
        // echo "updateMessageStatus";
       
        if(intval($messageStatus)){
          $newStatus = 0;
        }

              $sql = "UPDATE Messages SET disable = ? WHERE ID = ?";

              if($stmt = $this->_db->prepare($sql)) {
                $stmt->bind_param("ii", $newStatus, $messageID);
                        
                        if($stmt->execute()){
                               // $status = MSG_LINK_UPDATE_SUCCESS;
                        }

              }

      return;

      }


      private function approveMessage(){

        $id = $_GET["id"];
        $verificationCode = $_GET["ver"];
        $enable = intval($_GET["ena"]);
        $emails = array();
        $name = $emailFrom = $category = $companyName = $phone = $message = "";


         $sql = "UPDATE Messages SET disable = ? WHERE verification_code=? AND ID = ?";

              if($stmt = $this->_db->prepare($sql)) {
                $stmt->bind_param("isi", $enable,$verificationCode, $id);
                        
                        if($stmt->execute()){
                               // $status = MSG_LINK_UPDATE_SUCCESS;
                          echo "<div class='center'>The message is approved.</div>";


//                          do {
                           
                              while ($stmt->fetch()) {
                                  
                              }
//                            } while ($stmt->more_results() && $stmt->next_result());


                            //get the emails of all the members  who opted for receiving messages 
                              $rows = $this->_db->query('SELECT email FROM Members_Profile where receive_message=1');

                                // loop over the rows, outputting them
                               
                               if($rows ){
                                  do {
                                 
                                  while ($row = $rows->fetch_assoc()) {
                                    $email =  $row["email"];
                                    // $emails = $email;
                                    array_push($emails,$email);

                                  } 
                                } while ($this->_db->more_results() && $this->_db->next_result());

                                   $rows->free();

                               }
                                else {
                                       die("Some error has occured : " .$this->_db->error);

                              } 
                               
//                           print_r($emails);

                          //Get Message Details 
                          $result = $this->_db->query("SELECT *  FROM Messages WHERE ID = $id;");
                

                          if ($result->num_rows > 0) { 

                            while($row = $result->fetch_assoc()) {

                                $name = $row["name"];
                                $emailFrom = $row["email"];
                                $category = $row["category"];
                                $companyName = $row["company_name"];
                                $phone = $row["phone"];
                                $message = $row["message"];

                            }
                          }


                          $subject = NEW_MESSAGE_SUBJECT;

                           $html = "<p>Hi,<br/>A new message has been added as below. <br> <b>
                                      <i>From: </i></b>".$name." 
                                      <br/><b><i>Email: </i></b>".$emailFrom."
                                      <br/><b><i>Categoty: </i></b>".$category."
                                      <br/><b><i>Company Name:</i></b> ".$companyName."
                                      <br/><b><i>Phone: </i></b>".$phone."
                                      <br/><b><i>Message: </i></b>".nl2br(str_replace('\\r\\n', "\r\n", $message))."<br/></p>";


                            $text = "Hi,\nA new message has been added as below. Please take the neccessary action. 
                                      \nFrom : ".$name.
                                      "\nEmail : ".$emailFrom.
                                      "\nCategory : ".$category.
                                      "\nCompany Name : ".$companyName.
                                      "\nPhone : ".$phone.
                                      "\nMessage : ".str_replace('\\r\\n', "\r\n", $message);


                        

                            if($this->sendMail($emails,$subject,$html,$text,"")){

//                                 echo "<div class='center'>Message was sent.</div>";                        
                          
                           }else {

//                             echo  "<div class='center'>There was some error sending message.</div>";
                           }



                        }

              }

      return;


      }

      private function deleteMessage(){

        $id = $_GET["id"];

        $sql = "DELETE FROM Messages WHERE id=".$id;
        $result = $this->_db->query($sql);
        $status = MSG_LINK_DELETE_SUCCESS;

        echo "<div class='center'>The message is deleted.</div>";
        return;
      }

      private function createBill($serialNo,$companyName,$companyAddress ,$amount,$tax1Val,$tax2Val,$paymentDate,$billNumber){

        $serialNo;
        $tax1 = $tax2 =0 ;
        $SrNo = 1 ;

        //Add the taxes
         $amount = intval($amount);

         if($tax1Val>0){
          $tax1 = $amount*($tax1Val/100);
         }

         if($tax2Val>0){
          $tax2 = $amount*($tax2Val/100);
         }

        $totalBill = $amount+$tax1+$tax2;
        
        //Creating the html for bill 
        // All Tables width are in mm
       
        $html = '<h3 align="center">TAX INVOICE</h3><br /><br />';
 
        $html = $html.'<table border="0" cellpadding="0" cellspacing="5">
            <thead>
             <tr>
              <td width="250" align="left" rowspan="4" ><b>'.INVOICE_NAME.'</b><br />
                                      '.INVOICE_ADDRESS.'<br/>
                                      '.INVOICE_CIN.'<br />         
                                      '.INVOICE_EMAIL.'<br />
              </td>
              <td width="150" align="center" rowspan="4" >TAX INVOICE No. :<b>'.$billNumber.'</b></td>
              <td width="100" align="right" rowspan="4" >Dated :<b>'.$paymentDate.'</b></td>
             </tr><br/>
             <tr>
             </tr>
            </thead>
            <tbody></tbody>
            </table><br /><br /><br />';

         $html = $html.'<table border="0" cellpadding="0" cellspacing="5">
                        <thead>
                         <tr>
                          <td width="40" ><b>Name:<br />Address :</b></td>
                          <td width="210">'.$companyName.'<br />'.$companyAddress.'</td>
                          </tr>                          
                        </table><br /><br />';

         $html =  $html.'<table border="0" cellpadding="0" cellspacing="5">
            <thead>
              <tr>
              <td width="50" align="left"><b>Sr No.</b></td>
              <td width="300"  align="left"><b>Particulars</b></td>
              <td width="150"  align="right"><b>Amount</b></td>
             </tr>
            </thead>
            <tbody>
             <tr>
                 <td width="50" align="left">'.$SrNo.'</td>
                <td width="400"  align="left">Annual subscription</td>
                <td width="50"  align="right">Rs. '.$amount.'</td>
              </tr>';
                    
           if($tax1>0){
               $html =  $html.'<tr>
                    <td width="50" align="left"></td>
                    <td width="400"  align="right">Add: '.INVOICE_TAX_1_NAME.' @ '.$tax1Val.'%    </td>
                    <td width="50"  align="right">Rs. '.$tax1.'</td>
                  </tr>';
              }

          if($tax2>0){
               $html =  $html.'<tr>
                    <td width="50" align="left"></td>
                    <td width="400"  align="right">Add: '.INVOICE_TAX_2_NAME.' @ '.$tax2Val.'%    </td>
                    <td width="50"  align="right">Rs. '.$tax2.'</td>
                  </tr>';
              }

             $html =  $html.'<hr /><tr><td width="50" align="left"></td>
                <td width="400"  align="left">Total    </td>
                <td width="50"  align="right"><b>Rs. '.$totalBill.'</b></td>
             </tr>
        
            </tbody>
          </table><br/ ><br /><br/ ><hr />';
        

          $html =  $html.'<table border="0" cellpadding="0" cellspacing="5">
            <thead>
              <tr>
              <td width="250" align="left"></td>
              <td width="250"  align="right"></td>
             </tr>
            </thead>
            <tbody>
             <tr>
                 <td width="250" align="left">Amount Chargable (in words)<br />
                 <b><font size="8">Indian Rupees '.$this->convert_number_to_words($totalBill).' only. </font></b></td>
                 <td width="250"  align="right"> <i>E. & O.E</i> <br />
                 <b>For '.INVOICE_NAME.'</b></td>
              </tr><br />

            <tr>
                 <td width="250" align="left"><span  width="125">Company PAN :</span><span align="right" width="100"><b>'.INVOICE_COMPANY_PAN.'</b></span><br />
                 Service Tax Registration No.:<span align="right"><b>'.INVOICE_SERVICE_TAX_REG.'</b></span></td>
                <td width="250"  align="right"></td>
             </tr><br />
             <tr> 
              <td width="250" align="left">Declaration<br>We declare that the particulars contained in this tax invoice are true and correct.</td>
              <td width="250"  align="right">Authorised Signatory :<br />D S Nanabhoy (Secretary)</td>
             </tr>
            </tbody>
          </table><br/ ><br /><br/ ><br />';
        


          $filename = INVOICE_FOLDER.$serialNo.PDF_EXTENTION;

          ob_start();
            // create new PDF document
              $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetTitle('TAX INVOICE');
            // set default header data
            $pdf->SetHeaderData("", "", INVOICE_NAME, "");
                         


              // set header and footer fonts
               $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
               $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


              // set default monospaced font
              $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

              // set margins
              $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
              $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
              $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

              // set auto page breaks
               $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

              // set font
              $pdf->SetFont('helvetica', 'B', 10);

              // add a page
              $pdf->AddPage();

               // $pdf->Write(0, 'TAX INVOICE', '', 0, 'C', true, 0, false, false, 0);

              $pdf->SetFont('helvetica', '', 8);

            $pdf->writeHTML($html, true, false, true, false, '');

          // $content = $pdf->Output('Bills/doc.pdf','F');

          $pdf->Output($filename , 'F');
            ob_end_clean();

          return $filename;
  
        
      }


          


      private function testBill(){

          // create new PDF document
         
              echo $fileName = $this->createBill(109,"name","address",1000,14.5,5,"10-05-2016","B-123QWE");

      }

      private function convert_number_to_words($number) {
    
              $hyphen      = '-';
              $conjunction = ' and ';
              $separator   = ', ';
              $negative    = 'negative ';
              $decimal     = ' point ';
              $dictionary  = array(
                  0                   => 'zero',
                  1                   => 'one',
                  2                   => 'two',
                  3                   => 'three',
                  4                   => 'four',
                  5                   => 'five',
                  6                   => 'six',
                  7                   => 'seven',
                  8                   => 'eight',
                  9                   => 'nine',
                  10                  => 'ten',
                  11                  => 'eleven',
                  12                  => 'twelve',
                  13                  => 'thirteen',
                  14                  => 'fourteen',
                  15                  => 'fifteen',
                  16                  => 'sixteen',
                  17                  => 'seventeen',
                  18                  => 'eighteen',
                  19                  => 'nineteen',
                  20                  => 'twenty',
                  30                  => 'thirty',
                  40                  => 'fourty',
                  50                  => 'fifty',
                  60                  => 'sixty',
                  70                  => 'seventy',
                  80                  => 'eighty',
                  90                  => 'ninety',
                  100                 => 'hundred',
                  1000                => 'thousand',
                  1000000             => 'million',
                  1000000000          => 'billion',
                  1000000000000       => 'trillion',
                  1000000000000000    => 'quadrillion',
                  1000000000000000000 => 'quintillion'
              );
              
              if (!is_numeric($number)) {
                  return false;
              }
              
              if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                  // overflow
                  trigger_error(
                      'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                      E_USER_WARNING
                  );
                  return false;
              }

              if ($number < 0) {
                  return $negative .  $this->convert_number_to_words(abs($number));
              }
              
              $string = $fraction = null;
              
              if (strpos($number, '.') !== false) {
                  list($number, $fraction) = explode('.', $number);
              }
              
              switch (true) {
                  case $number < 21:
                      $string = $dictionary[$number];
                      break;
                  case $number < 100:
                      $tens   = ((int) ($number / 10)) * 10;
                      $units  = $number % 10;
                      $string = $dictionary[$tens];
                      if ($units) {
                          $string .= $hyphen . $dictionary[$units];
                      }
                      break;
                  case $number < 1000:
                      $hundreds  = $number / 100;
                      $remainder = $number % 100;
                      $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                      if ($remainder) {
                          $string .= $conjunction . $this->convert_number_to_words($remainder);
                      }
                      break;
                  default:
                      $baseUnit = pow(1000, floor(log($number, 1000)));
                      $numBaseUnits = (int) ($number / $baseUnit);
                      $remainder = $number % $baseUnit;
                      $string =  $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                      if ($remainder) {
                          $string .= $remainder < 100 ? $conjunction : $separator;
                          $string .=  $this->convert_number_to_words($remainder);
                      }
                      break;
              }
              
              if (null !== $fraction && is_numeric($fraction)) {
                  $string .= $decimal;
                  $words = array();
                  foreach (str_split((string) $fraction) as $number) {
                      $words[] = $dictionary[$number];
                  }
                  $string .= implode(' ', $words);
              }
              
              return $string;
          }


          private function sendMailWithAttachment($email,$subject,$html,$text,$attachment){
            
            $from = array(EMAILID_FROM =>EMAIL_FROM);
            $to = array( $email => $email);

            
            $transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT);
            $transport->setUsername(SMTP_USER);
            $transport->setPassword(SMTP_PASSWORD);
            $swift = Swift_Mailer::newInstance($transport);

            $message = new Swift_Message($subject);
            $message->setFrom($from);
            $message->setBody($html, 'text/html');
            $message->setTo($to);
            $message->addPart($text, 'text/plain');

            $message->attach(Swift_Attachment::fromPath($attachment));

            if ($recipients = $swift->send($message, $failures))
            {
               // echo 'Message successfully sent!';
            } else {
                // echo "There was an error:\n";
              // print_r($failures);
            }
        return;
     }

     private function rejectMembershipRequest(){

      $serialNo       = intval($_POST["serialNo"]);
      $rejectReason   = $_POST["rejectDesc"];
      $email = "";


      $sql = "UPDATE Members_Profile SET membership_requested=0 WHERE serial_no=".$serialNo;  

      if($result = $this->_db->query($sql)){
  

           $sql = "SELECT * FROM Members_Profile WHERE serial_no=$serialNo";    
                
              if($result = $this->_db->query($sql)){

                                         while ($row = $result->fetch_assoc()) {
                                                   $email =  $row["email"];
                                                   // $companyName=$row["company_name"];
                                                   // $address = $row["address_1"].','.$row["city"].','.$row["pincode"];
                                         }

                                     }else {
                                       die("Some error has occured : " .$this->_db->error);

                                     }                                     
                                    // echo "email is ".$address;     
                                   //create the bill   
                                   // $attach = $this-> createBill($serialNo,$companyName,$address,$amount,$tax1,$tax2,$paymentDate,$billNumber);

                                  //send a mail to the user stating the reason

                                     if(!empty($email)){
                                        $subject = EMAIL_MEMBERSHIP_REJECTED_SUBJECT;
                                        $text = "Dear Taitma Member,\nThis is to inform you that your request for membership could not be completed due to below reason -
                                                    \n".$rejectReason. "\n\nFrom \nTaitma";
                                        $html = "Dear Taitma Member,<br/> This is to inform you that your request for membership could not be completed due to below reason -
                                             <br/><p><i>".$rejectReason."</p></i><br/>-Taitma";

                                        $this->sendMail($email,$subject,$html,$text);
                                      
                                     }           



        }

        return;
     }

  }
  