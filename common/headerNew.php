<?php
header( 'Cache-Control: no-store, no-cache, must-revalidate');
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
?>
<?php
//include_once "common/constants.db.php";
include_once "common/db_connect.php";
include_once "inc/user.operations.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TAITMA</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <link rel='stylesheet' href="jquery-ui.css"  type="text/css" media="all">

    <!-- style-sheet -->
    <link href="style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="jquery-ui.js"></script>
  <script src="js/taitma.member.js"></script>
    <script src="js/bootstrap.min.js"></script>
   <script src="js/bootstrap-paginator.js"></script>
   <script src='https://www.google.com/recaptcha/api.js'></script>

  </head>
 
  <body>
 <?php include_once "functions.php";?>

   <div id="container"> <!-- container div start--> 

  <div class="row site-header"> <!--site-header start-->

    <div class="logo">
      <a href="index.php"><img id="logo" src="images/taitma-logo-s.png" height="150"></a></img>

    </div>    
    <div class="logo-text"><a href="index.php">The All India Toy <br>Manufacturers' <br>Association<br>(TAITMA)</a></div>
    
    <div class="nav-menu-right">
      <ul>
        <?php if(isset($_SESSION["loggedIN"])) { ?>
          <li style="color:#EDEBE7;">          <?php if (isset($_SESSION["accountStatus"])) {
              if ($_SESSION["accountStatus"]==1) {?><!-- 
               <span style="color:red;"> <?php echo MSG_ADMIN_APPROVAL_PENDING;?></span> -->
            <?php }
          } 
          ?>Welcome! <?php echo $_SESSION["userID"] ;?></li>
          <li><a href="profile.php">Profile</a></li> 
          <li><a href="logout.php">Logout</a></li>

          <?php } else { ?>
                  <li style="color:#EDEBE7;">Hello! </li>
                <li><a href="register.php">Register</a></li>
         <?php } ?>       
      </ul>
    </div>

 <div id="nav-menu" class="col-sm-8 nav-menu-style">

    <nav class="navbar">
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="about-us.php">About Us</a></li>
      <li><a href="commitee-members.php">Commitee Members</a></li> 
      <li><a href="news-events.php">News &amp; Events</a></li> 
     <li  class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"  href="useful-links.php">Useful Links<span class="caret"></span></a>
         <ul class="dropdown-menu">
          <li><a href="useful-links.php">Useful Links</a></li>
          <li><a href="quality-parameters.php">Quality Parameters</a></li>
          <li><a href="toy-guide.php">Toy Guide</a></li>
        </ul>
     </li> 
      <?php if(isset($_SESSION["memberType"]) && $_SESSION["memberType"]>0 ) {  ?>
          <li><a href="messages.php">Messages</a></li> 
          <li><a href="members.php">Members</a></li>
        <?php  } ?>  
    </ul>
 
</nav>    

  </div>

  </div><!--site-header end-->
<div id="body"> <!-- body div start-->
<?php require_once "recaptchalib.php"; ?>