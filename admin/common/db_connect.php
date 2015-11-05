<?php 
    include_once "constants.db.php";

    // Start a PHP session
    session_start();

  // Set the error reporting level
    error_reporting(E_ALL);
    ini_set("display_errors", 1);



    // Create a database object
    try {

         $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (mysqli_connect_error()) {
			  die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
 		}

 		// echo 'Connected successfully.';

    } catch (Exception $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

?>