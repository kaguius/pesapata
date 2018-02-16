<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title><?php echo $page_title ?> | Virtual City Hewani System&#x2122;</title>
		<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Simonetta' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/demo_page.css" />
		<link rel="stylesheet" type="text/css" href="css/demo_table.css" />
		<script type="text/javascript" language="javascript" src="js/tables/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/tables/jquery.dataTables.js"></script>
		<script type="text/javascript" src="j/jquery.min.js"></script>
		<script type="text/javascript" src="js/raphael.js"></script>
		<script type="text/javascript" src="js/jquery.enumerable.js"></script>
		<script type="text/javascript" src="js/jquery.tufte-graph.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

		<script src="jsprototype.js" type="text/javascript"></script>
		<script src="js/excanvas.js" type="text/javascript"></script>
		<script src="js/plotr.js" type="text/javascript"></script>
		<script src="js/gen_validatorv4.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable();
				$('#example2').dataTable();
			} );
		</script>
		<link rel="stylesheet" href="css/basic.css" type="text/css" />
		<link rel="stylesheet" href="css/galleriffic-2.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
		<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
		<!-- We only want the thunbnails to display when javascript is disabled -->
		<script type="text/javascript">
			document.write('<style>.noscript { display: none; }</style>');
		</script>
		<!-- Menu Files -->
		<link type="text/css" href="menu.css" rel="stylesheet" />
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="menu.js"></script>

		<link href="css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet">
		
		<script src="j/jquery-1.8.3.js"></script>
		<script src="js/jquery-ui-1.9.2.custom.js"></script>

		<script>
		$(function() {
		
			$( "#accordion" ).accordion();
		

		
			var availableTags = [
				"ActionScript",
				"AppleScript",
				"Asp",
				"BASIC",
				"C",
				"C++",
				"Clojure",
				"COBOL",
				"ColdFusion",
				"Erlang",
				"Fortran",
				"Groovy",
				"Haskell",
				"Java",
				"JavaScript",
				"Lisp",
				"Perl",
				"PHP",
				"Python",
				"Ruby",
				"Scala",
				"Scheme"
			];
			$( "#autocomplete" ).autocomplete({
				source: availableTags
			});
		

		
			$( "#button" ).button();
			$( "#button2" ).button();
			$( "#radioset" ).buttonset();
		

		
			$( "#tabs" ).tabs();
		

		
			$( "#dialog" ).dialog({
				autoOpen: false,
				width: 400,
				buttons: [
					{
						text: "Ok",
						click: function() {
							$( this ).dialog( "close" );
						}
					},
					{
						text: "Cancel",
						click: function() {
							$( this ).dialog( "close" );
						}
					}
				]
			});

			// Link to open the dialog
			$( "#dialog-link" ).click(function( event ) {
				$( "#dialog" ).dialog( "open" );
				event.preventDefault();
			});
		

		
			$( "#datepicker" ).datepicker({
				inline: true
			});
			$( "#report_start_date" ).datepicker({
				inline: true
			});
			$( "#report_end_date" ).datepicker({
				inline: true
			});

			$( "#birth_date" ).datepicker({
				inline: true
			});
			$( "#lease_end_date" ).datepicker({
				inline: true
			});

			$( "#trans_date" ).datepicker({
				inline: true
			});
		

		
			$( "#slider" ).slider({
				range: true,
				values: [ 17, 67 ]
			});
		

		
			$( "#progressbar" ).progressbar({
				value: 20
			});
		

			// Hover states on the static widgets
			$( "#dialog-link, #icons li" ).hover(
				function() {
					$( this ).addClass( "ui-state-hover" );
				},
				function() {
					$( this ).removeClass( "ui-state-hover" );
				}
			);
		});
		</script>

	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<h1><a href="#">Virtual City Hewani System&#x2122;</a></h1>
				</div>
				<?php
					include_once('includes/menu.php');
				?>
			</div>
