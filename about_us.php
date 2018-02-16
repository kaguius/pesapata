<?php
	$userid = "";
	$adminstatus = 4;
	$property_manager_id = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
		$station = $_SESSION["station"] ;
		$username = $_SESSION["username"];
	}

	//if($adminstatus != 1 || $adminstatus != 2 || $adminstatus != 4){
	if($adminstatus == 4){
		include_once('includes/header.php');
		?>
		<script type="text/javascript">
			document.location = "login.php";
		</script>
		<?php
	}
	else{
		$transactiontime = date("Y-m-d G:i:s");
		$page_title = "About Paddy Micro Inverstments";
		include_once('includes/header.php');
		?>		
		<div id="page">
			<div id="content">
				<div class="post">
					<h2><?php echo $page_title ?></h2>
					<p>Paddy Micro Investments Limited is a micro finance organization that seeks to empower the poor by providing customized and affordable financial solutions. Specifically, we aim to assist economically active entrepreneurs earning low incomes to achieve sustainable economic development.At Paddy we are dedicated to strengthening corporate responsibility, building public trust, and making a positive impact to our community.</p>
					<h2>Our Products</h2>
					<h3>MOBIKOPA</h3>
					<p>An online interactive easy and hustle free way of acquiring your loan. <a href="http://www.paddymicro.co.ke/mobikopa" target="_blank">Read More...</a></p>
					<h3>PESA PATA</h3>
					<p>Loan designed for ordinary Kenyan available in the form of a scratch card. <a href="http://www.paddymicro.co.ke/pesa-pata" target="_blank">Read More...</a></p>
					<h3>MAISHA LOAN</h3>
					<p>Business loan to increase your stock in order to subsequently boost your business. <a href="http://www.paddymicro.co.ke/maisha-loan" target="_blank">Read More...</a></p>
					<h3>MWAMBA LOAN</h3>
					<p>This is a group loan designed to finance individual business growth. <a href="http://www.paddymicro.co.ke/mwamba-loan" target="_blank">Read More...</a></p>
					<h3>KOPESHA KODI</h3>
					<p>This is a loan offered to assist tenants meet their rental obligations. <a href="www.paddymicro.co.ke/kopesha-kodi-loan" target="_blank">Read More...</a></p>
					<h3>AGENCY LOAN</h3>
					<p>This is given to people who normally get goods from the agent to pay at a latter date. <a href="http://www.paddymicro.co.ke/agency-loan" target="_blank">Read More...</a></p>
				</div>
			</div>
			<br class="clearfix" />
			</div>
		</div>
<?php
	}
	include_once('includes/footer.php');
?>
