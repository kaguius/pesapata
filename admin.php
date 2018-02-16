<?php
	$userid = "";
	$adminstatus = 3;
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
		$page_title = "Admin Functions";
		include_once('includes/header.php');
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?> | e-kodi</h2>
					Which feature would you like to work with?
					<hr>
					<table width="100%" border="0" cellspacing="2" cellpadding="2" >
						<tr>
							<td width="50%" valign="top">
								<table width="100%" border="0" cellspacing="2" cellpadding="2" >
									<?php if($adminstatus == 1){ ?>
									<tr>
										<td valign='top'><a href='create_property_managers.php'><img src="images/managers.jpeg" width="65px"></a></td>
										<td valign='top'><strong>Create Property Managers</strong><br />
										This feature lets you create property managers to the system.</td>
									</tr>
									<tr>
										<td valign='top'><a href='new_managers.php'><img src="images/new_managers.jpeg" width="65px"></a></td>
										<td valign='top'><strong>Suggested Managers</strong><br />
										This module enables you to view all the suggested managers by tenants.</td>
									</tr>									<?php } ?>
									<?php if($adminstatus == 1){ ?>
									<tr>
										<td valign='top'><a href='user_logs.php'><img src="images/sys_logs.jpg" width="65px"></a></td>
										<td valign='top'><strong>User Logs</strong><br />
										This features enable you to view logs of the system, logins done by who and time.</td>
									</tr>
									<tr>
										<td valign='top'><a href='helpdesk.php'><img src="images/Helpdesk+3.jpg" width="65px"></a></td>
										<td valign='top'><strong>Helpdesk</strong><br />
										This feature helps the client services team to Sort out User issues.</td>
									</tr>
									<tr>
										<td valign='top'><a href='user_failed_logs.php'><img src="images/sys_logs.jpg" width="65px"></a></td>
										<td valign='top'><strong>User Failed Logs</strong><br />
										This features enable you to view failed logs of the system</td>
									</tr>
									<?php } ?>
									<?php if($adminstatus == 5 || $adminstatus == 1){ ?>
									<tr>
										<td valign='top'><a href='support.php'><img src="images/help.jpg" width="65px"></a></td>
										<td valign='top'><strong>User Support</strong><br />
										This feature lets you reach support with any query that you may have with the system.</td>
									</tr>
									<?php } ?>	
								</table>
							</td>
							<td width="50%" valign="top">
								<table width="100%" border="0" cellspacing="2" cellpadding="2" >
									<?php if($adminstatus == 1){ ?>
									<tr>
										<td valign='top'><a href='optimizedb.php'><img src="images/database.jpg" width="65px"></a></td>
										<td valign='top'><strong>Optimize Database</strong><br />
										This feature enables you to optimize the database, makes it faster.</td>
									</tr>
									<?php } ?>
									<?php if($adminstatus <> 5){ ?>
									<tr>
										<td valign='top'><a href='user_details.php'><img src="images/users.jpg" width="65px"></a></td>
										<td valign='top'><strong>User Profiles</strong><br />
										This feature lets you view all the Users and right levels in the system.</td>
									</tr>
									
									<tr>
										<td valign='top'><a href='support.php'><img src="images/help.jpg" width="65px"></a></td>
										<td valign='top'><strong>User Support</strong><br />
										This feature lets you reach support with any query that you may have with the system.</td>
									</tr>
									<?php } ?>
									<?php if($adminstatus == 1){ ?>
									<tr>
										<td valign='top'><a href='backupdb.php'><img src="images/backups.jpg" width="75px"></a></td>
										<td valign='top'><strong>Database Backups</strong><br />
										Backup the database, ensuring you never loose any data from the system.</td>
									</tr>
									
									<?php } ?>
									
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
