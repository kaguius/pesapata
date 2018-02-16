<?php
	$userid = "";
	$adminstatus = 3;
	$property_manager_id = "";
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$username = $_SESSION["username"];
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
		$month_drill = $_GET['month'];
		$page_title = $_GET['title'];
	}
?>
    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      	google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChart);
      	function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        		//['Month', 'Revenue'],
        		//['Commission', 'Commission'],
        		['Month', 'link', 'Commissions', { role: 'annotation' }],
        		<?php
				$result_tender = mysql_query("select distinct EXTRACT(Month FROM com_date)month, sum(com_amount)commissions from commissions where EXTRACT(year FROM com_date) = '$filter_year' and com_mobile = '$username' group by EXTRACT(Month FROM com_date)");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month = $row['month'];
					$commissions = $row['commissions'];
					$result_tender = mysql_query("select month from calender where id = '$month'");
					while ($row = mysql_fetch_array($result_tender))
					{
						$month_name = $row['month'];
					}
			
					?>
						['<?php echo $month_name ?>', 'financial_summary.php?month=<?php echo $month ?>&title=Client Commissions Generated Day Comparison', <?php echo $commissions?>, '<?php echo $commissions?>'],
						//['<?php echo $month_name ?>', <?php echo $commissions ?>],
					<?php
				}
			?>
        	]);
        
        var view = new google.visualization.DataView(data);
      	view.setColumns([0, 2]);

        var options = {
        	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Commission',  titleTextStyle: {color: '#333'}},
        };
        	
        var chart = new google.visualization.ColumnChart(document.getElementById('commissions_tracking'));
        chart.draw(view, options);
        	
        var selectHandler = function(e) {
        	window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
       	}
       		
       	google.visualization.events.addListener(chart, 'select', selectHandler);
    }
