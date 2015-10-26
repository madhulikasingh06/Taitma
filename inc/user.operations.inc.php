<?php 

/**
*Handles admin operation
**/

 include_once "common/constants.db.php";
 include_once "common/db_connect.php";
 include_once "constants.inc.php";



class taitmaMembersOperation {

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
            return $this->login();
        }else if ($operation=="log-in"){
            return $this->logOut();
        }else if ($operation=="emailExists"){
            // return $this->checkIfEmailExistsOld();
           return $this-> validateEmail();
        }else if ($operation == "ver"){
            return $this -> verfityAccount();
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
        if(!empty($_FILES["doc1"]['tmp_name'])) {
                   $doc1_tmpname=$_FILES['doc1']['tmp_name'];
                  $doc_1 = file_get_contents($doc1_tmpname);
         
        }
        if(!empty($_FILES["doc2"]['tmp_name'])) {
                   $doc2_tmpname=$_FILES['doc2']['tmp_name'];
                  $doc_2 = file_get_contents($doc2_tmpname);
         
        }

 
        $serial_number ="";
        $verCode= sha1(time());       
        $returnMessage = array();

        $email = stripslashes($email);
        //$email = mysql_real_escape_string($email);
        //$password = mysql_real_escape_string($password);

        try {

           // encrypt the password
            $password = md5(stripslashes($password));

            $stmt = $this->_db->prepare("CALL RegisterNewMemeber(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@serialNumber)");
            $stmt -> bind_param("ssssssississsssisbbs",$password, 
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
                                                        $doc_1,
                                                        $doc_2, 
                                                        $verCode);


                    
                if ($select=$stmt->execute()) {

                        $stmt->bind_result($serialNumber);

                            while ($stmt->fetch()){

                                // echo "user created with  id : $serialNumber";

                               //create the verification link link


                                // echo $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
//                                  $verificationLink = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/verifyAccount.php?oper=ver&ver=$verCode&em=$serialNumber";
                                 
                                $verificationLink = $_SERVER["SERVER_NAME"]."/verifyAccount.php?oper=ver&ver=$verCode&em=$serialNumber";


                                // echo "Verification link is :: ".$verificationLink;

                                 //send the email 


                                $returnMessage1 = MSG_ACCOUNT_REGISTRATION_SUCCESS."\n User created with verfication  link : $verificationLink ";
                                // $returnMessage[] = MSG_ACCOUNT_REGISTRATION_SUCCESS;

                                $result =  array(SUCCESS ,$returnMessage1);

                            }




                }else {
                         echo "error  ::". $this->_db->error;
                         $returnMessage[] ="Error occurred : ". $this->_db->error;                         
                         $result= array(ERROR ,ERR_ACCOUNT_REGISTRATION_FAILED);

                }



        } catch (Exception $pe) {
            echo "in registerUser method error msg: ".$pe->getMessage();
            die("Error occurred:" . $pe->getMessage());
            $result =  array(ERROR ,ERR_ACCOUNT_REGISTRATION_FAILED);
        }

        return  $result;
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


//         echo "account verified verification_code : $verification_code and serialNumber : $serialNumber";

        try {
            
            $stmt = $this->_db->prepare("CALL verifyMemberAccount(?,?,@verified)");
            $stmt -> bind_param ("ss",$serialNumber,$verification_code);

             if ($select=$stmt->execute()) {

                        $stmt->bind_result($verified);

                            while ($stmt->fetch()){

                                echo "verified status   : $verified";

                                
                                
                                echo getenv('HTTP_HOST');
                                                                echo $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

                                                                echo "Doc root ::". $_SERVER["DOCUMENT_ROOT"];

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
        // $result = "";


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

                                }else if ($accountStatus==0) {
                                    
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






 }

?>