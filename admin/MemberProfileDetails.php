<?php 
$memberSerial = $_GET["id"];
								$result = $db -> query(getUnapprovedMemberDetails.$memberSerial);
								   if ($result->num_rows > 0) {
								   		while($row = $result->fetch_assoc()) {
								   			 $companyName = $row["company_name"];
								   			 echo "company : $companyName";

								   		}

								   }

?>