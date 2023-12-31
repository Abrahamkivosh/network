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


	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "username";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";



	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for listing of records on page: ";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<title>
<?php echo $configValues['SYSTEM_NAME'] ?> - <?php echo t('title', 'mngUGList')
?>
</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />
</head>
 
 
<?php
	include ("menu-mng-rad-usergroup.php");
?>

	<div id="contentnorightbar">
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradusergrouplist') ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradusergrouplist') ?>
			<br/>
		</div>	
		<br/>

<?php

	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page	
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".UserName), ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName, ".
		$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".priority, ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname, ".
		$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname ".
		" FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." ON ".
		$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username ".
			" GROUP BY UserName;";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".UserName), ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName, ".
		$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".priority, ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname, ".
		$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname ".
		" FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." ON ".
		$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username ".
			" GROUP BY UserName ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";
	
	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<form name='listallusergroup' method='post' action='mng-rad-usergroup-del.php'>";
	
	echo "<table border='0' class='table1'>\n";
	echo "
		<thead>
			<tr>
			<th colspan='10' align='left'>

			Select:
			<a class=\"table\" href=\"javascript:SetChecked(1,'usergroup[]','listallusergroup')\">All</a>
			<a class=\"table\" href=\"javascript:SetChecked(0,'usergroup[]','listallusergroup')\">None</a>
			<br/>
			<input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listallusergroup\",\"mng-rad-usergroup-del.php\")' />
			<br/><br/>

	";


	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

	echo "	</th></tr>
			</thead>
	";

	if ($orderType == "asc") {
		$orderTypeNextPage = "desc";
	} else  if ($orderType == "desc") {
		$orderTypeNextPage = "asc";
	}

	echo "<thread> <tr>
		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=username&orderType=$orderTypeNextPage\">
		".t('all','Username')."</a>
		</th>

                <th scope='col'>
                <a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=firstname&orderType=$orderTypeNextPage\">
                ".t('all','Name')."</a>
                </th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=$orderTypeNextPage\">
		".t('all','Groupname')."</a>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=priority&orderType=$orderTypeNextPage\">
		".t('all','Priority')."</a>
		</th>

	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
			<td> <input type='checkbox' name='usergroup[]' value='$row[0]||$row[1]'> $row[0] </td>
			<td> $row[3] $row[4] </td>
			<td> <a class='tablenovisit' href='#'
								onclick='javascript:return false;'
                                tooltipText=\"
                                        <a class='toolTip' href='mng-rad-usergroup-edit.php?username=$row[0]&group=$row[1]'>".t('Tooltip','EditUserGroup')."</a>
					<br/>
                                        <a class='toolTip' href='mng-rad-usergroup-list-user.php?username=$row[0]&group=$row[1]'>".t('Tooltip','ListUserGroups')."</a>
                                        <br/>\"
					>$row[1]</a></td>
				<td> $row[2] </td>
		</tr>";
	}

	echo "
		<tfoot>
			<tr>
			<th colspan='10' align='left'>
	";
	setupLinks($pageNum, $maxPage, $orderBy, $orderType);
	echo "
			</th>
			</tr>
		</tfoot>
	";


	echo "</table></form>";

	include 'library/closedb.php';
?>


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

<script type="text/javascript">
var tooltipObj = new DHTMLgoodies_formTooltip();
tooltipObj.setTooltipPosition('right');
tooltipObj.setPageBgColor('#EEEEEE');
tooltipObj.setTooltipCornerSize(15);
tooltipObj.initFormFieldTooltip();
</script>

</body>
</html>
