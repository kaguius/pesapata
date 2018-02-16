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
		if (!empty($_GET)){	
			$month_drill = $_GET['month'];
			$page_title = $_GET['title'];
		}
		$page_title = $page_title;
		include_once('includes/header.php');
		include_once('includes/db_conn.php');
		include_once('includes/dash_graphs.php');
		if ($month != ""){
			//$page_title = "Overdue Loan Balances Report";
			$result_tender = mysql_query("select month from calender where id = '$month_drill'");
			while ($row = mysql_fetch_array($result_tender))
			{
				$month_name = $row['month'];
			}
			//$filter_start_date = $filter_start_date.' 00:00:00';
			//$filter_end_date = $filter_end_date.' 23:59:59';
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<?php if($page_title == 'Principal Collected Day Comparison'){ ?>
					<h2><?php echo $page_title ?></h2>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="revenue_collected_daily" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<?php } ?>
					<?php if($page_title == 'Overdue Loan Balances Day Comparison'){ ?>
					<h2><?php echo $page_title ?></h2>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="overdue_balances_daily" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<?php } ?>
					<?php if($page_title == 'Interest Day Comparison'){ ?>
					<h2><?php echo $page_title ?></h2>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="interest_daily" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<?php } ?>
					<?php if($page_title == 'Commissions Generated Day Comparison'){ ?>
					<h2><?php echo $page_title ?></h2>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="commissions_daily" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<?php } ?>
					<?php if($page_title == 'Defaulters Day Comparison'){ ?>
					<!--Make this graph a stacked graph -->
					<h2><?php echo $page_title ?></h2>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="defaulters_daily" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<?php } ?>
					<?php if($page_title == 'Client Commissions Generated Day Comparison'){ ?>
					<!--Make this graph a stacked graph -->
					<h2><?php echo $page_title ?></h2>
					<table width="100%" cellpadding="20px" cellspacing="10px">
						<tr>
							<td width="100%" bgcolor="#F8F2F2" style="border: 1px dotted #C5D6FC; padding-left:2px;">
								<div class='example awesome'>
							  	<div id="comms_cumulative" style="width: 950px; height: 400px;"></div>
								</div>
							</td>

						</tr>
					</table>
					<?php } ?>
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
