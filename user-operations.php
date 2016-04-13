 <?php 

       include_once "inc/user.operations.inc.php";

       $operation="";

      if ($_SERVER['REQUEST_METHOD']==="POST"){

            $operation=$_POST["operation"];

      }else if ($_SERVER['REQUEST_METHOD']==="GET"){

            if(isset($_GET["oper"])){
            $operation=$_GET["oper"];}
      }

       //echo "\n\noperation : ee.$operation";

      $oper = new taitmaMembersOperation($db);
      return $status = $oper->processRequest($operation);


     // echo "\n\noperation : ee.$operation";




 ?>