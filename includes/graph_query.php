<?php
	include_once('includes/db_conn.php');
	
    	$sql = "DROP TABLE juja_market_fees.statement_report;";
	$result = mysql_query($sql);
	$sql = "DROP TABLE thika_market_fees.statement_report;";
	$result = mysql_query($sql);
    	$sql2 = "CREATE TABLE juja_market_fees.statement_report(invoice_month float, invoice_amount float);";
	$result2 = mysql_query($sql2);
	$sql3 = "INSERT INTO juja_market_fees.statement_report (invoice_month, invoice_amount) 
	select EXTRACT(MONTH FROM paid_date)invoice_month, sum(invoice_amount)invoice_amount from juja_market_fees.statements where EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' group by EXTRACT(MONTH FROM paid_date);";
	$result3 = mysql_query($sql3);
	$sql4 = "INSERT INTO juja_market_fees.statement_report (invoice_month, invoice_amount)
	select EXTRACT(MONTH FROM paid_date)invoice_month, sum(invoice_amount)invoice_amount from juja_quarry.statements where EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' group by EXTRACT(MONTH FROM paid_date);";
	$result4 = mysql_query($sql4);
	$sql5="INSERT INTO juja_market_fees.statement_report (invoice_month, invoice_amount)
select EXTRACT(MONTH FROM paid_date)invoice_month, sum(invoice_amount)invoice_amount from kiambu_market_fees.statements where EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' group by EXTRACT(MONTH FROM paid_date);";
	$result5 = mysql_query($sql5);
	$sql6="INSERT INTO juja_market_fees.statement_report (invoice_month, invoice_amount)
	select EXTRACT(MONTH FROM paid_date)invoice_month, sum(invoice_amount)invoice_amount from ruiru_market_fees.statements where EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' group by EXTRACT(MONTH FROM paid_date);";
	$result6 = mysql_query($sql6);
	$sql7="INSERT INTO juja_market_fees.statement_report (invoice_month, invoice_amount)
	select EXTRACT(MONTH FROM paid_date)invoice_month, sum(invoice_amount)invoice_amount from thika_market_fees.statements where EXTRACT(YEAR FROM paid_date) = '$filter_year' and status = 'Paid' group by EXTRACT(MONTH FROM paid_date);";
	$result7 = mysql_query($sql7);
?>
