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
		$page_title = "Search Filter";
		include_once('includes/header.php');
		include_once('includes/db_conn.php');

		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
						<thead bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Client Mobile</th>
								<th>Client Name</th>
								<th>Gender</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 $sql = mysql_query("select Client_Mobile, Client_Name, Client_Gender from users order by client_name asc");
						 $total_invoice = 0;
						 $intcount = 0;
						 while ($row = mysql_fetch_array($sql))
						 {
							$intcount++;
							$client_mobile = $row['Client_Mobile'];
							$client_name = $row['Client_Name'];
							$client_gender = $row['Client_Gender'];
							
							if ($intcount % 2 == 0) {
								$display= '<tr bgcolor = #F0F0F6>';
							}
							else {
								$display= '<tr>';
							}
							echo $display;
							echo "<td valign='top'>$intcount.</td>";
							echo "<td valign='top'><a href='search_filter.php?mobile=$client_mobile'>$client_mobile</a></td>";
							echo "<td valign='top'>$client_name</td>";
							echo "<td valign='top'>$client_gender</td>";
							echo "</tr>";
						}
						?>
						</tbody>
						<tfoot bgcolor="#E6EEEE">
							<tr>
								<th>#</th>
								<th>Client Mobile</th>
								<th>Client Name</th>
								<th>Gender</th>
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
	include_once('includes/footer.php');
?>
