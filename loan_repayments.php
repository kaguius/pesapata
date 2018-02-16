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
		$page_title = "Loans Repayments Report";
		include_once('includes/header.php');
		$filter_clerk = 0;
		if (!empty($_GET)){	
			$filter_start_date = $_GET['start_date'];
			$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
			$filter_end_date = $_GET['end_date'];
			$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
		}
		include_once('includes/db_conn.php');
		if ($filter_start_date != "" && $filter_end_date != ""){
			$page_title = "Loans Repayments Report";
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3>Loan Repayment Schedule</h3>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
						<thead bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Mobile Number</th>
								<th>MPESA Code</th>
								<th>Payment Type</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 //$sql = mysql_query("select loan_date, loan_amount, loan_amount_sent, loan_status from loan_application where loan_mobile = '$username' and loan_date between '$filter_start_date' and '$filter_end_date'");
						 $sql = mysql_query("select loan_rep_date, loan_rep_acc_id, loan_rep_amount, loan_rep_mpesa_code, loan_schedule.Loan_Sched_Type from loan_repayments inner join loan_schedule on loan_repayments.Loan_Rep_Sched_ID = loan_schedule.Loan_Sched_ID where loan_rep_mobile = '$username' and loan_rep_date between '$filter_start_date' and '$filter_end_date'");
						 $total_loan = 0;
						 $total_amount_sent = 0;
						 $intcount = 0;
						 while ($row = mysql_fetch_array($sql))
						 {
							$intcount++;
							$loan_rep_date = $row['loan_rep_date'];
							$loan_rep_mobile = $row['loan_rep_acc_id'];
							$loan_rep_amount = $row['loan_rep_amount'];
							$loan_rep_mpesa_code = $row['loan_rep_mpesa_code'];
							$Loan_Sched_Type = $row['Loan_Sched_Type'];
							//$loan_amount_sent = $row['loan_amount_sent'];
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
							echo "<td valign='top'>$loan_rep_date</td>";
							echo "<td valign='top'>$loan_rep_mobile</td>";
							echo "<td valign='top'>$loan_rep_mpesa_code</td>";
							echo "<td valign='top'>$shedule_name</td>";
							echo "<td valign='top' align='right'>KES ".number_format($loan_rep_amount, 2)."</td>";
							echo "</tr>";
							$total_loan = $total_loan + $loan_rep_amount;
							$total_amount_sent = $total_amount_sent + $loan_repay;	
						}
						?>
						</tbody>
						<tr bgcolor = '#E6EEEE'>
							<td colspan='5'><strong>&nbsp;</strong></td>
							<td align='right' valign='top'><strong>KES <?php echo number_format($total_loan, 2) ?></strong></td>
						</tr>
						<tfoot bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Mobile Number</th>
								<th>MPESA Code</th>
								<th>Payment Type</th>
								<th>Amount</th>
							</tr>
						</tfoot>
					</table>
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
