<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


include ("checklogin.php");
include 'opendb.php';





$sql = "SELECT COUNT(DISTINCT(UserName)) from ".$configValues['CONFIG_DB_TBL_RADCHECK'].";";
$res = $dbSocket->query($sql);



$array_users = array();

while($row = $res->fetchRow()) {
	$array_users['users'] = $row[0];
}
// return the number of users in the radcheck table json encoded
echo json_encode($array_users);


include 'closedb.php';


?>


