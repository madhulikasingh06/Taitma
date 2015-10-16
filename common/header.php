<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TAITMA</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- style-sheet -->
    <link href="style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 
   <script>
  //  $(document).ready(function(){
  
  //    $("#nav-menu").click(function(){
  //     $("#nav-menu").removeClass("nav-menu-style");
  //     $(this).addClass("active");
  //    });
  //  });

   </script>
  </head>
  <body>


 <?php include_once "functions.php";?>
   <div id="container"> <!-- container div start--> 

  <div class="row site-header"> <!--site-header start-->

    <div class="logo">
      <a href="index.php"><img id="logo" src="images/taitma-logo-s.png" height="150"></a></img>

    </div>    
    <div class="logo-text"><a href="index.php">The All India Toy <br>Manufacturers' <br>Association<br>(TAITMA)</a></div>
    
    <div id="nav-menu" class="col-sm-8 nav-menu-style">
       <ul>
            <?php getNavBar();?>
         <!--   <li><a href="index.php">Home</a></li>
          <li><a href="about-us.php">About us</a></li>
          <li><a href="commitee-members.php">Commitee Members</a></li>
          <li><a href="news-events.php">News &amp; Events</a></li>
          <li><a href="useful-links.php">Useful Links</a></li>
          <li><a href="quality-parameters.php">Quality Parameter</a> </li>
          <li><a href="toy-guide.php">Toy Guide</a></li>
  -->
        </ul>
    </div>

  </div><!--site-header end-->

    <div id="body"> <!-- body div start-->



  



