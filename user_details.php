<?php
	$userid = "";
	$adminstatus = 3;
	$property_manager_id = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$station = $_SESSION["station"] ;
	}
	if($adminstatus == 3){
		include_once('includes/header.php');
		?>
		<script type="text/javascript">
			document.location = "insufficient_permission.php";
		</script>
		<?php
	}
	else{
		$page_title = "User(s) Listing";
		include_once('includes/header.php');
		include_once('includes/db_conn.php');
		
		if (!empty($_GET)){	
			$action = $_GET['action'];
			$user_id = $_GET['id'];
		}

		if ($action=='disable'){
			$sql2="update user_profiles set user_status = '0' where id = '$user_id'";
			$result = mysql_query($sql2);
			?>
				<script type="text/javascript">
				<!--
					document.location = "user_details.php";
				//-->
				</script>
			<?php
		}
		if ($action=='enable'){
			$sql2="update user_profiles set user_status = '1' where id = '$user_id'";
			$result = mysql_query($sql2);
			?>
				<script type="text/javascript">
				<!--
					document.location = "user_details.php";
				//-->
				</script>
			<?php
		}
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><font color="#FA9828">Admin Function:</font> <?php echo $page_title ?></h2>
					<p>+<a href="user_profiles.php">Add a new User</a></p>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="display" id="example">
						<thead bgcolor="#E5F6D4">
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email Address</th>
								<th>User Status</th>
								<th>Status</th>
								<th>Disable/ Enable</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if($adminstatus == 1 || $adminstatus == 2){
							$sql2 = mysql_query("select user_profiles.id, first_name, last_name, username, email_address,  admin_status.admin_status, user_status from user_profiles inner join admin_status on admin_status.id = user_profiles.admin_status order by user_status desc");
						}
						else{
							$sql2 = mysql_query("select user_profiles.id, first_name, last_name, username, email_address,  admin_status.admin_status, user_status from kiambu_market_fees.user_profiles inner join admin_status on admin_status.id = user_profiles.admin_status where user_profiles.station = '$station' order by user_status desc");
						}
						while($row = mysql_fetch_array($sql2)) {
							$intcount++;
							$id = $row['id'];
							$first_name = $row['first_name'];
							$first_name = ucwords(strtolower($first_name));
							$last_name = $row['last_name'];
							$last_name = ucwords(strtolower($last_name));
							$username = $row['username'];
							$email_address = $row['email_address'];
							$admin_status = $row['admin_status'];
							$user_status = $row['user_status'];
									
							if ($intcount % 2 == 0) {
								$display= '<tr bgcolor = #F8F2F2>';
							}
							else {
								$display= '<tr>';
							}
							echo $display;
								echo "<td valign='top'>$intcount</td>";
								echo "<td valign='top'><a href='user_profiles.php?id=$id&action=edit' title='User Details'>$username</a></td>";
								echo "<td valign='top'>$first_name</td>";
								echo "<td valign='top'>$last_name</td>";
								echo "<td valign='top'>$email_address</td>";
								echo "<td valign='top'>$admin_status</td>";
								if($user_status == '1'){
									echo "<td valign='top'>Active</td>";
									echo "<td valign='top' align='center'><a title = 'Disable User' href='user_details.php?id=$id&action=disable'><img src='images/delete.png' width='20px'></a></td>";
								}
								else{
									echo "<td valign='top'>Disabled</td>";
									if($user_status == 'Administrator' && $user_status == 'Management'){
										echo "<td valign='top' align='center'><a title = 'Enable User' href='user_details.php?id=$id&action=enable'><img src='images/active.png' width='20px'></a></td>";
									}
									else{
										echo "<td valign='top' align='center'><a title = 'Enable User' href='user_details.php?id=$id&action=enable'><img src='images/active.png'  width='20px'></a></td>";
									}
								}
										
							echo "</tr>";	
						}
							?>
						</tbody>
						<tfoot bgcolor="#E5F6D4">
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email Address</th>
								<th>User Status</th>
								<th>Status</th>
								<th>Disable/ Enable</th>
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
