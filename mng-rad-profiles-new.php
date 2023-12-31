<?php
/*
 *********************************************************************************************************
 * daloRADIUS - RADIUS Web Platform
 * Copyright (C) 2007 - Liran Tal <liran@enginx.com> All Rights Reserved.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 *********************************************************************************************************
 *
 * Authors:	Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
	include_once('lang/main.php');

	include('library/check_operator_perm.php');
	include_once ("library/functions.php") ;
	include 'library/opendb.php';

	// declaring variables
	//	isset($_GET['profile']) ? $group = $_GET['profile'] : $profile = "";

	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST['submit'])) {
	
	
		$profile = $_POST['profile'];
		$netWorkLimit = $_POST['netWorkLimit'];
		$profile = trim($profile);
		$netWorkLimit = floatval($netWorkLimit);

		// convert network limit to bits from Mbps
		$netWorkLimit = $netWorkLimit * 1000000;

		// add Service-Type  := Framed-User to radgroupcheck
		addRadGroupAttribute($dbSocket, $profile, 'Service-Type', ':=', 'Framed-User', 'check');
		// add Framed-Protocol := PPP to radgroupcheck
		addRadGroupAttribute($dbSocket, $profile, 'Framed-Protocol', ':=', 'PPP', 'check');
		// add Framed-Compression := Van-Jacobson-TCP-IP to radgroupcheck  It is used to specify the compression protocol to be used for the user's calls. 
		// Compression is negotiated between the NAS and the user's PPP server.
		// Compression Help In 
		addRadGroupAttribute($dbSocket, $profile, 'Framed-Compression', ':=', 'Van-Jacobson-TCP-IP', 'check');
		
		// add  Ascend-Data-Rate := 64000 to radgroupreply It is used to specify the maximum transmit rate for the user's calls In bits per second.
		addRadGroupAttribute($dbSocket, $profile, 'Ascend-Data-Rate', ':=', $netWorkLimit, 'reply');
		// add  Ascend-Xmit-Rate := 64000 to radgroupreply It is used to specify the maximum transmit rate for the user's calls In bits per second.
		addRadGroupAttribute($dbSocket, $profile, 'Ascend-Xmit-Rate', ':=', $netWorkLimit, 'reply');
		// add  Ascend-Data-Filter := "ip" to radgroupreply It is used to specify the type of data filtering to be performed on the user's calls.
		// addRadGroupAttribute($dbSocket, $profile, 'Ascend-Data-Filter', ':=', 'ip', 'reply');

		// add  Ascend-Call-Filter := "ip" to radgroupreply It is used to specify the type of call filtering to be performed on the user's calls.
		// addRadGroupAttribute($dbSocket, $profile, 'Ascend-Call-Filter', ':=', 'ip', 'reply');
		
		// $skipLoopFlag = 0;				// flag to skip loop
		// if ($profile != "") {

		// 	include 'library/opendb.php';
			

		// 	$attrCount = 0;					// counter for number of attributes
		// 	foreach($_POST as $element=>$field) { 
				
		// 		switch ($element) {
		// 			case "submit":
		// 			case "profile":
		// 					$skipLoopFlag = 1; 
		// 					break;
		// 		}
		
		// 		if ($skipLoopFlag == 1) {
		// 			$skipLoopFlag = 0;             
		// 			continue;
		// 		}

		// 		if (isset($field[0]))
		// 			$attribute = $field[0];
		// 		if (isset($field[1]))
		// 			$value = $field[1];
		// 		if (isset($field[2]))
		// 			$op = $field[2];
		// 		if (isset($field[3]))
		// 			$table = $field[3];

		// 		if ($table == 'check')
		// 			$table = $configValues['CONFIG_DB_TBL_RADGROUPCHECK'];
		// 		if ($table == 'reply')
		// 			$table = $configValues['CONFIG_DB_TBL_RADGROUPREPLY'];


		// 		if (!($value) || $table == '')
		// 			continue;
		// 		print_r($field);
		// 		exit;

		// 		$sql = "INSERT INTO $table (id,GroupName,Attribute,op,Value) ".
		// 				" VALUES (0, '".$dbSocket->escapeSimple($profile)."', '".
		// 				$dbSocket->escapeSimple($attribute)."','".$dbSocket->escapeSimple($op)."', '".
		// 				$dbSocket->escapeSimple($value)."')  ";
		// 		$res = $dbSocket->query($sql);
		// 		$logDebugSQL .= $sql . "\n";

		// 		$attrCount++;				// increment attribute count

		// 	}

		// 	if ($attrCount == 0) {
		// 		$failureMsg = "Failed adding profile name [$profile] - no attributes where provided by user";
		// 		$logAction .= "Failed adding profile name [$profile] - no attributes where provided by user on page: ";
		// 	} else {
		// 		$successMsg = "Added to database new profile: <b> $profile </b>";
		// 		$logAction .= "Successfully added new profile [$profile] on page: ";
		// 	}

		// 	include 'library/closedb.php';

		// } else { // if $profile != ""
		// 	$failureMsg = "profile name is empty";
		// 	$logAction .= "Failed adding (possibly empty) profile name [$profile] on page: ";
		// }
		include 'library/closedb.php';
	}
	
	include_once('library/config_read.php');
    $log = "visited page: ";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/dynamic_attributes.js"></script>

<title>
<?php echo $configValues['SYSTEM_NAME'] ?> - <?php echo t('title','mngProfileNew') ?>
</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
</head>
 
<?php
	include ("menu-mng-rad-profiles.php");
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradprofilesnew.php') ?>
				<h144>&#x2754;</h144></a></h2>


				<div id="helpPage" style="display:none;visibility:visible" >				
					<?php echo t('helpPage','mngradprofilesnew') ?>
					<br/>
				</div>
                <?php
					include_once('include/management/actionMessages.php');
                ?>
				
				<form name="newusergroup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <fieldset>

                <h302> <?php echo t('title','ProfileInfo') ?> </h302>
                <br/>

                <label for='profile' class='form'>Profile Name</label>
                <input name='profile' type='text' id='profile' value='' tabindex=100 />
                <br />

				<label for='profile' class='form'>Network Limit (Mbps)</label>
                <input name='netWorkLimit' min="0.5"  type='number' id='netWorkLimit' value='' tabindex=101 />
                <br />

                <br/><br/>
                <hr><br/>

                <input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />

        </fieldset>


        <br/>


        <?php
			// include_once('include/management/attributes.php');
        ?>
		
	</form>


<?php
	include('include/config/logging.php');
?>

		</div>

		<div id="footer">

<?php
	include 'page-footer.php';
?>


		</div>

</div>
</div>


</body>
</html>
