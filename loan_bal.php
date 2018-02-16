<?php
	$userid = "";
	$adminstatus = 4;
	$property_manager_id = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$username = $_SESSION["username"];
	}

	//if($adminstatus != 1 || $adminstatus != 2 || $adminstatus != 4){
	if($adminstatus == 4){
		include_once('includes/header.php');
		?>
		<script type="text/javascript">
			document.location = "insufficient_permission.php";
		</script>
		<?php
	}
	else{
		$transactiontime = date("Y-m-d G:i:s");
		$page_title = "Overdue Loan Balances Report";
		include_once('includes/header.php');
		$filter_clerk = 0;
		if (!empty($_GET)){	
			$filter_clerk = $_GET['clerk'];
			$filter_start_date = $_GET['report_start_date'];
			$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
			$filter_end_date = $_GET['report_end_date'];
			$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
		}
		include_once('includes/db_conn.php');
		if ($filter_start_date != "" && $filter_end_date != ""){
			$page_title = "Overdue Loan Balances Report";
			$current_date = date("Y-m-d");
			$filter_start_date_1 = $filter_start_date.' 00:00:00';
			$filter_end_date_1 = $filter_end_date.' 23:59:59';
			$filter_start_date_full = date("d M, Y", strtotime($filter_start_date));
			$filter_end_date_full = date("d M, Y", strtotime($filter_end_date));
			include_once('includes/other_graphs.php');
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3>Report Date Range: <?php echo $filter_start_date_full ?> to <?php echo $filter_end_date_full ?></h3>
					
					<div id="tabs">
						<ul>
							<li><a href="#tabs-1">Loans</a></li>
							<li><a href="#tabs-2">Overdue Loans</a></li>
							<li><a href="#tabs-3">Loans Disbursed</a></li>
							<!--<li><a href="#tabs-4">Age Analysis</a></li>-->
						</ul>
						<div id="tabs-1">
						<h3>Loans</h3>
						<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=loans"><img src="images/excel.jpeg" width="25px"></a></p>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Loan Date</th>
									<th>Loan Expiry</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Loan Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							 $sql = mysql_query("select loan_date, Loan_Expiry_Date, Loan_mobile, users.Client_Name, loan_amount, loan_status from loan_application inner join users on users.Client_Mobile = loan_application.Loan_mobile where loan_date between '$filter_start_date_1' and '$filter_end_date_1'");
							 $intcount = 0;
							 while ($row = mysql_fetch_array($sql))
							 {
								$intcount++;
								$loan_date = $row['loan_date'];
								$Loan_Expiry_Date = $row['Loan_Expiry_Date'];
								$Loan_mobile = $row['Loan_mobile'];
								$client_name = $row['Client_Name'];
								$loan_amount = $row['loan_amount'];
							
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$loan_date</td>";
								echo "<td valign='top'>$Loan_Expiry_Date</td>";
								echo "<td valign='top'>$client_name</td>";
								echo "<td valign='top'>$Loan_mobile</td>";
								echo "<td valign='top' align='right'>KES ".number_format($loan_amount, 2)."</td>";
								echo "</tr>";
								$total_invoice = $total_invoice + $loan_amount;
								$total_invoice_sent = $total_invoice_sent + $Loan_Amount_Sent;		
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='5'><strong>&nbsp;</strong></td>
								<!--<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice_sent, 2) ?></strong></td>-->
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Loan Date</th>
									<th>Loan Expiry</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Loan Amount</th>
								</tr>
							</tfoot>
						</table>
						</div>
						<div id="tabs-2">
						<h3>Overdue Loans</h3>
						<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=loan_bal"><img src="images/excel.jpeg" width="25px"></a></p>
						<!--<table width="100%" cellpadding="20px" cellspacing="10px">
							<tr>
								<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
									<div class='example awesome'>
								  	<div id="loan_balance" style="width: 950px; height: 400px;"></div>
									</div>
								</td>

							</tr>
						</table>-->
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example2">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Loan Expiry Date</th>
									<th>Loan Age</th>
									<th>Schedule Date</th>
									<th>Client Name</th>
									<th>Mobile</th>
									<th>Due Amount Type</th>
									<!--<th>Loan Disbursed</th>-->
									<th>Due Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							 $sql = mysql_query("select loan_application.Loan_mobile, loan_application.Loan_Expiry_Date, loan_application.Loan_Amount_Sent, Loan_Sched_Loan_ID, loan_sched_id, Loan_Sched_Type, loan_sched_due_amount, Loan_Sched_Due_Date, Loan_Sched_Paid_Amount from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where Loan_Sched_Due_Date between '$filter_start_date' and '$filter_end_date' and loan_sched_type = '3' and Loan_Sched_Paid_Amount = '0'");
							 $intcount = 0;
							 while ($row = mysql_fetch_array($sql))
							 {
								$intcount++;
								$loan_mobile = $row['Loan_mobile'];
								$Loan_Expiry_Date = $row['Loan_Expiry_Date'];
								$Loan_amount = $row['Loan_amount'];
								$Loan_Amount_Sent = $row['Loan_Amount_Sent'];
								$Loan_Sched_Due_Date = $row['Loan_Sched_Due_Date'];
								$loan_sched_due_amount = $row['loan_sched_due_amount'];
								$Loan_Sched_Type = $row['Loan_Sched_Type'];
							
								$start = strtotime($current_date);
								$end = strtotime($Loan_Expiry_Date);
								$loan_age = ((ceil(abs($end - $start) / 86400)));
														
								$sql3 = mysql_query("select client_name from users where client_mobile = '$loan_mobile'");
								while ($row = mysql_fetch_array($sql3))
								{
									$client_name = $row['client_name'];
								}
							
								$sql3 = mysql_query("select sch_type_text from schedule_type where sch_type_id = '$Loan_Sched_Type'");
								while ($row = mysql_fetch_array($sql3))
								{
									$shedule_name = $row['sch_type_text'];
								}
							
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$Loan_Expiry_Date</td>";
								echo "<td valign='top'>".number_format($loan_age, 0)."</td>";
								echo "<td valign='top'>$Loan_Sched_Due_Date</td>";
								echo "<td valign='top'>$client_name</td>";
								echo "<td valign='top'>$loan_mobile</td>";
								echo "<td valign='top'>$shedule_name</td>";
								//echo "<td valign='top' align='right'>KES ".number_format($Loan_Amount_Sent, 2)."</td>";
								echo "<td valign='top' align='right'>KES ".number_format($loan_sched_due_amount, 2)."</td>";
								echo "</tr>";
								$total_invoice = $total_invoice + $loan_sched_due_amount;
								$total_invoice_sent = $total_invoice_sent + $Loan_Amount_Sent;		
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='7'><strong>&nbsp;</strong></td>
								<!--<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice_sent, 2) ?></strong></td>-->
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Loan Expiry Date</th>
									<th>Loan Age</th>
									<th>Schedule Date</th>
									<th>Client Name</th>
									<th>Mobile</th>
									<th>Due Amount Type</th>
									<!--<th>Loan Disbursed</th>-->
									<th>Due Amount</th>
								</tr>
							</tfoot>
						</table>
						</div>
						<div id="tabs-3">
						<h3>Loans Disbursed</h3>
						<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=loans_disbursed"><img src="images/excel.jpeg" width="25px"></a></p>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example3">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Loan Date</th>
									<th>Loan Expiry</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>MPESA Code</th>
									<th>Loan Amount</th>
									<th>Loan Disbursed</th>
									
								</tr>
							</thead>
							<tbody>
							<?php
							 $sql = mysql_query("select loan_date, Loan_Expiry_Date, Loan_mobile, users.Client_Name, loan_amount, Loan_Amount_Sent, Loan_Mpesa_Code from loan_application inner join users on users.Client_Mobile = loan_application.Loan_mobile where loan_date between '$filter_start_date_1' and '$filter_end_date_1'");
							 $intcount = 0;
							 while ($row = mysql_fetch_array($sql))
							 {
								$intcount++;
								$loan_date = $row['loan_date'];
								$Loan_Expiry_Date = $row['Loan_Expiry_Date'];
								$Loan_mobile = $row['Loan_mobile'];
								$client_name = $row['Client_Name'];
								$loan_amount = $row['loan_amount'];
								$loan_amount_sent = $row['Loan_Amount_Sent'];
								$loan_mpesa_code = $row['Loan_Mpesa_Code'];
							
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$loan_date</td>";
								echo "<td valign='top'>$Loan_Expiry_Date</td>";
								echo "<td valign='top'>$client_name</td>";
								echo "<td valign='top'>$Loan_mobile</td>";
								echo "<td valign='top'>$loan_mpesa_code</td>";
								echo "<td valign='top' align='right'>KES ".number_format($loan_amount, 2)."</td>";
								echo "<td valign='top' align='right'>KES ".number_format($loan_amount_sent, 2)."</td>";
								echo "</tr>";
								$total_invoice = $total_invoice + $loan_amount;
								$total_invoice_sent = $total_invoice_sent + $loan_amount_sent;		
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='6'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice_sent, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Loan Date</th>
									<th>Loan Expiry</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>MPESA Code</th>
									<th>Loan Amount</th>
									<th>Loan Disbursed</th>
								</tr>
							</tfoot>
						</table>
						</div>
					</div>
					
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
		<?php
		}
		else{
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
				
					<h2><?php echo $page_title ?></h2>
					<form id="frmCreateTenant" name="frmCreateTenant" method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table border="0" width="100%" cellspacing="2" cellpadding="2">
							<tr >
								<td  valign="top">Select Start Date Range: </td>
								<td>
									<input title="Enter the Selection Date" value="" id="report_start_date" name="report_start_date" type="text" maxlength="100" class="main_input" size="15" />
								</td>
								<td  valign="top">Select End Date Range:</td>
								<td> 
									<input title="Enter the Selection Date" value="" id="report_end_date" name="report_end_date" type="text" maxlength="100" class="main_input" size="15" />
								</td>
								
							</tr>
							<tr>
								<td><button name="btnNewCard" id="button">Search</button></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
<?php
		}
	}
	include_once('includes/footer.php');
?>
