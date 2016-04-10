<?php include_once "common/header.php";
include_once "inc/constants.inc.php" ;

// $ADMIN_EMAILS  = array('vipul@cleari.in','madhulikasingh06@gmail.com');
$ADMIN_EMAILS  = array('madhulikasingh06@gmail.com');

?>

<?php
	
	ob_start();

	$dateStr = date("Y-m-d H:i:s");
	$currentDate = date_create();

	echo ("**************************************");
	print_r ($dateStr);
	echo ("**************************************\n");  ?>
	
	
	
	<?
	// echo "currentDate".$currentDate;
	
	 try {

		$sql = "select * from Members_Profile where member_type != 0";
		$result = $db -> query($sql);

			 $result->num_rows; 
				 if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {

							echo "\n";
							$expiryDate = date_create($row["membership_expiry_date"]);
							$diff = date_diff($currentDate,$expiryDate);

							 $daysToExpiry = $diff->format("%R%a");
							 
							 echo "Days to expiry :: ".$daysToExpiry."    ";

							 echo "email :: ".$row["email"];


							 // if($daysToExpiry<= (+30) AND $daysToExpiry>= (0)){
							
							 if($daysToExpiry>= (0) AND ($daysToExpiry == (FIRST_REMINDER_DAY) OR $daysToExpiry == (SECOND_REMINDER_DAY) OR $daysToExpiry == (THIRD_REMINDER_DAY) )){ 	

							 	if($row["reminder"]==1){
							 		//send email

							 			$subject = EMAIL_REMINDER_MEMBERSHIP_EXPIRY_SUBJECT;
	                                    $text = "Dear Taitma Member,\nThis is to remind you that your membership will be expiring on ".date_format($expiryDate ,"d/m/Y")." .
	                                              \nPlease renew the memebership before ".date_format($expiryDate ,"d/m/Y")." for continuing the benefits of memebership. \n\nFrom \nTaitma";
	                                        
	                                    $html = "Dear Taitma Member,<br/> This is to remind you that your membership will be expiring on ".date_format($expiryDate ,"d/m/Y").".<br />
	                                             Please renew the memebership <b><i> before ".date_format($expiryDate ,"d/m/Y")."</i></b> for continuing the benefits of memebership.</i></b>.<br/>-Taitma";


							 		    $from = array(EMAILID_FROM =>EMAIL_FROM);
							            $to = array( $row["email"] => $row["email"]);

							            
							            $transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT);
							            $transport->setUsername(SMTP_USER);
							            $transport->setPassword(SMTP_PASSWORD);
							            $swift = Swift_Mailer::newInstance($transport);

							            $message = new Swift_Message($subject);
							            $message->setFrom($from);
							            $message->setBody($html, 'text/html');
							            $message->setTo($to);
							            $message->addPart($text, 'text/plain');

							            $message->setBcc($ADMIN_EMAILS);
							            if ($recipients = $swift->send($message, $failures))
							            {
							              echo 'Message successfully sent!';
							            } else {
							            	 echo "There was an error:\n";
							             	print_r($failures);
							            }
							 		}


							 	?>
							<?php } else if ($daysToExpiry < (0) AND ($daysToExpiry == (FOURTH_REMINDER_DAY) OR  $daysToExpiry == (LAST_REMINDER_DAY) )){

							// else if ($daysToExpiry <= (0) AND $daysToExpiry >= (-15)){


								// echo "else 1:".$row["email"]; 

								if($row["reminder"]==1){
						 		//send email

							 			$subject = EMAIL_REMINDER_MEMBERSHIP_EXPIRY_SUBJECT;
	                                    $text = "Dear Taitma Member,\nThis is to remind you that your membership is expired.
	                                              \nPlease renew the memebership for continuing the benefits of memebership. \n\nFrom \nTaitma";
	                                        
	                                    $html = "Dear Taitma Member,<br/> This is to remind you that your membership is expired.<br />
	                                             Please renew the memebership for continuing the benefits of memebership.<br/>-Taitma";


							 		    $from = array(EMAILID_FROM =>EMAIL_FROM);
							            $to = array( $row["email"] => $row["email"]);

							            
							            $transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT);
							            $transport->setUsername(SMTP_USER);
							            $transport->setPassword(SMTP_PASSWORD);
							            $swift = Swift_Mailer::newInstance($transport);

							            $message = new Swift_Message($subject);
							            $message->setFrom($from);
							            $message->setBody($html, 'text/html');
							            $message->setTo($to);
							            $message->addPart($text, 'text/plain');
							             $message->setBcc($ADMIN_EMAILS);

							            if ($recipients = $swift->send($message, $failures))
							            {
							              echo 'Message successfully sent!';
							            } else {
							            	 echo "There was an error:\n";
							             	print_r($failures);
							            }
							 		}






									?>
							<?php	}else if ($daysToExpiry < (LAST_REMINDER_DAY)){

									$serialNo = $row["serial_no"];
									$regularMember = MEMBERSHIP_TYPE_REGULAR;

									 $sql = "UPDATE Members_Profile SET member_type=? WHERE serial_no = ?";

									 if($stmt = $db->prepare($sql)) {
				                        $stmt->bind_param("ii",$regularMember ,$serialNo);
				                        
				                        if($stmt->execute()){
				                                $status = MSG_LINK_UPDATE_SUCCESS;
				                        }else {
				                               echo "could not execute sql statement.";
				                        }
				              
				                   	 }else {
				                         echo "could not execute sql statement.";
				                   	 }
				            



								 ?>
							<?php }



						}
				}
		}catch (Exception $e) {
        echo 'Inside catch Connection failed: ' . $e->getMessage();
        // exit;
    }


	file_put_contents("script_out/".$dateStr.'_ScriptOut.txt', ob_get_contents());
	// end buffering and displaying page
	ob_end_flush();



?>