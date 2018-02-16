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
		$page_title = "Commissions Report";
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
			$page_title = "Commissions Report";
			$filter_start_date_full = date("d M, Y", strtotime($filter_start_date));
			$filter_end_date_full = date("d M, Y", strtotime($filter_end_date));
			//$filter_start_date = $filter_start_date.' 00:00:00';
			//$filter_end_date = $filter_end_date.' 23:59:59';
			include_once('includes/other_graphs.php');
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3>Report Date Range: <?php echo $filter_start_date_full ?> to <?php echo $filter_end_date_full ?></h3>
					<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=comms"><img src="images/excel.jpeg" width="25px"></a></p>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="commissions" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
						<thead bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Client Name</th>
								<th>Mobile</th>
								<th>Status</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 $sql = mysql_query("select com_date, Com_Mobile, Com_Acc_No, Com_Amount from commissions where com_date between '$filter_start_date' and '$filter_end_date' order by com_date asc");
						 $total_invoice = 0;
						 $intcount = 0;
						 while ($row = mysql_fetch_array($sql))
						 {
							$intcount++;
							$com_date = $row['com_date'];
							$com_mobile = $row['Com_Mobile'];
							$Com_Acc_No = $row['Com_Acc_No'];
							$com_amount = $row['Com_Amount'];
							//$Com_Acc_No = "254".$Com_Acc_No;
							
							$sql2 = mysql_query("select Client_Name from users where Client_Mobile = '$Com_Acc_No'");
							//echo "select Client_Name from users where Com_Acc_No = '$Com_Acc_No'";
							while ($row = mysql_fetch_array($sql2))
							{
								$client_name = $row['Client_Name'];
							}
			
							if($com_amount < 0){
								$status = 'Paid Out';
							}
							else{
								$status = 'Earned';
							}
							
							if ($intcount % 2 == 0) {
								$display= '<tr bgcolor = #F0F0F6>';
							}
							else {
								$display= '<tr>';
							}
							echo $display;
							echo "<td valign='top'>$intcount.</td>";
							echo "<td valign='top'>$com_date</td>";
							echo "<td valign='top'>$client_name</td>";
							echo "<td valign='top'>$com_mobile</td>";
							echo "<td valign='top'>$status</td>";
							echo "<td valign='top' align='right'>KES ".number_format($com_amount, 2)."</td>";
							echo "</tr>";
							$total_invoice = $total_invoice + $com_amount;	
						}
						?>
						</tbody>
						<tr bgcolor = '#E6EEEE'>
							<td colspan='5'><strong>&nbsp;</strong></td>
							<td align='right' valign='top'><strong>KES <?php echo number_format($total_invoice, 2) ?></strong></td>
						</tr>
						<tfoot bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Client Name</th>
								<th>Mobile</th>
								<th>Status</th>
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
