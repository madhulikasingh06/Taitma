<?php header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=MembersForNewsletter.csv'); 
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

include_once "common/db_connect.php";
 				// create a file pointer connected to the output stream
				$output = fopen('php://output', 'w');

				// output the column headings
		fputcsv($output, array('Usernames/Emails','Company Name'));

				// fetch the data

				$rows = $db->query('SELECT email,company_name FROM Members_Profile where recieve_newsletter=1');

				// loop over the rows, outputting them
				while ($row = $rows->fetch_assoc()) fputcsv($output, $row);
?>


