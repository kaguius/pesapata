<?php
	$userid = "";
	$adminstatus = "";
	session_start();
	if (!empty($_SESSION)){
		$userid = $_SESSION["userid"] ;
		$adminstatus = $_SESSION["adminstatus"] ;
	}
?>
<div id="menu">
	<ul>
		<li><a href="dashboard.php" title="System Dashboard">Dashboard</a></li>
		<li><a href="by_clerk.php" title="By Clerk Report">By Clerk</a></li>
		<li><a href="by_market.php" title="By Market Report">By Market</a></li>
		<li><a href="by_market_fee_type.php" title="By Market Fee Type Report">By Market Fee Type</a></li>
		<!--<li><a href="maps.php" title="Map">Map</a></li>
		<!--<li><a href="gallery.php" title="Reports">Gallery</a></li>			-->
		<!--<li><a href="resources.php" title="Resources">Resources</a></li>
		<li><a href="admin.php" title="Admin">Admin</a></li>-->
		<li><a href="logout.php" title="Log Out">Log Out</a></li>
	</ul>
	<br class="clearfix" />
</div>
