<?php
	$userid = "";
	$adminstatus = 4;
	$property_manager_id = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$station = $_SESSION["station"] ;
		$username = $_SESSION["username"];
	}

	//if($adminstatus != 1 || $adminstatus != 2 || $adminstatus != 4){
	if($adminstatus == 4){
		include_once('includes/header.php');
		?>
		<script type="text/javascript">
			document.location = "login.php";
		</script>
		<?php
	}
	else{
		$transactiontime = date("Y-m-d G:i:s");
		$page_title = "Dashboards";
		include_once('includes/header.php');
		include_once('includes/targets_graphs.php');
		$result_tender = mysql_query("select sum(com_amount)amount from commissions where com_mobile = '$username' group by com_mobile");
		while ($row = mysql_fetch_array($result_tender))
		{
			$amount = $row['amount'];
		}
		$result = mysql_query("select client_name from users where client_mobile = '$username'");
		while ($row = mysql_fetch_array($result))
		{
			$client_name = $row['client_name'];
			$client_name = ucwords(strtolower($client_name));
		}
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
				<?php if($adminstatus == 1){ ?>
					<h2><font color="#000A8B">Dashboard:</font> Targets vs Actuals</h2>
				<? }else{ ?>
					<h2><font color="#000A8B">Dashboard:</font> Total Commissions Generated</h2>
					<h3><font color="#000A8B">Client Name:</font> <?php echo $client_name ?>, <font color="#000A8B">Commissions Earned:</font> KES <?php echo number_format($amount, 2) ?></h3>
				<? } ?>
					<table width="100%" cellpadding="20px" cellspacing="10px">
					<?php if($adminstatus == '1'){ ?>
						<tr>
							<td width="50%" bgcolor="#F8F2F2" style="border: 1px dotted #F8F2F2; padding-left:2px;">
								<div class='example awesome'>
								  	<h3><font color="#000A8B">Number of Clients (Year to Date)</font></h3>
								  	<div id="clients" style="width: 470px; height: 300px;"></div>
								</div>
							</td>
							<td width="50%" bgcolor="#F8F2F2" style="border: 1px dotted #F8F2F2; padding-left:2px;">
								<div class='example awesome'>
								  	<h3><font color="#000A8B">Total Loans (Year to Date)</font></h3>
								  	<div id="total_loans" style="width: 470px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td width="50%" bgcolor="#F8F2F2" style="border: 1px dotted #F8F2F2; padding-left:2px;">
								<div class='example awesome'>
								  	<h3><font color="#000A8B">Interest (Year to Date)</font></h3>
								  	<div id="total_interest" style="width: 470px; height: 300px;"></div>
								</div>
							</td>
							<td width="50%" bgcolor="#F8F2F2" style="border: 1px dotted #F8F2F2; padding-left:2px;">
								<div class='example awesome'>
							  		<h3><font color="#000A8B">Commissions Generated (Year to Date)</font></h3>
							  		<div id="total_comms" style="width: 470px; height: 300px;"></div>
								</div>
							</td>
						</tr>
						
					<?php }
					else{ ?>
						<tr>
							<td width="50%" bgcolor="#F8F2F2" style="border: 1px dotted #F8F2F2; padding-left:2px;">
								<div class='example awesome'>
								  	<h3><font color="#000A8B">Commissions Earned (Year to Date)</font></h3>
								  	<div id="commissions_tracking" style="width: 470px; height: 300px;"></div>
								</div>
							</td>
							<td width="50%" bgcolor="#F8F2F2" style="border: 1px dotted #F8F2F2; padding-left:2px;">
								<div class='example awesome'>
							  		<h3><font color="#000A8B">Loans Repayments (Year to Date)</font></h3>
							  		<div id="loans_tracking" style="width: 470px; height: 300px;"></div>
								</div>
							</td>
						</tr>
					<?php } ?>
					</table>
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
<?php
	}
	include_once('includes/footer.php');
?>
