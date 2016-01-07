<?php 

/**
*Handles admin operation
**/

include_once "common/constants.db.php";
include_once "common/db_connect.php";
include_once "constants.inc.php";
include_once "../swiftmailer-5/lib/swift_required.php";


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
        $membeship_number = $_POST["membershipNumber"];
  
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


                                     if(!($membeship_number==null OR trim($membeship_number)=="")){

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

         if(strlen($membershipNo)>=8) {

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

        echo $id;



          if ($id>0) {
            # code...
              $sql = "UPDATE News_And_Notices set title=?, data=?,premium_val=?,enabled=?,article_type=? where id=?";
          
                    if($stmt = $this->_db->prepare($sql)) {
                        $stmt->bind_param("ssiisi", $title, $content, $premium_val,$enabled,$articleType,$id);
                        
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
              $sql = "INSERT INTO News_And_Notices(title,data,premium_val,enabled,article_type)
                VALUES(?, ?,?,?,?)";

                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bind_param("ssiis", $title, $content, $premium_val,$enabled,$articleType);
                   
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


    private function addPaymentDetails(){

      $serialNo       = $_POST["serialNo"];
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

      $stmt = $this->_db->prepare("CALL addPaymentDetails(?,?,?,?,?,?,?,?,?,?,?,@out_payment_id)");

      $stmt -> bind_param("iissssdssss",$serialNo,
                                        $memberTypeSQL,
                                        $paymentDateSQL,
                                        $memStartDateSQL,
                                        $memExpiryDateSQL,
                                        $paymentMode,
                                        $amount,
                                        $paymentNumber,
                                        $transId,
                                        $paymentAgainst,
                                        $otherDetails);

       if ($select=$stmt->execute()) {

                        $stmt->bind_result($out_payment_id);

                            while ($stmt->fetch()){
                               // echo " status : $out_payment_id";
                                if($out_payment_id>0){
                                  //send a mail to the user incluing payment details


                                      $sql = "SELECT email FROM Members_Profile WHERE serial_no=".$serialNo;

                                      // echo $sql;
                                     if($result = $this->_db->query($sql)){

                                      echo "$result";
                                         while ($obj = $result->fetch_object()) {
                                                   $email =  $obj->email;
                                                   echo $email;
                                         }

                                     }

                                     if(!empty($email)){
                                        $subject = EMAIL_PAYMENT_RECEIVED_SUBJECT;
                                        $text = "Dear Taitma Member,\nWe are glad to inform you that your payment of Rs.".$amount." is received.
                                                    \nYour Membership type is -".$memberType. ". And its valid upto ".$paymentDate."\n\nFrom \nTaitma";
                                        $html = "Dear Taitma Member,<br/> We are glad to inform you that your payment of Rs.".$amount." is received.
                                              Your Membership type is -<b><i>".$memberType."</i></b>.And its valid upto <b><i>".$paymentDate."</i></b>.<br/>-Taitma";

                                        $this->sendMail($email,$subject,$html,$text);
                                      
                                     }

                              }
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
  


  }

?>