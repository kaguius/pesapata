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
		$page_title = "Profit vs Loss Report";
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
			$page_title = "Profit vs Loss Report";
			$filter_start_date_full = date("d M, Y", strtotime($filter_start_date));
			$filter_end_date_full = date("d M, Y", strtotime($filter_end_date));
			//$filter_start_date = $filter_start_date.' 00:00:00';
			//$filter_end_date = $filter_end_date.' 23:59:59';
			$sql = mysql_query("select sum(loan_rep_amount)penalties from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '2'");
			while ($row = mysql_fetch_array($sql))
			{
				$penalties = $row['penalties'];
			}
			$sql = mysql_query("select sum(loan_rep_amount)principal from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '3'");
			while ($row = mysql_fetch_array($sql))
			{
				$principal = $row['principal'];
			}
			$sql = mysql_query("select sum(loan_rep_amount)interest from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '1'");
			while ($row = mysql_fetch_array($sql))
			{
				$interest = $row['interest'];
			}
			$sql = mysql_query("select sum(loan_rep_amount)transactions from loan_repayments inner join users on users.Client_Mobile = loan_repayments.Loan_rep_mobile inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where loan_rep_date between '$filter_start_date' and '$filter_end_date' and loan_schedule.Loan_Sched_Type = '5'");
			while ($row = mysql_fetch_array($sql))
			{
				$transactions = $row['transactions'];
			}
			$sql = mysql_query("select sum(loan_sched_due_amount)overdue from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where Loan_Sched_Due_Date between '$filter_start_date' and '$filter_end_date' and loan_sched_type = '3' and Loan_Sched_Paid_Amount = '0'");
			while ($row = mysql_fetch_array($sql))
			{
				$overdue = $row['overdue'];
			}
			$profits = $penalties + $principal + $interest;
			$loss = $transactions + $overdue;
			$net = $profits - $loss;
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3>Report Date Range: <?php echo $filter_start_date_full ?> to <?php echo $filter_end_date_full ?></h3>
					<p><strong>Profits</strong>
					<hr>
					Principal: <?php echo "KES ".number_format($principal, 2); ?><br />
					Interest: <?php echo "KES ".number_format($interest, 2); ?><br />
					Penalties: <?php echo "KES ".number_format($penalties, 2); ?>
					</p>
					<hr>
					<p><strong>Profits: <?php echo "KES ".number_format($profits, 2); ?></strong>
					<hr>
					<p><strong>Loss</strong>
					<hr>
					Transactions: <?php echo "KES ".number_format($transactions, 2); ?><br />
					Overdue Payments: <?php echo "KES ".number_format($overdue, 2); ?>
					</p>
					<hr>
					<p><strong>Loss: <?php echo "KES ".number_format($loss, 2); ?></strong>
					<hr>
					<p><strong>Net: <?php echo "KES ".number_format($net, 2); ?></strong>
					<hr>
					
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
