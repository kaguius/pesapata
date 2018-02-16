<?php
	$userid = "";
	$adminstatus = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$station = $_SESSION["station"] ;
	}
	$filter_month = date("m");
	$filter_year = date("Y");
	$filter_day = date("d");
	$day_one = 01;
	
	$start_date = $filter_year.'-'.$filter_month.'-'.$day_one;
	$current_date = $filter_year.'-'.$filter_month.'-'.$filter_day;
?>
<div id="menu">
	<ul>
		<?php if($adminstatus == 3){ ?>
		<li><a href="index.php">Home</a></li>
		<li><a href="commissions.php">Commissions</a></li>
		<li><a href="introductions.php">Generations</a></li>
		<li><a href="loans.php">Loans</a></li>
		<li><a href="request.php">Request Commissions</a></li>
		<li><a href="about_us.php">About Pesa Pata</a></li>
		<?php } ?>
		<?php if($adminstatus == 1){ ?>
		<li><a href="index.php">Home</a></li>
		<li><a href="search.php">Search</a></li>
		<li><a href="target.php">Targets</a></li>
		<li><a href="comms.php">Commissions</a></li>
		<li><a href="generations.php">Generations</a></li>
		<li><a href="loan_bal.php">Loans</a></li>
		<li><a href="reports.php">Reports</a></li>
		<li><a href="#" title="Admin">Admin</a>
			<ul>
				<li><a href="user_details.php">User Profiles</a></li>
				<li><a href="user_logs.php">User Logs</a></li>
				<li><a href="user_failed_logs.php">User Failed Logs</a></li>
			</ul>
		</li>
		<?php } ?>
		<li><a href="logout.php" title="Log Out">Log Out</a></li>
	</ul>
	<br class="clearfix" />
</div>
