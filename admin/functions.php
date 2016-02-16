<?php
     
     //declaring page name as global variable
      $pageName;


    function getCurrentPage(){

      return $current=substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
      
    } 
   
    function getNavBar() {

          global $pageName;
          $nav_tabs=array('index.php',
                           'members.php',
                           'commitee-members.php',
                          'news-events.php',
                          'useful-links-modal.php',
                          'quality-parameters.php',
                          'banners.php',
                          'messages.php'); 
    
          $current=getCurrentPage();    
             foreach($nav_tabs as $nav)
             {

                //ASSIGN THE PAGE NAME                  
                $pageName = getPageName($nav);
                  //echo "nav val ::".$nav;

                    if($nav == $current)
                   {
                   // echo "nav val ::".$nav;
                       echo"<li class='active' > <a href='$nav' > $pageName </a></li>";
                   }
                   else
                  {
                       echo"<li> <a href='$nav' >  $pageName  </a></li>";
                  }
             }

    }


    function getInnerNavBar() {

          global $pageName;
          $nav_inner = array('notice-board.php',
                              'contact.php',
                              'register.php');

          $current=getCurrentPage();
         // echo $current;
    
             foreach($nav_inner as $nav)
             {

                //get the page name                 
              $pageName = getPageName($nav);
                 
                    if($nav == $current)
                   {
                       echo"<li class='activeInnerMenu' > <a href='$nav' > $pageName </a></li>";
                   }
                   else
                  {
                       echo"<li> <a href='$nav' >  $pageName  </a></li>";
                  }
             }
    }

    function getPageName($current){
            
            global $pageName;
            if($current=="index.php") {                
                return  $pageName = "Home";
            }elseif ($current=="members.php") {
                  return   $pageName = "Members";
            }elseif ($current=="commitee-members.php") {                 
                  return  $pageName = "Commitee Members";
            }elseif ($current=="news-events.php") {
                  return  $pageName = "News & Events";
            }elseif ($current=="useful-links-modal.php") {
                 return  $pageName = "Useful Links ";            
            }elseif ($current=="quality-parameters.php") {           
                  return  $pageName = "Quality parameters";           
            }elseif ($current=="toy-guide.php") {           
                  return   $pageName = "Toy Guide";
            }elseif ($current=="notice-board.php") {            
                  return   $pageName = "Notice Board";
            }elseif ($current=="contact.php") {              
                  return   $pageName = "Contact";
            }elseif ($current=="register.php") {             
                  return   $pageName = "Register";
            }else if ($current=="profile.php") {
                  return   $pageName = "Profile";
            }else if ($current=="verifyAccount.php") {
                  return   $pageName = "Register";
            }else if ($current=="admin.php") {
               return   $pageName = "Admin";
            }else if ($current =="approve-members.php") {
              return $pageName = "Approve Members";
            }elseif ($current =="add-news-events.php") {
               return $pageName = "Add / Edit Article";
            }else if ($current == "banners.php") {
               return $pageName = "Banners";
            }else if ($current == "add-update-banner.php"){
               return $pageName = "Add / Edit Banners";
            }else if ($current == "messages.php"){
              return $pageName = "Messages";
            }else if ($current == "member-profile-details.php"){
               return $pageName = "Members profile";
            }
    }



   function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }
 
?>