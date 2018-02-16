<?php
	$userid = "";
	$adminstatus = 3;
	$property_manager_id = "";
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
	}
	include_once('includes/db_conn.php');
	$expense_month = date("m");
	$expense_year = date("Y");
	if (!empty($_GET)){	
		$filter_start_date = $_GET['report_start_date'];
		$filter_start_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_start_date)));
		$filter_end_date = $_GET['report_end_date'];
		$filter_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $filter_end_date)));
		$filter_quarry = $_GET['quarry'];
		$filter_parking = $_GET['parking'];
		$filter_clerk = $_GET['clerk'];
		$filter_market_type = $_GET['market_type'];
	}
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
          	['Clerk', 'link', 'Revenue', { role: 'annotation' }],
          	<?php
			$result_tender = mysql_query("SELECT DISTINCT clerk, SUM(invoice_amount)invoice_amount FROM ".$filter_parking."_parking.statements WHERE paid_date between '$filter_start_date' and '$filter_end_date' and status = 'Paid' GROUP BY clerk;");
			echo "";
			$intcount = 0;
			$data_count_total = 0;
			while ($row = mysql_fetch_array($result_tender))
			{
				$intcount++;
				$clerk = $row['clerk'];
				$invoice_amount = $row['invoice_amount'];
				$clerk = ucwords(strtolower($clerk));
				?>
					  //['<?php echo $clerk ?>',  <?php echo $invoice_amount?>, '<?php echo $invoice_amount?>'],
					  ['<?php echo $clerk ?>',  'parking_dashboard.php?parking=<?php echo $filter_parking ?>&clerk=<?php echo $clerk ?>&report_start_date=<?php echo $filter_start_date ?>&report_end_date=<?php echo $filter_end_date ?>', <?php echo $invoice_amount?>, '<?php echo $invoice_amount?>'],
				<?php
			}
		?>
        ]);
        	
        	var view = new google.visualization.DataView(data);
      		view.setColumns([0, 2]);

        	var options = {
          		legend: { position: 'top' },
    			backgroundColor: '#F0F1F1',
    			chartArea:{left:100,top:10,width:'90%',height:'80%'},
    			hAxis: {title: 'Clerk',  titleTextStyle: {color: '#000A8B'}},
			vAxis: {title: 'Revenue',  titleTextStyle: {color: '#000A8B'}},
        	};
        	
        	var chart = new google.visualization.LineChart(document.getElementById('models_tracking'));
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
          	['Market Fee Type', 'link', 'Revenue', { role: 'annotation' }],
          	<?php
			$result_tender = mysql_query("SELECT DISTINCT product, SUM(invoice_amount)invoice_amount FROM ".$filter_parking."_parking.statements WHERE paid_date between '$filter_start_date' and '$filter_end_date' and status = 'Paid' GROUP BY product ORDER BY product ASC");
			while ($row = mysql_fetch_array($result_tender))
			{
				$intcount++;
				$product = $row['product'];
				$invoice_amount = $row['invoice_amount'];
				$product_label = '<a href = "#">'.$product.'</a>';
				?>
					['<?php echo $product ?>',  'parking_dashboard.php?parking=<?php echo $filter_parking ?>&market_type=<?php echo $product ?>&report_start_date=<?php echo $filter_start_date ?>&report_end_date=<?php echo $filter_end_date ?>', <?php echo $invoice_amount?>, '<?php echo $invoice_amount?>'],
				<?php
			}
		?>
        ]);

        	var view = new google.visualization.DataView(data);
      		view.setColumns([0, 2]);

        	var options = {
          		legend: { position: 'top' },
    			backgroundColor: '#F0F1F1',
    			chartArea:{left:70,top:10,width:'90%',height:'75%'},
    			hAxis: {title: 'Market Fee Types',  titleTextStyle: {color: '#000A8B'}},
			vAxis: {title: 'Revenue',  titleTextStyle: {color: '#000A8B'}},
        	};
        	
        	var chart = new google.visualization.ColumnChart(document.getElementById('payments_tracking'));
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
          	['Clerk', 'Revenue', { role: 'annotation' }],
          	<?php
			$result_tender = mysql_query("SELECT DISTINCT paid_date, SUM(invoice_amount)invoice_amount FROM ".$filter_parking."_parking.statements where paid_date between '$filter_start_date' and '$filter_end_date' and clerk='$filter_clerk' and status = 'Paid' GROUP BY paid_date order by paid_date asc");
			while ($row = mysql_fetch_array($result_tender))
			{
				$intcount++;
				$paid_date = $row['paid_date'];
				$paid_date = date("d M, Y", strtotime($paid_date));
				$invoice_amount = $row['invoice_amount'];
				?>
					  ['<?php echo $paid_date ?>', <?php echo $invoice_amount?>, '<?php echo $invoice_amount?>'],
				<?php
			}
		?>
        ]);
        
        	var options = {
          		egend: { position: 'top' },
    			backgroundColor: '#F0F1F1',
    			chartArea:{left:70,top:10,width:'90%',height:'75%'},
    			hAxis: {title: 'Day',  titleTextStyle: {color: '#000A8B'}},
			vAxis: {title: 'Revenue',  titleTextStyle: {color: '#000A8B'}},
        	};

        	var chart = new google.visualization.ColumnChart(document.getElementById('parking_revenue_clerk'));
        	chart.draw(data, options);

        	
      }
</script>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        	var data = google.visualization.arrayToDataTable([
          	['Parking Fee Type', 'Revenue', { role: 'annotation' }],
          	<?php
			$result_tender = mysql_query("SELECT DISTINCT paid_date, SUM(invoice_amount)invoice_amount FROM ".$filter_parking."_parking.statements where paid_date between '$filter_start_date' and '$filter_end_date' and product='$filter_market_type' and status = 'Paid' GROUP BY paid_date order by paid_date asc");
			while ($row = mysql_fetch_array($result_tender))
			{
				$intcount++;
				$paid_date = $row['paid_date'];
				$paid_date = date("d M, Y", strtotime($paid_date));
				$invoice_amount = $row['invoice_amount'];
				?>
					  ['<?php echo $paid_date ?>', <?php echo $invoice_amount?>, '<?php echo $invoice_amount?>'],
				<?php
			}
		?>
        ]);
        
        	var options = {
          		egend: { position: 'top' },
    			backgroundColor: '#F0F1F1',
    			chartArea:{left:70,top:10,width:'90%',height:'75%'},
    			hAxis: {title: 'Day',  titleTextStyle: {color: '#000A8B'}},
			vAxis: {title: 'Revenue',  titleTextStyle: {color: '#000A8B'}},
        	};

        	var chart = new google.visualization.ColumnChart(document.getElementById('parking_revenue_product'));
        	chart.draw(data, options);

        	
      }
</script>
