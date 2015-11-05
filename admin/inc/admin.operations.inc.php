<?php 

/**
*Handles admin operation
**/

include_once "common/constants.db.php";
include_once "common/db_connect.php";



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
        }

    }

    /**
    *    
    * For Approving  and updating Member Profile
    *
    **/
     private function approveAndUpdateMembersProfile(){

        echo "inside approveAndUpdateMembersProfile";

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

        $result =  array();

        $email = stripslashes($email);

        if(!empty($_POST["password"])){
                  $password = $_POST["password"];
                  $confirmPassword = $_POST["confirmPassword"];
                    $password = md5(stripslashes($password));

        }




        try {

           // encrypt the password
           
            $stmt = $this->_db->prepare("CALL approveAndUpdateMemberProfile(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@status)");
            $stmt -> bind_param("issssssssssssssssss",
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
                                                        $other_details
                                                        );


                    
                if ($select=$stmt->execute()) {

                        $stmt->bind_result($status);

                            while ($stmt->fetch()){
                              // echo " status : $status";
                              if($status==1){

                                  //update the files 
                                        if(!empty($_FILES["doc1"]['tmp_name']) || !empty($_FILES["doc2"]['tmp_name'])) {
                                          
                                               $iterator = new FilesystemIterator(MEMBER_FILE_UPLOAD_FOLDER);
                                              $filter = new RegexIterator($iterator, "/($serial_no)_*.*$/");
                                              $filelist = array();

                                              if (iterator_count( $filter)>0) {


                                                foreach($filter as $entry) {
                                                  $filelist[] = $entry->getFilename();
                                                   $filename= $entry->getFilename();
                                                   // echo "class filename ::".$filename;
                                                  $filenameArray = explode("_", $filename);
                                                 
                                                  if($filenameArray[1]=="1"){

                                                        if(!empty($_FILES["doc1"]['tmp_name']) ){
                                                         
                                                          $docNew_tmpname=$_FILES['doc1']['tmp_name'];
                                                          // $docNew_size=$_FILES['doc1']['size'];
                                                          $docNew_filename=$serial_no."_1_".$_FILES["doc1"]["name"];

                                                          unlink(MEMBER_FILE_UPLOAD_FOLDER.$filename);
                                                          move_uploaded_file($docNew_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$docNew_filename);
                                                           
                                             
                                                        }

                                                  }else if ($filenameArray[1]=="2"){

                                                          if(!empty($_FILES["doc2"]['tmp_name']) ){
                                                            $doc2New_tmpname=$_FILES['doc2']['tmp_name'];
                                                             // $doc2New_size=$_FILES['doc2']['size'];
                                                            $doc2New_filename=$serial_no."_2_".$_FILES["doc2"]["name"];

                                                          unlink(MEMBER_FILE_UPLOAD_FOLDER.$filename);
                                                          move_uploaded_file($doc2New_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc2New_filename);
                                                           
                                                 
                                                          }

                                                  }



                                                }
                                             

                                              }else {


                                                 if(!empty($_FILES["doc1"]['tmp_name'])) {
                                                
                                                    $doc1_tmpname=$_FILES['doc1']['tmp_name'];
                                                    $doc_1_filename=$serial_no."_1_".$_FILES["doc1"]["name"];
                                                     move_uploaded_file($doc1_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc_1_filename);

                                                 }

                                                  if(!empty($_FILES["doc2"]['tmp_name'])) {

                                                       $doc2_tmpname=$_FILES['doc2']['tmp_name'];
                                                      $doc_2_filename= $serial_no."_2_".$_FILES["doc2"]["name"];
                                                      move_uploaded_file($doc2_tmpname,MEMBER_FILE_UPLOAD_FOLDER.$doc_2_filename);

                                                    }


                                              }

 
                                        

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

            $stmt = $this->_db->prepare("CALL verifyAdminLogin(?,?,@accountStatus)");
            $stmt -> bind_param ("ss",$email,$password);


            
                     if ($select=$stmt->execute()) {

                        $stmt->bind_result($accountStatus);

                            while ($stmt->fetch()){

                                // echo "account Status   : $accountStatus";
                                         
                                if($accountStatus== 0 ){

                                    $result= array(ERROR ,ERR_ACCOUNT_LOGIN_FAILED);

                                }else if ($accountStatus==1){

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
    *
    **/

    private function addUsefulLinks() {

        $title=$_POST["title"];
        $url=$_POST["url"];
        $premium_val=$_POST["premium_val"];
        $enabled=$_POST["enabled"];


         $sql = "INSERT INTO Useful_links(title, url,premium_val,enabled)
                VALUES(?, ?,?,?)";

        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bind_param("ssii", $title, $url, $premium_val,$enabled);
            $stmt->execute();
            $stmt->close();


            $userID = $this->_db->insert_id;

        }

        // return;
    	 return  "<p>Successfully added new links - $title - $url - $premium_val - $enabled with id -$userID</p>";;
    }


    private function editShowUsefulLinks(){

         // echo "inside editUsefulLinks";

        $id= intval($_GET["id"]);

        $sql = "SELECT * FROM Useful_links WHERE id=$id";

        $result = $this->_db->query($sql);


            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {
                         return $row;
                }
            }


    }




}

?>