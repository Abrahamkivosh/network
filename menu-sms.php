 
<body>
<?php
    include_once ("lang/main.php");
?>

<div id="wrapper">
<div id="innerwrapper">

<?php
    $m_active = "SMS";
    include_once ("include/menu/menu-items.php");
	include_once ("include/menu/help-subnav.php");
?>

<div id="sidebar">

	<h2>SMS</h2>

	
	<ul class="subnav">

		<li><a href="rep-stat-server.php"><b>&raquo;</b><?php echo t('button','ServerStatus') ?></a></li>
		<li><a href="rep-stat-services.php"><b>&raquo;</b><?php echo t('button','ServicesStatus') ?></a></li>
		<li><a href="rep-lastconnect.php"><b>&raquo;</b><?php echo t('button','LastConnectionAttempts') ?></a></li>

	<h3>Logs</h3>

	        <li><a href="rep-logs-radius.php"><b>&raquo;</b><?php echo t('button','RadiusLog') ?></a></li>
	        <li><a href="rep-logs-system.php"><b>&raquo;</b><?php echo t('button','SystemLog') ?></a></li>

	</ul>



</div>
		
