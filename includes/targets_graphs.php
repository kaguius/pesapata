<?php
	$userid = "";
	$adminstatus = 3;
	$property_manager_id = "";
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
	}
	include_once('includes/db_conn.php');
	
	$filter_month = date("m");
	$filter_year = date("Y");
	$filter_day = date("d");
	$day_one = 01;
	
	$start_date = $filter_year.'-'.$filter_month.'-'.$day_one;
	$current_date = $filter_year.'-'.$filter_month.'-'.$filter_day;
	
	$diff = abs(strtotime($current_date) - strtotime($start_date));

	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	
	if (!empty($_GET)){	
		$filter_start_date = $_GET['report_start_date'];
		$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
		$filter_end_date = $_GET['report_end_date'];
		$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
	}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      	google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
          	['Month', 'Clients', 'Target'],
          	<?php
          		$result = mysql_query("select distinct EXTRACT(Month FROM Introduction_Date)month, count(introduction_id)members from introduction group by EXTRACT(Month FROM Introduction_Date)");
          		$intcount = 0;
			while ($row = mysql_fetch_array($result))
			{
				$intcount++;
				$month = $row['month'];
				$members = $row['members'];
				$result_tender = mysql_query("select (month_".$intcount.")target from targets where category = 'number_of_clients'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$target = $row['target'];
				}
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
				?>
					['<?php echo $month_name ?>',  <?php echo $members ?>,  <?php echo $target ?>],

				<?php
			}
		?>
        	]);

        	var options = {
          		seriesType: "bars",
          		series: {1: {type: "line"}},
			backgroundColor: '#F8F2F2',
	    		chartArea:{left: 70, top:10, width:'90%', height:'80%'},
	    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
			vAxis: {title: 'Number of Clients',  titleTextStyle: {color: '#333'}},
        	};

        	var chart = new google.visualization.ComboChart(document.getElementById('clients'));
        	chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
</script>
<script type="text/javascript">
      	google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
          	['Month', 'Loans', 'Target'],
          	<?php
          		$result = mysql_query("select distinct EXTRACT(Month FROM loan_date)month, sum(loan_amount)loans from loan_application group by EXTRACT(Month FROM loan_date)");
          		$intcount = 0;
			while ($row = mysql_fetch_array($result))
			{
				$intcount++;
				$month = $row['month'];
				$loans = $row['loans'];
				$result_tender = mysql_query("select (month_".$intcount.")target from targets where category = 'total_loans'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$target_loans = $row['target'];
				}
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
				?>
					['<?php echo $month_name ?>',  <?php echo $loans ?>,  <?php echo $target_loans ?>],

				<?php
			}
		?>
        	]);

        	var options = {
          		seriesType: "bars",
          		series: {1: {type: "line"}},
			backgroundColor: '#F8F2F2',
	    		chartArea:{left: 70, top:10, width:'90%', height:'80%'},
	    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
			vAxis: {title: 'Loan Amounts',  titleTextStyle: {color: '#333'}},
        	};

        	var chart = new google.visualization.ComboChart(document.getElementById('total_loans'));
        	chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
</script>
<script type="text/javascript">
      	google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
          	['Month', 'Commissions', 'Target'],
          	<?php
          		$result = mysql_query("select distinct EXTRACT(Month FROM com_date)month, sum(com_amount)comms from commissions group by EXTRACT(Month FROM com_date)");
          		$intcount = 0;
			while ($row = mysql_fetch_array($result))
			{
				$intcount++;
				$month = $row['month'];
				$comms = $row['comms'];
				$result_tender = mysql_query("select (month_".$intcount.")target from targets where category = 'total_commissions'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$target_loans = $row['target'];
				}
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
				?>
					['<?php echo $month_name ?>',  <?php echo $comms ?>,  <?php echo $target_loans ?>],

				<?php
			}
		?>
        	]);

        	var options = {
          		seriesType: "bars",
          		series: {1: {type: "line"}},
			backgroundColor: '#F8F2F2',
	    		chartArea:{left: 70, top:10, width:'90%', height:'80%'},
	    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
			vAxis: {title: 'Commissions',  titleTextStyle: {color: '#333'}},
        	};

        	var chart = new google.visualization.ComboChart(document.getElementById('total_comms'));
        	chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
</script>

<script type="text/javascript">
      	google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
          	['Month', 'Interest', 'Target'],
          	<?php
          		$result = mysql_query("select distinct EXTRACT(Month FROM loan_rep_date)month, sum(loan_rep_amount)interest from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '2014' and loan_schedule.Loan_Sched_Type = '1' group by EXTRACT(Month FROM loan_rep_date)");
          		$intcount = 0;
			while ($row = mysql_fetch_array($result))
			{
				$intcount++;
				$month = $row['month'];
				$interest = $row['interest'];
				$result_tender = mysql_query("select (month_".$intcount.")target from targets where category = 'total_interest'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$target_interest = $row['target'];
				}
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
				?>
					['<?php echo $month_name ?>',  <?php echo $interest ?>,  <?php echo $target_interest ?>],

				<?php
			}
		?>
        	]);

        	var options = {
          		seriesType: "bars",
          		series: {1: {type: "line"}},
			backgroundColor: '#F8F2F2',
	    		chartArea:{left: 70, top:10, width:'90%', height:'80%'},
	    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
			vAxis: {title: 'Interest',  titleTextStyle: {color: '#333'}},
        	};

        	var chart = new google.visualization.ComboChart(document.getElementById('total_interest'));
        	chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
</script>
