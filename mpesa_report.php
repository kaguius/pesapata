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
		$page_title = "MPESA B2C and C2B Report";
		include_once('includes/header.php');
		$filter_clerk = 0;
		if (!empty($_GET)){	
			$filter_clerk = $_GET['clerk'];
			$filter_start_date = $_GET['report_start_date'];
			$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
			$filter_start_date2 = date('d-m-Y', strtotime(str_replace('-', '/', $filter_start_date2)));
			$filter_end_date = $_GET['report_end_date'];
			$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
			$filter_end_date2 = date('d-m-Y', strtotime(str_replace('-', '/', $filter_end_date2)));
		}
		include_once('includes/db_conn.php');
		if ($filter_start_date != "" && $filter_end_date != ""){
			$page_title = "MPESA B2C and C2B Report";
			$filter_start_date = $filter_start_date.' 00:00:00';
			$filter_end_date = $filter_end_date.' 23:59:59';
			$filter_start_date2 = $filter_start_date2.' 00:00:00';
			$filter_end_date2 = $filter_end_date2.' 23:59:59';
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3>MPESA B2C Report Summary</h3>
					<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=b2c"><img src="images/excel.jpeg" width="25px"></a></p>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
						<thead bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Receipt</th>
								<th>Date</th>
								<th>Details</th>
								<th>Status</th>
								<th>Withdrawn</th>
								<th>Other Party</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 $sql = mysql_query("select mpesa_bc_receipt, mpesa_bc_date, mpesa_bc_details, mpesa_bc_status, mpesa_bc_Withdrawn, mpesa_bc_Paid_IN, mpesa_bc_Balance, other_party_info from mpesa_bc where mpesa_bc_date between '$filter_start_date' and '$filter_end_date'");
						 $total_invoice = 0;
						 $intcount = 0;
						 while ($row = mysql_fetch_array($sql))
						 {
							$intcount++;
							$receipt = $row['mpesa_bc_receipt'];
							$date = $row['mpesa_bc_date'];
							$details = $row['mpesa_bc_details'];
							$status = $row['mpesa_bc_status'];
							$withdrawn = $row['mpesa_bc_Withdrawn'];
							$other_party = $row['other_party_info'];
							
							if ($intcount % 2 == 0) {
								$display= '<tr bgcolor = #F0F0F6>';
							}
							else {
								$display= '<tr>';
							}
							echo $display;
							echo "<td valign='top'>$intcount.</td>";
							echo "<td valign='top'>$receipt</td>";
							echo "<td valign='top'>$date</td>";
							echo "<td valign='top'>$details</td>";
							echo "<td valign='top'>$status</td>";
							echo "<td valign='top'>$withdrawn</td>";
							echo "<td valign='top'>$other_party</td>";
							echo "</tr>";
						}
						?>
						</tbody>
						<tfoot bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Receipt</th>
								<th>Date</th>
								<th>Details</th>
								<th>Status</th>
								<th>Withdrawn</th>
								<th>Other Party</th>
							</tr>
						</tfoot>
					</table>
					<br /><br />
					<h3>MPESA C2B Report Summary</h3>
					<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=c2b"><img src="images/excel.jpeg" width="25px"></a></p>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example2">
						<thead bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Receipt</th>
								<th>Date</th>
								<th>Details</th>
								<th>Status</th>
								<th>Paid IN</th>
								<th>Other Party</th>
								<th>Transaction Party</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 $sql = mysql_query("select mpesa_bc_receipt, mpesa_bc_date, mpesa_bc_details, mpesa_bc_status, mpesa_bc_paid_in, other_party_info, transaction_party_details from mpesa_cb where mpesa_bc_date between '$filter_start_date2' and '$filter_end_date2'");
						 $total_invoice = 0;
						 $intcount = 0;
						 while ($row = mysql_fetch_array($sql))
						 {
							$intcount++;
							$receipt = $row['mpesa_bc_receipt'];
							$date = $row['mpesa_bc_date'];
							$details = $row['mpesa_bc_details'];
							$status = $row['mpesa_bc_status'];
							$paid_in = $row['mpesa_bc_paid_in'];
							$other_party = $row['other_party_info'];
							$party_details = $row['transaction_party_details'];
							
							if ($intcount % 2 == 0) {
								$display= '<tr bgcolor = #F0F0F6>';
							}
							else {
								$display= '<tr>';
							}
							echo $display;
							echo "<td valign='top'>$intcount.</td>";
							echo "<td valign='top'>$receipt</td>";
							echo "<td valign='top'>$date</td>";
							echo "<td valign='top'>$details</td>";
							echo "<td valign='top'>$status</td>";
							echo "<td valign='top'>$paid_in</td>";
							echo "<td valign='top'>$other_party</td>";
							echo "<td valign='top'>$party_details</td>";
							echo "</tr>";
						}
						?>
						</tbody>
						<tfoot bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Receipt</th>
								<th>Date</th>
								<th>Details</th>
								<th>Status</th>
								<th>Paid IN</th>
								<th>Other Party</th>
								<th>Transaction Party</th>
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
