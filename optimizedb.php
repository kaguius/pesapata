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
		include_once('includes/header.php');
		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2>Optimize Database | e-kodi</h2>
					<strong>You are here:</strong> &raquo; <a href="index.php">Home</a> &raquo; <a href="admin.php">Admin</a> &raquo; Optimize Database<br />
					<?php
					/***********************************************************
						optimimze.php - optimizes all databases and tables of the
										 given mysql host.

						2008 - technitip.net
						***********************************************************/

						$mysqlhost = "127.0.0.1"; // enter MySQL host
						$mysqluser = "root";      // enter MySQL user
						$mysqlpwd  = "kaguius";  // enter password
						$db = "rent_management";
						###########################################

						$connection = mysql_connect($mysqlhost, $mysqluser, $mysqlpwd);
						if (mysql_error())
						{
							echo "Could not connect to database server! " . mysql_error() . "\n";
							exit;
						}
						if (!mysql_select_db($db, $connection))
						{
							echo "Could not connect to database! " . mysql_error() . "\n";
							exit;
						}
						
						###########################################
							$sql = "SHOW TABLES FROM $db";
							$result = mysql_query($sql);
							//$result = mysql_list_tables($db);
							echo '<h4>Optimize tables in <b>'.$db.'</b> database.</h4>';
							while ($row = mysql_fetch_row($result))
							{
								if ( $db == "information_schema" )
								continue;

								echo $db . ".`" . $row[0] . "`";

								$sql = "OPTIMIZE TABLE `".$row[0]."`";
								$erg = mysql_query($sql, $connection) or die(mysql_error());
								$data= mysql_fetch_array($erg, MYSQL_ASSOC);

								if($data)
								{
								echo " - " . $data['Msg_text'] . "<br>";
								}
							}
						###########################################
					?>
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
<?php
	}
	include_once('includes/footer.php');
?>
<?php
	
