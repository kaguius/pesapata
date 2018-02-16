<?php
	$userid = "";
	$adminstatus = 4;
	$property_manager_id = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
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
		$filter_start_date = "";
		$filter_end_date = "";
		$filter_market = "";
		$report_start_date = 0;
		$report_end_date = 0;
		$transactiontime = date("Y-m-d G:i:s");
		$page_title = "Dashboards: Daily Reports";
		$filter_month = date("m");
		$filter_year = date("Y");
		
		$result = mysql_query("select month from juja_market_fees.calender where id = '$filter_month'");
		while ($row = mysql_fetch_array($result)){
			$report_month = $row['month'];
		}
		include_once('includes/header.php');
		
		if (!empty($_GET)){
			$filter_start_date = $_GET['report_start_date'];
			$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
			$filter_end_date = $_GET['report_end_date'];
			$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
			$filter_market = $_GET['market'];
			$filter_clerk = $_GET['clerk'];
			$filter_market_type = $_GET['market_type'];
		}
		include_once('includes/db_conn.php');
		if ($filter_start_date != "1970-01-01" && $filter_end_date != "1970-01-01" && $filter_market != ""){
			$page_title = "Dashboards: Daily Reports";
			include_once('includes/graphs.php');
			$filter_start_date_name = date("d M, Y", strtotime($filter_start_date));
			$filter_end_date_name = date("d M, Y", strtotime($filter_end_date));
			$market_name = ucwords(strtolower($filter_market));
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><font color="#000A8B"><?php echo $market_name ?> Sub County:</font> Sub County Dashboard</h2>
					<!--<h2><?php echo $page_title ?>: <?php echo $market_name ?> Sub County</h2>-->
					<h3>Report Date Range: <?php echo $filter_start_date_name ?> to <?php echo $filter_end_date_name ?></h3>
					<h4><strong>Market Reports: </strong> &raquo; <a href="dashboard.php?market=<?php echo $filter_market ?>&report_start_date=0&report_end_date=0" title="System Dashboard">Dashboard</a> <strong>Market Tabular Reports</strong>: &raquo; <a href="by_clerk.php?market=<?php echo $filter_market ?>&clerk=0&report_start_date=0&report_end_date=0" title="By Clerk Report">By Clerk</a> | <a href="by_market.php?market=<?php echo $filter_market ?>&report_start_date=0&report_end_date=0" title="By Market Report">By Market</a> | <a href="by_market_fee_type.php?market=<?php echo $filter_market ?>&report_start_date=0&report_end_date=0" title="By Market Fee Type Report">By Market Fee Type</a></h4>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<?php if($filter_clerk != ""){ ?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<h3><font color="#000A8B">Revenue By Clerk: <?php echo $filter_clerk ?>: Month to Date Filtered Results</font></h3>
							  	<div id="revenue_clerk" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT paid_date, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements where paid_date between '$filter_start_date' and '$filter_end_date' and status = 'Paid' GROUP BY paid_date order by paid_date asc");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$paid_date = $row['paid_date'];
								$paid_date = date("d M, Y", strtotime($paid_date));
								$invoice = $row['invoice_amount'];			
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$paid_date</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } 
						else{?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<h3><font color="#000A8B">Revenue By Clerk: <?php echo $filter_clerk ?>: Month to Date Filtered Results</font></h3>
							
							  	<div id="models_tracking" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT clerk, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements WHERE paid_date between '$filter_start_date' and '$filter_end_date' and status = 'Paid' GROUP BY clerk;");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$clerk = $row['clerk'];
								$invoice = $row['invoice_amount'];
								$clerk = ucwords(strtolower($clerk));			
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$clerk</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<br />
						<br />
						<? } ?>
						<?php if($filter_market_type != ""){ ?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<h3><font color="#000A8B">Revenue By Market Fee Type: <?php echo $filter_market_type ?></font></h3>
							  
							  	<div id="revenue_market_type" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example2">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Invoice Date</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT paid_date, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements where paid_date between '$filter_start_date' and '$filter_end_date' and product='$filter_market_type' and status = 'Paid' GROUP BY paid_date order by paid_date asc");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$paid_date = $row['paid_date'];
								$invoice = $row['invoice_amount'];
								$paid_date = date("d M, Y", strtotime($paid_date));		
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$paid_date</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Invoice Date</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } 
						else{?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
								  <h3><font color="#000A8B">Revenue By Market Fee Type: <?php echo $filter_market_type ?></font></h3>
								
								  <div id="payments_tracking" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<br />
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example2">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Product Fee Type</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT product, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements WHERE paid_date between '$filter_start_date' and '$filter_end_date' and status = 'Paid' GROUP BY product ORDER BY product ASC");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$product = $row['product'];
								$invoice = $row['invoice_amount'];		
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$product</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Product Fee Type</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } ?>
					</table>
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
		<?php
		}
		else{
		if (!empty($_GET)){	
			$filter_market = $_GET['market'];
			$filter_clerk = $_GET['clerk'];
			$filter_market_type = $_GET['market_type'];
		}
		include_once('includes/db_conn.php');
		$filter_month = date("m");
		$filter_year = date("Y");
		$result = mysql_query("select month from juja_market_fees.calender where id = '$filter_month'");
		while ($row = mysql_fetch_array($result)){
			$report_month = $row['month'];
		}
		include_once('includes/graphs_dashboard.php');
		$market_name = ucwords(strtolower($filter_market));	
		?>
			
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><font color="#000A8B"><?php echo $market_name ?> Sub County:</font> Markets Dashboard</h2>
					<h4><strong>Market Reports: </strong> &raquo; <a href="dashboard.php?market=<?php echo $filter_market ?>&report_start_date=0&report_end_date=0" title="System Dashboard">Dashboard</a> <strong>Market Tabular Reports</strong>: &raquo; <a href="by_clerk.php?market=<?php echo $filter_market ?>&clerk=0&report_start_date=0&report_end_date=0" title="By Clerk Report">By Clerk</a> | <a href="by_market.php?market=<?php echo $filter_market ?>&report_start_date=0&report_end_date=0" title="By Market Report">By Market</a> | <a href="by_market_fee_type.php?market=<?php echo $filter_market ?>&report_start_date=0&report_end_date=0" title="By Market Fee Type Report">By Market Fee Type</a></h4>
					<!--<h2><?php echo $page_title ?>: <?php echo $market_name ?> Sub County</h2>-->
					<form id="frmCreateTenant" name="frmCreateTenant" method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table border="0" width="100%" cellspacing="2" cellpadding="2">					<tr >
								<td  valign="top">Select Start Date Range: </td>
								<td>
									<input title="Enter the Selection Date" value="" id="report_start_date" name="report_start_date" type="text" maxlength="100" class="main_input" size="15" />
								</td>
								<td  valign="top">Select End Date Range:</td>
								<td> 
									<input title="Enter the Selection Date" value="" id="report_end_date" name="report_end_date" type="text" maxlength="100" class="main_input" size="15" />
									<input value="<?php echo $filter_market ?>" id="market" name="market" hidden type="text" class="main_input" size="15" />
								</td>
								
							</tr>
							<tr>	
								<td><button name="btnNewCard" id="button">Search</button></td>
							</tr>
						</table>
					</form>
					
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<?php if($filter_clerk != ""){ ?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<h3><font color="#000A8B">Revenue By Clerk: <?php echo $filter_clerk ?>: Month to Date Filtered Results (<?php echo $report_month ?>, <?php echo $filter_year ?>)</font></h3>
							  	<div id="revenue_clerk" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Invoice Date</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT paid_date, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements where EXTRACT(MONTH FROM paid_date) = '$filter_month' and EXTRACT(YEAR FROM paid_date) = '$filter_year' and clerk='$filter_clerk' and status = 'Paid' GROUP BY paid_date order by paid_date asc");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$paid_date = $row['paid_date'];
								$paid_date = date("d M, Y", strtotime($paid_date));
								$invoice = $row['invoice_amount'];		
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$paid_date</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } 
						else{?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<h3><font color="#000A8B">Revenue By Clerk: <?php echo $filter_clerk ?>: Month to Date Filtered Results (<?php echo $report_month ?>, <?php echo $filter_year ?>)</font></h3>
							  	<div id="models_tracking" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT clerk, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements where EXTRACT(MONTH FROM paid_date) = '$filter_month' and EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' GROUP BY clerk;;");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$clerk = $row['clerk'];
								$invoice = $row['invoice_amount'];
								$clerk = ucwords(strtolower($clerk));		
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$clerk</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } ?>
						<?php if($filter_market_type != ""){ ?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<h3><font color="#000A8B">Revenue By Market Fee Type: <?php echo $filter_market_type ?>: (<?php echo $report_month ?>, <?php echo $filter_year ?>)</font></h3>
							  	<div id="revenue_market_type" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example2">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Invoice Date</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT paid_date, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements where EXTRACT(MONTH FROM paid_date) = '$filter_month' and EXTRACT(YEAR FROM paid_date) = '$filter_year' and product='$filter_market_type' and status = 'Paid' GROUP BY paid_date order by paid_date asc");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$paid_date = $row['paid_date'];
								$invoice = $row['invoice_amount'];
								$paid_date = date("d M, Y", strtotime($paid_date));	
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$paid_date</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } 
						else{?>
						<tr>
							<td width="50%" bgcolor="#F0F1F1" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
								  <h3><font color="#000A8B">Revenue By Market Fee Type: <?php echo $filter_market_type ?> (<?php echo $report_month ?>, <?php echo $filter_year ?>)</font></h3>
								  <div id="payments_tracking" style="width: 950px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example2">
							<thead bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Product Fee Type</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$result_tender = mysql_query("SELECT DISTINCT product, SUM(invoice_amount)invoice_amount FROM ".$filter_market."_market_fees.statements where EXTRACT(MONTH FROM paid_date) = '$filter_month' and EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' GROUP BY product ORDER BY product ASC");
							$intcount = 0;
							$total_invoice = 0;
							while ($row = mysql_fetch_array($result_tender))
							{
								$intcount++;
								$product = $row['product'];
								$invoice = $row['invoice_amount'];	
								if ($intcount % 2 == 0) {
									$display= '<tr bgcolor = #F0F0F6>';
								}
								else {
									$display= '<tr>';
								}
								echo $display;
								echo "<td valign='top'>$intcount.</td>";
								echo "<td valign='top'>$product</td>";
								echo "<td valign='top' align='right'>KES ".number_format($invoice, 2)."</td>";
								$total_invoice = $total_invoice + $invoice;	
							}
							?>
							</tbody>
							<tr bgcolor = '#E6EEEE'>
								<td colspan='2'><strong>&nbsp;</strong></td>
								<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
							</tr>
							<tfoot bgcolor="#E6EEEE">
								<tr>
									<th>#</th>
									<th>Clerk Name</th>
									<th>Amount</th>
								</tr>
							</tfoot>
						</table>
						<? } ?>
						
					</table>
					
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
