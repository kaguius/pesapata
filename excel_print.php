<?php
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$username = $_SESSION["username"];
	}
	if (!empty($_GET)){
		$file = $_GET['file'];	
		$filter_start_date = $_GET['filter_start_date'];
		$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
		$filter_end_date = $_GET['filter_end_date'];
		$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
		$filter_start_date_1 = $filter_start_date.' 00:00:00';
		$filter_end_date_1 = $filter_end_date.' 23:59:59';
	} 
	
	
	/*******EDIT LINES 3-8*******/
	$DB_Server = "localhost"; //MySQL Server    
	$DB_Username = "root"; //MySQL Username     
	$DB_Password = "kaguius";             //MySQL Password     
	$DB_DBName = "pesapata_direct";         //MySQL Database Name  
	$filename = "excelfilename";         //File Name
	/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
	//create MySQL connection   
	if($file == "expected_payments"){
		$sql = "select loan_application.loan_mobile, loan_sched_type, loan_sched_due_amount, loan_sched_due_date, Loan_Sched_Paid_Amount, Loan_Sched_Pay_Date from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where Loan_Sched_Due_Date between '$filter_start_date' and '$filter_end_date' and loan_sched_paid_amount = '0' order by loan_sched_due_date asc";
	}
	else if($file == "defaulters"){
		$sql = "select loan_application.Loan_mobile, Loan_Sched_Loan_ID, loan_sched_id, Loan_Sched_Type, loan_sched_due_amount, Loan_Sched_Due_Date, Loan_Sched_Paid_Amount from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where Loan_Sched_Due_Date between '$filter_start_date' and '$filter_end_date' and Loan_Sched_Paid_Amount = '0'";
	}
	else if($file == "revenue"){
		$sql = "select loan_rep_date, users.Client_Name, loan_rep_mobile, loan_rep_amount, Loan_Sched_Type from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '3'";
	}
	else if($file == "transactions"){
		$sql = "select loan_rep_date, users.Client_Name, loan_rep_mobile, loan_rep_amount from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '5'";
	}
	else if($file == "penalties"){
		$sql = "select loan_rep_date, users.Client_Name, loan_rep_mobile, loan_rep_amount from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '2'";
	}
	else if($file == "new_clients"){
		$sql = "select Introduction_Introducer_Mobile, Introduction_Client_Mobile, Introduction_Date, Introduction_Relationship from introduction where Introduction_Date between '$filter_start_date' and '$filter_end_date' order by Introduction_Date, Introduction_Introducer_Mobile asc";
	}
	else if($file == "b2c"){
		$sql = "select mpesa_bc_receipt, mpesa_bc_date, mpesa_bc_details, mpesa_bc_status, mpesa_bc_Withdrawn, mpesa_bc_Paid_IN, mpesa_bc_Balance, other_party_info from mpesa_bc where mpesa_bc_date between '$filter_start_date_1' and '$filter_end_date_1'";
	}
	else if($file == "c2b"){
		$sql = "select mpesa_bc_receipt, mpesa_bc_date, mpesa_bc_details, mpesa_bc_status, mpesa_bc_paid_in, other_party_info, transaction_party_details from mpesa_cb where mpesa_bc_date between '$filter_start_date_1' and '$filter_end_date_1'";
	}
	else if($file == "ussd"){
		$sql = "select loop_id, loop_date, loop_mobile, loop_session, loop_step, No_Of_Loops from ussd_loop_steps where loop_date between '$filter_start_date_1' and '$filter_end_date_1' order by loop_date asc";
	}
	else if($file == "rate"){
		$sql = "select distinct Introduction_Introducer_Mobile, count(Introduction_Client_Mobile)members from introduction where Introduction_Date between '$filter_start_date' and '$filter_end_date' group by Introduction_Introducer_Mobile order by Introduction_Date, Introduction_Introducer_Mobile asc";
	}
	else if($file == "interest"){
		$sql = "select loan_rep_date, users.Client_Name, loan_rep_mobile, loan_rep_amount from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '1' order by loan_rep_date asc";
	}
	else if($file == "ussd_summary"){
		$sql = "select loop_id, loop_date, loop_mobile, loop_session, loop_step, No_Of_Loops from ussd_loop_steps where loop_date between '$filter_start_date' and '$filter_end_date' order by loop_date asc";
	}
	else if($file == "loan_bal"){
		$sql = "select loan_application.Loan_mobile, loan_application.Loan_Expiry_Date, loan_application.Loan_Amount_Sent, Loan_Sched_Loan_ID, loan_sched_id, Loan_Sched_Type, loan_sched_due_amount, Loan_Sched_Due_Date, Loan_Sched_Paid_Amount from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where Loan_Sched_Due_Date between '$filter_start_date' and '$filter_end_date' and loan_sched_type = '3' and Loan_Sched_Paid_Amount = '0'";
	}
	else if($file == "comms"){
		$sql = "select com_date, users.Client_Name, com_mobile, com_amount from commissions inner join users on users.Client_Mobile = commissions.Com_Mobile where com_date between '$filter_start_date_1' and '$filter_end_date_1'";
	}
	else if($file == "commissions"){
		$sql = "select com_date, com_amount from commissions where com_mobile = '$username' and com_date between '$filter_start_date_1' and '$filter_end_date_1'";
	}
	else if($file == "loans"){
		$sql = "select loan_date, Loan_Expiry_Date, Loan_mobile, users.Client_Name, loan_amount, loan_status from loan_application inner join users on users.Client_Mobile = loan_application.Loan_mobile where loan_date between '$filter_start_date_1' and '$filter_end_date_1'";
	}
	else if($file == "loans_disbursed"){
		$sql = "select loan_date, Loan_Expiry_Date, Loan_mobile, users.Client_Name, loan_amount, Loan_Amount_Sent, Loan_Mpesa_Code from loan_application inner join users on users.Client_Mobile = loan_application.Loan_mobile where loan_date between '$filter_start_date_1' and '$filter_end_date_1'";
	}
	$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
	//select database   
	$Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());  
	//execute query 
	$result = @mysql_query($sql,$Connect) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno()); 
	$file_ending = "xls";
	//header info for browser
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=$filename.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");
	/*******Start of Formatting for Excel*******/   
	//define separator (defines columns in excel & tabs in word)
	$sep = "\t"; //tabbed character
	//start of printing column names as names of MySQL fields
	for ($i = 0; $i < mysql_num_fields($result); $i++) {
	echo mysql_field_name($result,$i) . "\t";
	}
	print("\n");    
	//end of printing column names  
	//start while loop to get data
	    while($row = mysql_fetch_row($result))
	    {
		$schema_insert = "";
		for($j=0; $j<mysql_num_fields($result);$j++)
		{
		    if(!isset($row[$j]))
		        $schema_insert .= "NULL".$sep;
		    elseif ($row[$j] != "")
		        $schema_insert .= "$row[$j]".$sep;
		    else
		        $schema_insert .= "".$sep;
		}
		$schema_insert = str_replace($sep."$", "", $schema_insert);
		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		$schema_insert .= "\t";
		print(trim($schema_insert));
		print "\n";
	    }   
?>