</script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Day', 'Commissions'],
        	<?php
        		$com_amount_sum = 0;
			$result = mysql_query("select distinct com_date, sum(com_amount)com_amount from commissions where EXTRACT(month FROM com_date) = '$month_drill' and com_mobile = '$username' group by com_date order by com_date asc");
			while ($row = mysql_fetch_array($result))
			{
				$com_date = $row['com_date'];
				$com_amount = $row['com_amount'];
				$com_amount_sum = $com_amount_sum + $com_amount;
			
				?>
					['<?php echo $com_date ?>', <?php echo $com_amount_sum ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Commissions',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.LineChart(document.getElementById('comms_cumulative'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'Loan Amount', 'Loan Repayment'],
        	<?php
			$result = mysql_query("select loan_amount, loan_amount_sent, sum(loan_rep_amount)loan_repay from loan_application inner join loan_repayments on loan_repayments.Loan_rep_mobile = loan_application.Loan_mobile where loan_mobile = '$username' group by loan_rep_mobile");
			while ($row = mysql_fetch_array($result))
			{
				$loan_amount = $row['loan_amount'];
				$loan_repay = $row['loan_repay'];
			
				?>
					['June', <?php echo $loan_amount ?>, <?php echo $loan_repay ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Loan Amount',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('loans_tracking'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'link', 'Revenue', { role: 'annotation' }],
        	<?php
			$result = mysql_query("select distinct EXTRACT(Month FROM loan_rep_date)month, sum(loan_rep_amount)revenue from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '$filter_year' and loan_schedule.Loan_Sched_Type = '3' group by EXTRACT(Month FROM loan_rep_date)");
			while ($row = mysql_fetch_array($result))
			{
				$month = $row['month'];
				$revenue = $row['revenue'];
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
			
				?>
					['<?php echo $month_name ?>', 'financial_summary.php?month=<?php echo $month ?>&title=Principal Collected Day Comparison', <?php echo $revenue?>, '<?php echo $revenue?>'],
				<?php
			}
		?>
       
        ]);
        
        var view = new google.visualization.DataView(data);
      	view.setColumns([0, 2]);

        var options = {
        	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Revenue Collected',  titleTextStyle: {color: '#333'}},
        };
        	
        var chart = new google.visualization.ColumnChart(document.getElementById('revenue_collected'));
        chart.draw(view, options);
        	
        var selectHandler = function(e) {
        	window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
       	}
       		
       	google.visualization.events.addListener(chart, 'select', selectHandler);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'Loan Amount'],
        	<?php
			$result = mysql_query("select distinct loan_rep_date, sum(loan_rep_amount)revenue from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '$filter_year' and EXTRACT(month FROM loan_rep_date) = '$month_drill' and loan_schedule.Loan_Sched_Type = '3' group by loan_rep_date order by loan_rep_date asc");
			while ($row = mysql_fetch_array($result))
			{
				$loan_rep_date = $row['loan_rep_date'];
				$revenue = $row['revenue'];
			
				?>
					['<?php echo $loan_rep_date ?>', <?php echo $revenue ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Revenue Collected',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('revenue_collected_daily'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'link', 'Commissions', { role: 'annotation' }],
        	<?php
			$result = mysql_query("select distinct EXTRACT(Month FROM com_date)month, sum(com_amount)commissions from commissions where EXTRACT(year FROM com_date) = '$filter_year'  group by EXTRACT(Month FROM com_date)");
			while ($row = mysql_fetch_array($result))
			{
				$month = $row['month'];
				$commissions = $row['commissions'];
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
			
				?>
					['<?php echo $month_name ?>', 'financial_summary.php?month=<?php echo $month ?>&title=Commissions Generated Day Comparison', <?php echo $commissions?>, '<?php echo $commissions?>'],
				<?php
			}
		?>
       
        ]);
        
        var view = new google.visualization.DataView(data);
      	view.setColumns([0, 2]);

        var options = {
        	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Commissions',  titleTextStyle: {color: '#333'}},
        };
        	
        var chart = new google.visualization.ColumnChart(document.getElementById('commissions'));
        chart.draw(view, options);
        	
        var selectHandler = function(e) {
        	window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
       	}
       		
       	google.visualization.events.addListener(chart, 'select', selectHandler);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'Commissions'],
        	<?php
			$result = mysql_query("select distinct com_date, sum(com_amount)commissions from commissions where EXTRACT(year FROM com_date) = '$filter_year' and EXTRACT(month FROM com_date) = '$month_drill' group by com_date");
			while ($row = mysql_fetch_array($result))
			{
				$com_date = $row['com_date'];
				$commissions = $row['commissions'];

				?>
					['<?php echo $com_date ?>', <?php echo $commissions ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Commissions',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('commissions_daily'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'link', 'Loan Amount', { role: 'annotation' }],
        	<?php
			$result = mysql_query("select distinct EXTRACT(Month FROM Loan_Sched_Due_Date)month, sum(Loan_Sched_Due_Amount)due_amount from loan_schedule where EXTRACT(year FROM Loan_Sched_Due_Date) = '$filter_year' and Loan_Sched_Type = '3' and Loan_Sched_Paid_Amount = '0' group by EXTRACT(Month FROM Loan_Sched_Due_Date)");
			while ($row = mysql_fetch_array($result))
			{
				$month = $row['month'];
				$due_amount = $row['due_amount'];
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
			
				?>
					['<?php echo $month_name ?>', 'financial_summary.php?month=<?php echo $month ?>&title=Overdue Loan Balances Day Comparison', <?php echo $due_amount?>, '<?php echo $due_amount?>'],
				<?php
			}
		?>
       
        ]);
        
        var view = new google.visualization.DataView(data);
      	view.setColumns([0, 2]);

        var options = {
        	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Overdue Balances',  titleTextStyle: {color: '#333'}},
        };
        	
        var chart = new google.visualization.ColumnChart(document.getElementById('overdue_balances'));
        chart.draw(view, options);
        	
        var selectHandler = function(e) {
        	window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
       	}
       		
       	google.visualization.events.addListener(chart, 'select', selectHandler);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'Amount'],
        	<?php
			$result = mysql_query("select distinct Loan_Sched_Due_Date, sum(Loan_Sched_Due_Amount)due_amount from loan_schedule where EXTRACT(year FROM Loan_Sched_Due_Date) = '$filter_year' and EXTRACT(month FROM Loan_Sched_Due_Date) = '$month_drill' and Loan_Sched_Type = '3' and Loan_Sched_Paid_Amount = '0' group by Loan_Sched_Due_Date");
			while ($row = mysql_fetch_array($result))
			{
				$Loan_Sched_Due_Date = $row['Loan_Sched_Due_Date'];
				$due_amount = $row['due_amount'];
			
				?>
					['<?php echo $Loan_Sched_Due_Date ?>', <?php echo $due_amount ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'OverDue Loan Balances',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('overdue_balances_daily'));
        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'link', 'Defaulters', { role: 'annotation' }],
        	<?php
			$result = mysql_query("select distinct EXTRACT(Month FROM Loan_Sched_Due_Date)month, count(Loan_Sched_Due_Date)members from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where EXTRACT(year FROM Loan_Sched_Due_Date) = '$filter_year' and Loan_Sched_Paid_Amount = '0' group by EXTRACT(Month FROM Loan_Sched_Due_Date)");
			while ($row = mysql_fetch_array($result))
			{
				$month = $row['month'];
				$members = $row['members'];
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
			
				?>
					['<?php echo $month_name ?>', 'financial_summary.php?month=<?php echo $month ?>&title=Defaulters Day Comparison', <?php echo $members?>, '<?php echo $members?>'],
				<?php
			}
		?>
       
        ]);
        
        var view = new google.visualization.DataView(data);
      	view.setColumns([0, 2]);

        var options = {
        	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Defaulters',  titleTextStyle: {color: '#333'}},
        };
        	
        var chart = new google.visualization.ColumnChart(document.getElementById('defaulters'));
        chart.draw(view, options);
        	
        var selectHandler = function(e) {
        	window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
       	}
       		
       	google.visualization.events.addListener(chart, 'select', selectHandler);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'Loan Amount'],
        	<?php
			$result = mysql_query("select distinct Loan_Sched_Due_Date, count(Loan_Sched_Due_Date)members from loan_schedule inner join loan_application on loan_application.Loan_id = loan_schedule.Loan_Sched_Loan_ID where EXTRACT(year FROM Loan_Sched_Due_Date) = '$filter_year' and EXTRACT(month FROM Loan_Sched_Due_Date) = '$month_drill' and Loan_Sched_Paid_Amount = '0' group by Loan_Sched_Due_Date");
			while ($row = mysql_fetch_array($result))
			{
				$Loan_Sched_Due_Date = $row['Loan_Sched_Due_Date'];
				$members = $row['members'];
			
				?>
					['<?php echo $Loan_Sched_Due_Date ?>', <?php echo $members ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Defaulters',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('defaulters_daily'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'link', 'Interest', { role: 'annotation' }],
        	<?php
			$result = mysql_query("select distinct EXTRACT(Month FROM loan_rep_date)month, sum(loan_rep_amount)interest from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '$filter_year' and loan_schedule.Loan_Sched_Type = '1' group by EXTRACT(Month FROM loan_rep_date)");
			while ($row = mysql_fetch_array($result))
			{
				$month = $row['month'];
				$interest = $row['interest'];
				//$commissions = $row['commissions'];
				$result_tender = mysql_query("select month from calender where id = '$month'");
				while ($row = mysql_fetch_array($result_tender))
				{
					$month_name = $row['month'];
				}
			
				?>
					//['<?php echo $month_name ?>', <?php echo $interest ?>],
					['<?php echo $month_name ?>', 'financial_summary.php?month=<?php echo $month ?>&title=Interest Day Comparison', <?php echo $interest?>, '<?php echo $interest?>'],
				<?php
			}
		?>
       
        ]);
        
        var view = new google.visualization.DataView(data);
      	view.setColumns([0, 2]);

        var options = {
        	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Interest',  titleTextStyle: {color: '#333'}},
        };
        	
        var chart = new google.visualization.ColumnChart(document.getElementById('interest'));
        chart.draw(view, options);
        	
        var selectHandler = function(e) {
        	window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
       	}
       		
       	google.visualization.events.addListener(chart, 'select', selectHandler);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
        	['Month', 'Interest'],
        	<?php
			$result = mysql_query("select distinct loan_rep_date, sum(loan_rep_amount)interest from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '$filter_year' and EXTRACT(month FROM loan_rep_date) = '$month_drill' and  loan_schedule.Loan_Sched_Type = '1' group by loan_rep_date");
			while ($row = mysql_fetch_array($result))
			{
				$loan_rep_date = $row['loan_rep_date'];
				$interest = $row['interest'];
			
				?>
					['<?php echo $loan_rep_date ?>', <?php echo $interest ?>],
				<?php
			}
		?>
       
        ]);

        var options = {
         	backgroundColor: '#F8F2F2',
    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
    		hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
		vAxis: {title: 'Interest',  titleTextStyle: {color: '#333'}},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('interest_daily'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        	// Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
			['Month', 'Loans', 'Loan Repayments',  'Interest'],
			<?php
				$result = mysql_query("select distinct EXTRACT(Month FROM loan_date)month, sum(loan_amount)loans, (select sum(loan_rep_amount)repay from loan_repayments where EXTRACT(year FROM loan_rep_date) = '$filter_year')loan_repay, (select sum(loan_rep_amount)interest from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '$filter_year' and loan_schedule.Loan_Sched_Type = '1')interest from loan_application where EXTRACT(year FROM loan_date) = '$filter_year'");
				while ($row = mysql_fetch_array($result))
				{
					$month = $row['month'];
					$loans = $row['loans'];
					$loan_repay = $row['loan_repay'];
					$interest = $row['interest'];
					$result_tender = mysql_query("select month from calender where id = '$month'");
					while ($row = mysql_fetch_array($result_tender))
					{
						$month_name = $row['month'];
					}
			
					?>
						['<?php echo $month_name ?>',  <?php echo $loans ?>, <?php echo $loan_repay ?>, <?php echo $interest ?>],
					<?php
				}
			?>
        	]);

        	var options = {
		  	backgroundColor: '#F8F2F2',
	    		chartArea:{left:70, top:10, width:'90%', height:'80%'},
	    		hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
			vAxis: {title: 'Loans, Repayments and Interest',  titleTextStyle: {color: '#333'}},
		  	seriesType: "Line",
		  	series: {2: {type: "Bar"}}
		};

        	//var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        		chart.draw(data, options);
      		}
      		google.setOnLoadCallback(drawVisualization);
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
		  	//['Director (Year)',  'Rotten Tomatoes', 'IMDB'],
		  	['Month', 'Loans', 'Loan Repayments',  'Interest'],
		  	//['Alfred Hitchcock (1935)', 8.4,         7.9],
		  	//['Ralph Thomas (1959)',     6.9,         6.5],
		  	//['Don Sharp (1978)',        6.5,         6.4],
		  	//['James Hawes (2008)',      4.4,         6.2]
		  	<?php
				$result = mysql_query("select distinct EXTRACT(Month FROM loan_date)month, sum(loan_amount)loans, (select sum(loan_rep_amount)repay from loan_repayments where EXTRACT(year FROM loan_rep_date) = '$filter_year')loan_repay, (select sum(loan_rep_amount)interest from loan_repayments inner join loan_schedule on loan_schedule.Loan_Sched_ID = loan_repayments.Loan_Rep_Sched_ID where EXTRACT(year FROM loan_rep_date) = '$filter_year' and loan_schedule.Loan_Sched_Type = '1')interest from loan_application where EXTRACT(year FROM loan_date) = '$filter_year'");
				while ($row = mysql_fetch_array($result))
				{
					$month = $row['month'];
					$loans = $row['loans'];
					$loan_repay = $row['loan_repay'];
					$interest = $row['interest'];
					$result_tender = mysql_query("select month from calender where id = '$month'");
					while ($row = mysql_fetch_array($result_tender))
					{
						$month_name = $row['month'];
					}
			
					?>
						['<?php echo $month_name ?>',  <?php echo $loans ?>, <?php echo $loan_repay ?>, <?php echo $interest ?>],
					<?php
				}
			?>
		]);

        	var options = {
		  	isStacked: true,
		  	backgroundColor: '#F8F2F2',  
		 	chartArea:{left:70, top:10, width:'90%', height:'80%'},
		 	hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
			vAxis: {title: 'Loans, Repayments and Interest',  titleTextStyle: {color: '#333'}},
        	};

        	var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div'));
        	chart.draw(data, options);
      }
    </script>


