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
		$page_title = "Generations Report";
		include_once('includes/header.php');
		include_once('includes/db_conn.php');

		?>
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					
					<?php
					$sql3 = mysql_query("select distinct Introduction_Introducer_Mobile, users.Client_Name from introduction inner join users on users.Client_Mobile = introduction.Introduction_Introducer_Mobile order by users.Client_Name asc");
					$intcount = 0;
					$intro_percent = 0;	
					while ($row = mysql_fetch_array($sql3))
					{
						$intcount++;
						$mobile = $row['Introduction_Introducer_Mobile'];
						$client_name = $row['Client_Name'];
						echo "<h3>Client Details</h3>";
						echo "<strong>Generation 1: Client Name:</strong> $client_name, ";
						echo "<strong>Mobile Number:</strong> $mobile";
						$sql2 = mysql_query("select count(Introduction_Client_Mobile)count from introduction where Introduction_Introducer_Mobile = '$mobile' group by Introduction_Introducer_Mobile");
						$intcount = 0;	
						while ($row = mysql_fetch_array($sql2))
						{
							$intro_count = $row['count'];
							$intro_percent = ($intro_count/5)*100;
						}
						$sql2 = mysql_query("select sum(com_amount)commissions from commissions where com_mobile = '$mobile'");
						$intcount = 0;	
						while ($row = mysql_fetch_array($sql2))
						{
							$commissions = $row['commissions'];
							if($commissions == ""){
								$commissions = 0;
							}
						}
						$sql2 = mysql_query("select sum(loan_amount)loans from loan_application where loan_mobile = '$mobile'");
						$intcount = 0;	
						while ($row = mysql_fetch_array($sql2))
						{
							$loans = $row['loans'];
							if($loans == ""){
								$loans = 0;
							}
						}
						echo "<table width='90%'><tr>";
						if($intro_percent < 1){
							echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Introduction Rate: $intro_percent%</strong></td>";
						}
						else{
							echo "<td width='33.33%' bgcolor='#02662E'><strong><font color='#FFFFFF'>Introduction Rate: $intro_percent%</font></strong></td>";
						}
						if($loans <= 0){
							echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Loans: KES ".number_format($loans, 2)."</strong></td>";
						}
						else{
							echo "<td width='33.33%' bgcolor='#02662E'><strong><font color='#FFFFFF'>Loans: KES ".number_format($loans, 2)."</font></strong></td>";
						}
						if($commissions <= 0){
							echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Commissions: KES ".number_format($commissions, 2)."</strong></td>";
						}
						else{
							echo "<td width='33.33%'  bgcolor='#02662E'><strong><font color='#FFFFFF'>Commissions: KES ".number_format($commissions, 2)."</font></strong></td>";
						}
						$intro_percent = 0;
						echo "</tr></table>";
						$intro_count = 0;
						$intro_percent = 0;
						$commissions = 0;
						$loans = 0;
						$sql = mysql_query("select Introduction_Client_Mobile, users.Client_Name from introduction inner join users on users.Client_Mobile = introduction.Introduction_Client_Mobile where Introduction_Introducer_Mobile = '$mobile'");
						$intcount = 0;	
						while ($row = mysql_fetch_array($sql))
						{
							$intcount++;
							$intro_mobile = $row['Introduction_Client_Mobile'];
							$intro_client_name = $row['Client_Name'];
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Generation 2: Introduction Name:</strong> $intro_client_name, ";
							echo "<strong>Mobile Number:</strong> $intro_mobile</p>";
							$sql2 = mysql_query("select count(Introduction_Client_Mobile)count from introduction where Introduction_Introducer_Mobile = '$intro_mobile' group by Introduction_Introducer_Mobile");
							$intcount = 0;	
							while ($row = mysql_fetch_array($sql2))
							{
								$intro_count = $row['count'];
								$intro_percent = ($intro_count/5)*100;
							}
							$sql2 = mysql_query("select sum(com_amount)commissions from commissions where com_mobile = '$intro_mobile'");
							$intcount = 0;	
							while ($row = mysql_fetch_array($sql2))
							{
								$commissions = $row['commissions'];
								if($commissions == ""){
									$commissions = 0;
								}
							}
							$sql2 = mysql_query("select sum(loan_amount)loans from loan_application where loan_mobile = '$intro_mobile'");
							$intcount = 0;	
							while ($row = mysql_fetch_array($sql2))
							{
								$loans = $row['loans'];
								if($loans == ""){
									$loans = 0;
								}
							}
							echo "<table width='90%'><tr>";
							if($intro_percent < 1){
								echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Introduction Rate: $intro_percent%</strong></td>";
							}
							else{
								echo "<td width='33.33%' bgcolor='#02662E'><strong><font color='#FFFFFF'>Introduction Rate: $intro_percent%</font></strong></td>";
							}
							if($loans <= 0){
								echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Loans: KES ".number_format($loans, 2)."</strong></td>";
							}
							else{
								echo "<td width='33.33%' bgcolor='#02662E'><strong><font color='#FFFFFF'>Loans: KES ".number_format($loans, 2)."</font></strong></td>";
							}
							if($commissions <= 0){
								echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Commissions: KES ".number_format($commissions, 2)."</strong></td>";
							}
							else{
								echo "<td width='33.33%'  bgcolor='#02662E'><strong><font color='#FFFFFF'>Commissions: KES ".number_format($commissions, 2)."</font></strong></td>";
							}
							echo "</tr></table>";
							$intro_count = 0;
							$intro_percent = 0;
							$commissions = 0;
							$loans = 0;
							$sql5 = mysql_query("select Introduction_Client_Mobile, users.Client_Name from introduction inner join users on users.Client_Mobile = introduction.Introduction_Client_Mobile where Introduction_Introducer_Mobile = '$intro_mobile'");
							$intcount = 0;
							$intro_count = 0;
							$intro_percent = 0;
							$commissions = 0;
							$loans = 0;
							while ($row = mysql_fetch_array($sql5))
							{
								$intcount++;
								$intro_mobile_l2 = $row['Introduction_Client_Mobile'];
								$intro_client_name_l2 = $row['Client_Name'];
								
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Generation 3: Introduction Name:</strong> $intro_client_name_l2, ";
								echo "<strong>Mobile Number:</strong> $intro_mobile_l2</p>";
								$sql2 = mysql_query("select count(Introduction_Client_Mobile)count from introduction where Introduction_Introducer_Mobile = '$intro_mobile_l2' group by Introduction_Introducer_Mobile");
								$intcount = 0;	
								while ($row = mysql_fetch_array($sql2))
								{
									$intro_count = $row['count'];
									if($intro_count == ""){
										$intro_count = 0;
									}
									$intro_percent = ($intro_count/5)*100;
								}
								$sql2 = mysql_query("select sum(com_amount)commissions from commissions where com_mobile = '$intro_mobile_l2'");
								$intcount = 0;	
								while ($row = mysql_fetch_array($sql2))
								{
									$commissions = $row['commissions'];
									if($commissions == ""){
										$commissions = 0;
									}
								}
								$sql2 = mysql_query("select sum(loan_amount)loans from loan_application where loan_mobile = '$intro_mobile_l2'");
								$intcount = 0;	
								while ($row = mysql_fetch_array($sql2))
								{
									$loans = $row['loans'];
									if($loans == ""){
										$loans = 0;
									}
								}
								echo "<table width='90%'><tr>";
								if($intro_percent < 1){
									echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Introduction Rate:$intro_percent%</strong></td>";
								}
								else{
									echo "<td width='33.33%' bgcolor='#02662E'><strong><font color='#FFFFFF'>Introduction Rate: $intro_percent%</font></strong></td>";
								}
								if($loans <= 0){
									echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Loans: KES ".number_format($loans, 2)."</strong></td>";
								}
								else{
									echo "<td width='33.33%' bgcolor='#02662E'><strong><font color='#FFFFFF'>Loans: KES ".number_format($loans, 2)."</font></strong></td>";
								}
								if($commissions <= 0){
									echo "<td width='33.33%' bgcolor='#F69B1B'><strong>Commissions: KES ".number_format($commissions, 2)."</strong></td>";
								}
								else{
									echo "<td width='33.33%'  bgcolor='#02662E'><strong><font color='#FFFFFF'>Commissions: KES ".number_format($commissions, 2)."</font></strong></td>";
								}
								echo "</tr></table>";
								$intro_count = 0;
								$intro_percent = 0;
								$commissions = 0;
								$loans = 0;
							}
						}
					}
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
