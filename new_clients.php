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
		$page_title = "New Clients Report";
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
			$page_title = "New Clients Report";
			//$filter_start_date = $filter_start_date.' 00:00:00';
			//$filter_end_date = $filter_end_date.' 23:59:59';
			$filter_start_date_full = date("d M, Y", strtotime($filter_start_date));
			$filter_end_date_full = date("d M, Y", strtotime($filter_end_date));
			
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<h3>Report Date Range: <?php echo $filter_start_date_full ?> to <?php echo $filter_end_date_full ?></h3>
					<p>Export: <a href="excel_print.php?filter_start_date=<?php echo $filter_start_date ?>&filter_end_date=<?php echo $filter_end_date ?>&file=new_clients"><img src="images/excel.jpeg" width="25px"></a></p>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
						<thead bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Introducer</th>
								<th>Client Name</th>
								<th>Client Number</th>
								<th>Relationship</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 $sql = mysql_query("select Introduction_Introducer_Mobile, Introduction_Client_Mobile, Introduction_Date, Introduction_Relationship from introduction inner join loan_application on loan_application.Loan_mobile != introduction.Introduction_Client_Mobile where Introduction_Date between '$filter_start_date' and '$filter_end_date' group by Introduction_Client_Mobile order by Introduction_Date, Introduction_Introducer_Mobile asc ");
						 $total_invoice = 0;
						 $intcount = 0;
						 while ($row = mysql_fetch_array($sql))
						 {
							$intcount++;
							$introducer_mobile = $row['Introduction_Introducer_Mobile'];
							$client_mobile = $row['Introduction_Client_Mobile'];
							$introduction_date = $row['Introduction_Date'];
							$relationship = $row['Introduction_Relationship'];
							$sql2 = mysql_query("select client_name from users where client_mobile = '$introducer_mobile'");
							while ($row = mysql_fetch_array($sql2))
							{
								$introducer_name = $row['client_name'];
							}
							$sql3 = mysql_query("select client_name from users where client_mobile = '$client_mobile'");
							while ($row = mysql_fetch_array($sql3))
							{
								$client_name = $row['client_name'];
							}
							$sql4 = mysql_query("select Rel_Type_Name from relationships where Rel_Type_Id = '$relationship'");
							while ($row = mysql_fetch_array($sql4))
							{
								$relationship_name = $row['Rel_Type_Name'];
							}
							
							if ($intcount % 2 == 0) {
								$display= '<tr bgcolor = #F0F0F6>';
							}
							else {
								$display= '<tr>';
							}
							echo $display;
							echo "<td valign='top'>$intcount.</td>";
							echo "<td valign='top'>$introduction_date</td>";
							echo "<td valign='top'>$introducer_name</td>";
							echo "<td valign='top'>$client_name</td>";
							echo "<td valign='top'>$client_mobile</td>";
							echo "<td valign='top'>$relationship_name</td>";
							echo "</tr>";
						}
						?>
						</tbody>
						<tfoot bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Introducer</th>
								<th>Client Name</th>
								<th>Client Number</th>
								<th>Relationship</th>
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
