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
		$page_title = "Request Commissions";
		include_once('includes/db_conn.php');
		include_once('includes/header.php');
		$result_tender = mysql_query("select sum(com_amount)amount from commissions where com_mobile = '$username' group by com_mobile");
		while ($row = mysql_fetch_array($result_tender))
		{
			$amount = $row['amount'];
		}
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3><font color="#000A8B">Commissions Collected:</font> KES <?php echo number_format($amount, 2) ?></h3>
					<form id="frmCreateTenant" name="frmCreateTenant" method="GET" action="request_email.php">
					<table width="100%" border="0" cellspacing="2" cellpadding="2" >
						<tr bgcolor = '#E6EEEE'>
							<td colspan="2"><strong>Commissions Remittances</strong></td>
						</tr>
						<tr>
							<td valign="top">Payment Type</td>
							<td valign="top">
								<select name='payment_type' id='payment_type'>
									<option value='mpesa'>MPESA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="top">Amount Requested</td>
							<td valign="top" colspan="3">
								<input title="Enter Amount" value="<?php echo $amount?>" id="commissions" name="commissions" type="text" maxlength="100" class="main_input" size="25" />
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<button name="btnNewCard" id="button">Submit</button>
							</td>
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
	include_once('includes/footer.php');
?>
