<?php

include('checklogin.php');

$type = $_REQUEST['type'];
$username = $_REQUEST['user'];


if ($type == "daily") {
	daily($username);
} else if ($type == "monthly") {
	monthly($username);
} else if ($type == "yearly") {
	yearly($username);
}else {

}



function daily($username) {

	
	include 'opendb.php';
	include 'libchart/libchart.php';

	$username = $dbSocket->escapeSimple($username);
	

	$sql = "SELECT  count(AcctStartTime) AS count, DAY(AcctStartTime) AS Day FROM ".
		$configValues['CONFIG_DB_TBL_RADACCT']." WHERE username='$username' AND acctstoptime>0 GROUP BY Day;";
	$result = $dbSocket->query($sql);

	$rows = array();
	while ($row = $result->fetchRow(PDO::FETCH_ASSOC)) {
		 
		  $rows[] = [(int)$row['count'], (int)$row['Day'] ] ;
	}

	echo json_encode($rows);
	

	include 'closedb.php';

}

function monthly($username) {

	
	include 'opendb.php';
	include 'libchart/libchart.php';

	$username = $dbSocket->escapeSimple($username);
	
	header("Content-type: image/png");

	$chart = new VerticalChart(680,500);

	$sql = "SELECT UserName, count(AcctStartTime), MONTHNAME(AcctStartTime) AS Month FROM ".
		$configValues['CONFIG_DB_TBL_RADACCT']." WHERE username='$username' GROUP BY Month;";
	$res = $dbSocket->query($sql);


	while($row = $res->fetchRow()) {
		$chart->addPoint(new Point("$row[2]", "$row[1]"));
	}

	$chart->setTitle("Total Users");
	$chart->render();

	include 'closedb.php';
}


function yearly($username) {


	include 'opendb.php';
	include 'libchart/libchart.php';
	
	$username = $dbSocket->escapeSimple($username);

	header("Content-type: image/png");

	$chart = new VerticalChart(680,500);

	$sql = "SELECT UserName, count(AcctStartTime), YEAR(AcctStartTime) AS Year FROM ".
		$configValues['CONFIG_DB_TBL_RADACCT']." WHERE username='$username' GROUP BY Year;";
	$res = $dbSocket->query($sql);

	while($row = $res->fetchRow()) {
		$chart->addPoint(new Point("$row[2]", "$row[1]"));
	}

	$chart->setTitle("Total Users");
	$chart->render();

	include 'closedb.php';

}

?>
