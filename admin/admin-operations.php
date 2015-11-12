 <?php 
      include_once "inc/admin.operations.inc.php";

       $operation="";

      if ($_SERVER['REQUEST_METHOD']==="POST"){

            $operation=$_POST["operation"];

      }else if ($_SERVER['REQUEST_METHOD']==="GET"){

            $operation=$_GET["oper"];
      }


	 // echo  $operation;

	 $oper = new taitmaAdminOperation($db);
	 $status = $oper->processRequest($operation);




 ?>