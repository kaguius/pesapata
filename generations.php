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
					<h3>Client Details</h3>
					
					<?php
					$sql3 = mysql_query("select distinct Introduction_Introducer_Mobile, users.Client_Name from introduction inner join users on users.Client_Mobile = introduction.Introduction_Introducer_Mobile order by users.Client_Name asc");
					$intcount = 0;
					$intro_percent = 0;	
					while ($row = mysql_fetch_array($sql3))
					{
						$intcount++;
						$mobile = $row['Introduction_Introducer_Mobile'];
						$client_name = $row['Client_Name'];
						echo "<h3>$client_name: $mobile</h3>";
						echo "<table width='100%' border='0' cellspacing='2' cellpadding='2' class='display' id='exampl'>";
						echo "<thead bgcolor='#E6EEEE'>";
						echo "<tr>";
						echo "<th>Generations</th>";
						echo "<th>Clients</th>";
						echo "<th>Loans</th>";
						echo "<th>Repayments</th>";
						echo "<th>Commissions</th>";
						echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						$intcount = 0;
						$sql2 = mysql_query("select count(Introduction_Client_Mobile)count from introduction where Introduction_Introducer_Mobile = '$mobile' group by Introduction_Introducer_Mobile");
						while ($row = mysql_fetch_array($sql2))
						{
							$intro_count = $row['count'];
							$intro_percent = ($intro_count/5)*100;
						}
						$sql2 = mysql_query("select sum(loan_amount)loans from loan_application inner join introduction on introduction.Introduction_Introducer_Mobile = loan_application.Loan_mobile where loan_mobile = '$mobile'");
						while ($row = mysql_fetch_array($sql2))
						{
							$loans = $row['loans'];
							if($loans == ""){
								$loans = 0;
							}
						}
						$sql2 = mysql_query("select sum(loan_amount)loans from loan_application inner join introduction on introduction.Introduction_Introducer_Mobile = loan_application.Loan_mobile where loan_mobile = '$mobile'");
						while ($row = mysql_fetch_array($sql2))
						{
							$loans = $row['loans'];
							if($loans == ""){
								$loans = 0;
							}
						}
						$sql2 = mysql_query("select sum(loan_rep_amount)repayments from loan_repayments inner join introduction on introduction.Introduction_Client_Mobile = loan_repayments.Loan_rep_Acc_Id where Introduction_Introducer_Mobile = '$mobile' and loan_rep_amount = '250' order by loan_rep_acc_id asc");
						while ($row = mysql_fetch_array($sql2))
						{
							$repayments = $row['repayments'];
							if($repayments == ""){
								$repayments = 0;
							}
						}
						$sql2 = mysql_query("select sum(Com_Amount)commissions from commissions inner join loan_repayments on loan_repayments.Loan_rep_id = commissions.comm_pay_id inner join introduction on introduction.Introduction_Client_Mobile = loan_repayments.Loan_rep_Acc_Id where Introduction_Introducer_Mobile = '$mobile'");
						while ($row = mysql_fetch_array($sql2))
						{
							$commissions = $row['commissions'];
							if($commissions == ""){
								$commissions = 0;
							}
						}
						
						echo "<tr>";
						echo "<td>1</td>";
						echo "<td>$intro_count</td>";
						echo "<td>KES ".number_format($loans, 2)."</td>";
						echo "<td>KES ".number_format($repayments, 2)."</td>";
						echo "<td>KES ".number_format($commissions, 2)."</td>";
						echo "</tr>";
						$intro_count_2 = 0;
						$loans_2 = 0;
						$repayments_2 = 0;
						$commissions_2 = 0;
						$sql = mysql_query("select Introduction_Client_Mobile, users.Client_Name from introduction inner join users on users.Client_Mobile = introduction.Introduction_Client_Mobile where Introduction_Introducer_Mobile = '$mobile'");
						while ($row = mysql_fetch_array($sql))
						{
							$intro_mobile = $row['Introduction_Client_Mobile'];
							$intro_client_name = $row['Client_Name'];
							$sql2 = mysql_query("select count(Introduction_Client_Mobile)count from introduction where Introduction_Introducer_Mobile = '$intro_mobile' group by Introduction_Introducer_Mobile");
							while ($row = mysql_fetch_array($sql2))
							{
								$intro_count_2 = $row['count'];
								$intro_percent = ($intro_count/5)*100;
							}
							
							$sql2 = mysql_query("select sum(loan_amount)loans from loan_application inner join introduction on introduction.Introduction_Introducer_Mobile = loan_application.Loan_mobile where loan_mobile = '$intro_mobile'");
							while ($row = mysql_fetch_array($sql2))
							{
								$loans_2 = $row['loans'];
								if($loans_2 == ""){
									$loans_2 = 0;
								}
							}
							$sql2 = mysql_query("select sum(loan_rep_amount)repayments from loan_repayments inner join introduction on introduction.Introduction_Client_Mobile = loan_repayments.Loan_rep_Acc_Id where Introduction_Introducer_Mobile = '$intro_mobile' and loan_rep_amount = '250' order by loan_rep_acc_id asc");
							while ($row = mysql_fetch_array($sql2))
							{
								$repayments_2 = $row['repayments'];
								if($repayments_2 == ""){
									$repayments_2 = 0;
								}
							}
							$sql2 = mysql_query("select sum(Com_Amount)commissions from commissions inner join loan_repayments on loan_repayments.Loan_rep_id = commissions.comm_pay_id inner join introduction on introduction.Introduction_Client_Mobile = loan_repayments.Loan_rep_Acc_Id where Introduction_Introducer_Mobile = '$intro_mobile'");
							while ($row = mysql_fetch_array($sql2))
							{
								$commissions_2 = $row['commissions'];
								if($commissions_2 == ""){
									$commissions_2 = 0;
								}
							}
							$intro_count_total_2 = $intro_count_total_2 + $intro_count_2;
							$repayments_total_2 = $repayments_total_2 + $repayments_2;
							$loans_total_2 = $loans_total_2 + $loans_2;
							$commissions_total_2 = $commissions_total_2 + $commissions_2;
							$intro_count_3 = 0;
							$loans_3 = 0;
							$repayments_3 = 0;
							$commissions_3 = 0;
							$sql5 = mysql_query("select Introduction_Client_Mobile, users.Client_Name from introduction inner join users on users.Client_Mobile = introduction.Introduction_Client_Mobile where Introduction_Introducer_Mobile = '$intro_mobile'");
							while ($row = mysql_fetch_array($sql5))
							{
								$intro_mobile_3 = $row['Introduction_Client_Mobile'];
								$intro_client_name = $row['Client_Name'];
								$sql2 = mysql_query("select count(Introduction_Client_Mobile)count from introduction where Introduction_Introducer_Mobile = '$intro_mobile_3' group by Introduction_Introducer_Mobile");
								while ($row = mysql_fetch_array($sql2))
								{
									$intro_count_3 = $row['count'];
									$intro_percent = ($intro_count/5)*100;
								}
							
								$sql2 = mysql_query("select sum(loan_amount)loans from loan_application inner join introduction on introduction.Introduction_Introducer_Mobile = loan_application.Loan_mobile where loan_mobile = '$intro_mobile_3'");
								while ($row = mysql_fetch_array($sql2))
								{
									$loans_3 = $row['loans'];
									if($loans_3 == ""){
										$loans_3 = 0;
									}
								}
								$sql2 = mysql_query("select sum(loan_rep_amount)repayments from loan_repayments inner join introduction on introduction.Introduction_Client_Mobile = loan_repayments.Loan_rep_Acc_Id where Introduction_Introducer_Mobile = '$intro_mobile_3' and loan_rep_amount = '250' order by loan_rep_acc_id asc");
								while ($row = mysql_fetch_array($sql2))
								{
									$repayments_3 = $row['repayments'];
									if($repayments_3 == ""){
										$repayments_3 = 0;
									}
								}
								$sql2 = mysql_query("select sum(Com_Amount)commissions from commissions inner join loan_repayments on loan_repayments.Loan_rep_id = commissions.comm_pay_id inner join introduction on introduction.Introduction_Client_Mobile = loan_repayments.Loan_rep_Acc_Id where Introduction_Introducer_Mobile = '$intro_mobile_3'");
								while ($row = mysql_fetch_array($sql2))
								{
									$commissions_3 = $row['commissions'];
									if($commissions_3 == ""){
										$commissions_3 = 0;
									}
								}
								$intro_count_total_3 = $intro_count_total_3 + $intro_count_3;
								$repayments_total_3 = $repayments_total_3 + $repayments_3;
								$loans_total_3 = $loans_total_3 + $loans_3;
								$commissions_total_3 = $commissions_total_3 + $commissions_3;
							}
						}
						echo "<tr>";
						echo "<td>2</td>";
						echo "<td>$intro_count_total_2</td>";
						echo "<td>KES ".number_format($loans_total_2, 2)."</td>";
						echo "<td>KES ".number_format($repayments_total_2, 2)."</td>";
						echo "<td>KES ".number_format($commissions_total_2, 2)."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td>3</td>";
						echo "<td>0</td>";
						echo "<td>KES ".number_format($loans_total_3, 2)."</td>";
						echo "<td>KES ".number_format($repayments_total_3, 2)."</td>";
						echo "<td>KES ".number_format($commissions_total_3, 2)."</td>";
						echo "</tr>";
						echo "<td>4</td>";
						echo "<td>0</td>";
						echo "<td>KES ".number_format($loans_total_3, 2)."</td>";
						echo "<td>KES ".number_format($repayments_total_3, 2)."</td>";
						echo "<td>KES ".number_format($commissions_total_3, 2)."</td>";
						echo "</tr>";
						echo "<td>5</td>";
						echo "<td>0</td>";
						echo "<td>KES ".number_format($loans_total_3, 2)."</td>";
						echo "<td>KES ".number_format($repayments_total_3, 2)."</td>";
						echo "<td>KES ".number_format($commissions_total_3, 2)."</td>";
						echo "</tr>";
						echo "<td>6</td>";
						echo "<td>0</td>";
						echo "<td>KES ".number_format($loans_total_3, 2)."</td>";
						echo "<td>KES ".number_format($repayments_total_3, 2)."</td>";
						echo "<td>KES ".number_format($commissions_total_3, 2)."</td>";
						echo "</tr>";
						echo "</tbody>";
						echo "</table>";
						echo "<p>&nbsp;</p>";
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
