<?php
/*********************************************************************
* Name: actionMessages.php
* Author: Liran tal <liran.tal@gmail.com>
*
* This file provides control for messages that are printed to the
* screen in reply to actions such as applying forms, saving data,
* removing data and such.
*
*********************************************************************/
if (isset($_GET['failureMsg'])) {
	# code...
	$failureMsg = $_GET['failureMsg'] ;
}

if ( isset($_GET['successMsg'])) {
	# code...
	$successMsg = $_GET['successMsg'] ;
}


if ((isset($failureMsg)) && ($failureMsg != "")) {
	echo "<div class='failure'>
		$failureMsg
	</div>
	";
}


if ((isset($successMsg)) && ($successMsg != "")) {
	echo "<div class='success'>
		$successMsg
	</div>
	";
}

