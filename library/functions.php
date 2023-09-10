<?php
/**
 * This function is used to add a new attribute to radcheck or radreply
 * @param $dbSocket
 * @param $username
 * @param $attribute
 * @param $op
 * @param $value
 * @param $table
 * @return unknown_type
 */
function addAttribute($dbSocket, $username, $attribute, $op, $value, $table)
{

    global $logDebugSQL;
    global $configValues;

    if (isset($table) && ($table == 'check')) {
        $table = $configValues['CONFIG_DB_TBL_RADCHECK'];
    }

    if (isset($table) && ($table == 'reply')) {
        $table = $configValues['CONFIG_DB_TBL_RADREPLY'];
    }

    $sql = "INSERT INTO $table (id,Username,Attribute,op,Value) " .
    " VALUES (0, '" . $dbSocket->escapeSimple($username) . "', '" .
    $dbSocket->escapeSimple($attribute) . "', '" . $dbSocket->escapeSimple($op) . "', '" .
    $dbSocket->escapeSimple($value) . "')  ";
    $res = $dbSocket->query($sql);
    $logDebugSQL .= $sql . "\n";
}

/**
 * This function is used to delete an attribute from radcheck or radreply
 * @param $dbSocket
 * @param $username
 * @param $attribute
 * @param $table
 * @return unknown_type
 */
function deleteAttribute($dbSocket, $username, $attribute, $table)
{

    global $logDebugSQL;
    global $configValues;

    if (isset($table) && ($table == 'check')) {
        $table = $configValues['CONFIG_DB_TBL_RADCHECK'];
    }

    if (isset($table) && ($table == 'reply')) {
        $table = $configValues['CONFIG_DB_TBL_RADREPLY'];
    }

    $sql = "DELETE FROM $table WHERE Username = '" . $dbSocket->escapeSimple($username) . "' AND Attribute = '" . $dbSocket->escapeSimple($attribute) . "' ";
    $res = $dbSocket->query($sql);
    $logDebugSQL .= $sql . "\n";
}

/**
 * This function is used to update an attribute from radcheck or radreply
 * @param $dbSocket
 * @param $username
 * @param $attribute
 * @param $op
 * @param $value
 * @param $table
 * @return unknown_type
 */

function updateAttribute($dbSocket, $username, $attribute, $op, $value, $table)
{

    global $logDebugSQL;
    global $configValues;

    if (isset($table) && ($table == 'check')) {
        $table = $configValues['CONFIG_DB_TBL_RADCHECK'];
    }

    if (isset($table) && ($table == 'reply')) {
        $table = $configValues['CONFIG_DB_TBL_RADREPLY'];
    }

    $sql = "UPDATE $table SET op = '" . $dbSocket->escapeSimple($op) . "', Value = '" . $dbSocket->escapeSimple($value) . "' WHERE Username = '" . $dbSocket->escapeSimple($username) . "' AND Attribute = '" . $dbSocket->escapeSimple($attribute) . "' ";
    $res = $dbSocket->query($sql);
    $logDebugSQL .= $sql . "\n";
}

/**
 * This function is used to solve the problem of Warning: Trying to access array offset on value of type null in
 * @param $array
 * @param $key
 * @param $default
 * @return unknown_type
 */
function getArrayValue($array, $key, $default = null)
{
    if (isset($array[$key])) {
        return $array[$key];
    }
    return $default;
}

/**
 * This function is used to add a new record to radusergroup
 * @param $dbSocket
 * @param $username
 * @param $groupname
 * @param $priority
 * @return unknown_type
 */
function addRadUserGroup($dbSocket, $username, $groupname, $priority = 0)
{
	
	global $logDebugSQL;
	global $configValues;

	$sql = "INSERT INTO " . $configValues['CONFIG_DB_TBL_RADUSERGROUP'] . " (id,UserName,GroupName,Priority) " .
	" VALUES (0, '" . $dbSocket->escapeSimple($username) . "', '" .
	$dbSocket->escapeSimple($groupname) . "', '" . $dbSocket->escapeSimple($priority) . "')  ";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";
	return $res;
}

/**
 *  This function is used to add a new record to radgroupcheck and radgroupreply
 * @param $dbSocket
 * @param $groupname
 * @param $attribute
 * @param $op
 * @param $value
 * @param $table
 * @return unknown_type
 */
function addRadGroupAttribute($dbSocket, $groupname, $attribute, $op, $value, $table)
{

    global $logDebugSQL;
    global $configValues;

    if (isset($table) && ($table == 'check')) {
        $table = $configValues['CONFIG_DB_TBL_RADGROUPCHECK'];
    }

    if (isset($table) && ($table == 'reply')) {
        $table = $configValues['CONFIG_DB_TBL_RADGROUPREPLY'];
    }

    // check if attribute already exists
    $sql = "SELECT * FROM $table WHERE GroupName = '" . $dbSocket->escapeSimple($groupname) . "' AND Attribute = '" . $dbSocket->escapeSimple($attribute) . "' ";
    $res = $dbSocket->query($sql);
    $logDebugSQL .= $sql . "\n";

    if ($res->numRows() == 0) {
        $sql = "INSERT INTO $table (id,GroupName,Attribute,op,Value) " .
        " VALUES (0, '" . $dbSocket->escapeSimple($groupname) . "', '" .
        $dbSocket->escapeSimple($attribute) . "', '" . $dbSocket->escapeSimple($op) . "', '" .
        $dbSocket->escapeSimple($value) . "')  ";
        $res = $dbSocket->query($sql);
        $logDebugSQL .= $sql . "\n";
        return true ;
    }else {
        return false;
    }



}