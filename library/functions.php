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
	function addAttribute($dbSocket, $username, $attribute, $op, $value, $table) {
		
		global $logDebugSQL;
		global $configValues;

		if ( isset($table) && ($table == 'check') )
			$table = $configValues['CONFIG_DB_TBL_RADCHECK'];
		if ( isset($table) && ($table == 'reply') )
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];

		$sql = "INSERT INTO $table (id,Username,Attribute,op,Value) ".
				" VALUES (0, '".$dbSocket->escapeSimple($username)."', '".
				$dbSocket->escapeSimple($attribute)."', '".$dbSocket->escapeSimple($op)."', '".
				$dbSocket->escapeSimple($value)."')  ";
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
	function deleteAttribute($dbSocket, $username, $attribute, $table) {
		
		global $logDebugSQL;
		global $configValues;

		if ( isset($table) && ($table == 'check') )
			$table = $configValues['CONFIG_DB_TBL_RADCHECK'];
		if ( isset($table) && ($table == 'reply') )
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];

		$sql = "DELETE FROM $table WHERE Username = '".$dbSocket->escapeSimple($username)."' AND Attribute = '".$dbSocket->escapeSimple($attribute)."' ";
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

	function updateAttribute($dbSocket, $username, $attribute, $op, $value, $table) {
		
		global $logDebugSQL;
		global $configValues;

		if ( isset($table) && ($table == 'check') )
			$table = $configValues['CONFIG_DB_TBL_RADCHECK'];
		if ( isset($table) && ($table == 'reply') )
			$table = $configValues['CONFIG_DB_TBL_RADREPLY'];

		$sql = "UPDATE $table SET op = '".$dbSocket->escapeSimple($op)."', Value = '".$dbSocket->escapeSimple($value)."' WHERE Username = '".$dbSocket->escapeSimple($username)."' AND Attribute = '".$dbSocket->escapeSimple($attribute)."' ";
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
	function getArrayValue($array, $key, $default = null) {
		if (isset($array[$key])) {
			return $array[$key];
		}
		return $default;
	}