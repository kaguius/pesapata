<?php
	$userid = "";
	$adminstatus = 4;
	$property_manager_id = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$property_manager_id = $_SESSION["property_manager_id"] ;
	}

	//if($adminstatus != 1 || $adminstatus != 2 || $adminstatus != 4){
	if($adminstatus == 3){
		include_once('includes/header.php');
		?>
		<script type="text/javascript">
			document.location = "insufficient_permission.php";
		</script>
		<?php
	}
	else{
		include ("includes/core_functions.php");	
		include_once('includes/db_conn.php');
		$transactiontime = date("Y-m-d G:i:s");
		$page_title = "Reports";
		include_once('includes/header.php');
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><font color="#FA9828">Reports</font></h2>
					Which report would you like to view?
					<hr>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" >
						<tr>
							<td width="50%" valign="top">
								<table width="100%" border="0" cellspacing="2" cellpadding="2" >
									<?php if($adminstatus == 1){ ?>
									<tr height="85px">
										<td valign='top'><a href='new_clients.php'><img src="images/clients.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='new_clients.php'>New Clients Report</a></strong><br />
										View data on all new clients in the system.</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='communications.php'><img src="images/communication.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='communications.php'>Communications Report</a></strong><br />
										View of Communication – that is calls, sms, USSD and email)</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='rate_introduction.php'><img src="images/introduction.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='rate_introduction.php'>Rate of Introduction Report</a></strong><br />
										View of Rate of Introduction (Complete and Incomplete, have they taken any loans)</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='penalties.php'><img src="images/penalties.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='penalties.php'>Penalty Paid Report</a></strong><br />
										View reports on all penalties paid by clients.</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='defaulters.php'><img src="images/defaulters.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='defaulters.php'>Defaulters Report</a></strong><br />
										View a report on all defaulters</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='profit_loss.php'><img src="images/profit.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='profit_loss.php'>Profit vs Loss Report</a></strong><br />
										View the profit vs Loss report.</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='sms_summary.php'><img src="images/sms.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='sms_summary.php'>Agent SMS Summary Report</a></strong><br />
										Agent SMS Summary.</td>
									</tr>
									<?php } ?>
								</table>
							</td>
							<td width="50%" valign="top">
								<table width="100%" border="0" cellspacing="2" cellpadding="2" >
									<tr height="85px">
										<td valign='top'><a href='mpesa_report.php'><img src="images/mpesa.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='mpesa_report.php'>MPESA B2C and C2B Report</a></strong><br />
										View of MPESA B2C and C2B ( total transactions, opening balance and closing balance)</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='revenue.php'><img src="images/revenue.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='revenue.php'>Revenue Generated Report</a></strong><br />
										Monthly performance, Annual Performance, Revenue Generated</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='interest.php'><img src="images/interest.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='interest.php'>Interest Paid Report</a></strong><br />
										View reports on all interest paid by clients.</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='transactions.php'><img src="images/transactions.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='transactions.php'>Transaction Charge Report</a></strong><br />
										View reports on all transactions paid by clients.</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='expected_payments.php'><img src="images/payments.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='expected_payments.php'>Expected Payments Report</a></strong><br />
										View reports on all expected payments.</td>
									</tr>
									<tr height="85px">
										<td valign='top'><a href='ussd_summary.php'><img src="images/ussd.jpeg" width="65px"></a></td>
										<td valign='top'><strong><a href='ussd_summary.php'>Agent USSD Summary Report</a></strong><br />
										Agent USSD Summary.</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<hr>
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
<?php
	}
	include_once('includes/footer.php');
?>
