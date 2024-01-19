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
        return true;
    } else {
        return false;
    }
}

/**
 * This function is used to format user phone number
 * @param $phoneNumber
 * @return unknown_type
 */
function formatPhoneNumber($phoneNumber)
{
    $phoneNumber = str_replace(' ', '', $phoneNumber);
    $phoneNumber = str_replace('-', '', $phoneNumber);
    $phoneNumber = str_replace('(', '', $phoneNumber);
    $phoneNumber = str_replace(')', '', $phoneNumber);
    $phoneNumber = str_replace('+', '', $phoneNumber);

    // if phone number starts with 254 return as is
    if (substr($phoneNumber, 0, 3) == '254') {
        return $phoneNumber;
    }
    // check if phone number starts with 0 and replace with 254
    if (substr($phoneNumber, 0, 1) == '0') {
        $phoneNumber = '254' . substr($phoneNumber, 1);
    }
    return $phoneNumber;
}

/**
 * This function is used to determine new date after adding a number of days
 * @param $expiryDateTimestamp
 * @param $timeBank
 * @return unknown_type
 */
function getNewDate($expiryDateTimestamp, $timeBank)
{
    $timeNow = time();
    if ($expiryDateTimestamp > $timeNow) {
        $newDate = $expiryDateTimestamp + $timeBank;
    } else {
        $newDate = $expiryDateTimestamp + ($timeNow - $expiryDateTimestamp) + $timeBank;
    }
    // convert to date time
    $date = new DateTime();
    $date->setTimestamp($newDate);
    // return 11 Sep 2023 00:00:00
    $newDate = $date->format('d M Y H:i:s');
    return $newDate;
}

/**
 * This function is used to get invoice type id
 * @param string $invoiceType
 * @return int | null
 */
function getInvoiceTypeId($dbSocket, string $invoiceType)
{
    global $configValues;
    $query = "SELECT id FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICETYPE'] . " WHERE value = '" . $invoiceType . "' ";
    $res = $dbSocket->query($query);
    if ($res->numRows() > 0) {
        $row = $res->fetchRow();
        return $row['id'];
    }
    return null;
}


// create invoice if plan was selected
function createUserInvoicePlan($planName, $userName = null)
{
    global $configValues;
    global $dbSocket;
    include_once("include/management/userBilling.php");

    // get plan information
    $sql = "SELECT id, planCost, planSetupCost, planTax FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'] .
        " WHERE planName='" . $dbSocket->escapeSimple($planName) . "' LIMIT 1";
    $res = $dbSocket->query($sql);
    $row = $res->fetchRow(DB_FETCHMODE_ASSOC);

    // calculate tax (planTax is the numerical percentage amount) 
    if (isset($row['planTax']) && ($row['planTax'] != '')) {
        $calcTax = (float) ($row['planCost'] * (float)($row['planTax'] / 100));
    } else {
        $calcTax = 0;
    }

    $invoiceItems[0]['plan_id'] = $row['id'];
    $invoiceItems[0]['amount'] = $row['planCost'];
    $invoiceItems[0]['tax'] = $calcTax;
    $invoiceItems[0]['notes'] = 'charge for plan service';

    if (isset($row['planSetupCost']) && ($row['planSetupCost'] != '')) {
        $calcTax = isset($row['planSetupCost']) ? $row['planSetupCost'] * $row['planTax'] / 100 : 0;
        $invoiceItems[1]['plan_id'] = $row['id'];
        $invoiceItems[1]['amount'] = $row['planSetupCost'];
        $invoiceItems[1]['tax'] = $calcTax;
        $invoiceItems[1]['notes'] = 'charge for plan setup fee (one time)';
    }

    $table_userBillingInfo = $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] ;
    $query = "SELECT id FROM $table_userBillingInfo WHERE username = '$userName'";
    $res = $dbSocket->query($query);
    $row = $res->fetchRow(DB_FETCHMODE_ASSOC);
    userInvoiceAdd($row['id'], array(), $invoiceItems);
}



function addPlanProfile($dbSocket, $username, $planName)
{

    global $logDebugSQL;
    global $configValues;

    // search to see if the plan is associated with any profiles
    $sql = "SELECT profile_name FROM " .
        $configValues['CONFIG_DB_TBL_DALOBILLINGPLANSPROFILES'] .
        " WHERE plan_name='$planName'";
    $res = $dbSocket->getCol($sql);
    // $res is an array of all profiles associated with this plan

    // if the profile list for this plan isn't empty, we associate it with the user
    if (count($res) != 0) {

        // if profiles are associated with this plan, loop through each and add a usergroup entry for each
        foreach ($res as $profile_name) {
            $sql = "INSERT INTO " . $configValues['CONFIG_DB_TBL_RADUSERGROUP'] . " (UserName,GroupName,priority) " .
                " VALUES ('" . $dbSocket->escapeSimple($username) . "','$profile_name','0')";
            $res = $dbSocket->query($sql);
        }

        return true;
    }

    return false;
}


function addGroups($dbSocket, $username, $groups)
{

    global $logDebugSQL;
    global $configValues;

    // insert usergroup mapping
    if (isset($groups)) {

        foreach ($groups as $group) {

            if (trim($group) != "") {
                $sql = "INSERT INTO " . $configValues['CONFIG_DB_TBL_RADUSERGROUP'] . " (UserName,GroupName,priority) " .
                    " VALUES ('" . $dbSocket->escapeSimple($username) . "', '" . $dbSocket->escapeSimple($group) . "',0) ";
                $res = $dbSocket->query($sql);
                $logDebugSQL .= $sql . "\n";
            }
        }
    }
}


function addUserInfo($dbSocket, $username)
{

    global $firstname;
    global $lastname;
    global $email;
    global $department;
    global $company;
    global $workphone;
    global $homephone;
    global $mobilephone;
    global $ui_address;
    global $ui_city;
    global $ui_state;
    global $ui_country;
    global $ui_zip;
    global $notes;
    global $ui_changeuserinfo;
    global $ui_PortalLoginPassword;
    global $ui_enableUserPortalLogin;

    global $logDebugSQL;
    global $configValues;

    $currDate = date('Y-m-d H:i:s');
    $currBy = $_SESSION['operator_user'];

    $sql = "SELECT * FROM " . $configValues['CONFIG_DB_TBL_DALOUSERINFO'] .
        " WHERE username='" . $dbSocket->escapeSimple($username) . "'";
    $res = $dbSocket->query($sql);
    $logDebugSQL .= $sql . "\n";

    // if there were no records for this user present in the userinfo table
    if ($res->numRows() == 0) {
        // insert user information table
        $sql = "INSERT INTO " . $configValues['CONFIG_DB_TBL_DALOUSERINFO'] .
            " (id, username, firstname, lastname, email, department, company, workphone, homephone, " .
            " mobilephone, address, city, state, country, zip, notes, changeuserinfo, portalloginpassword, enableportallogin, creationdate, creationby) " .
            " VALUES (0, 
            '" . $dbSocket->escapeSimple($username) . "', '" . $dbSocket->escapeSimple($firstname) . "', '" .
            $dbSocket->escapeSimple($lastname) . "', '" . $dbSocket->escapeSimple($email) . "', '" .
            $dbSocket->escapeSimple($department) . "', '" . $dbSocket->escapeSimple($company) . "', '" .
            $dbSocket->escapeSimple($workphone) . "', '" . $dbSocket->escapeSimple($homephone) . "', '" .
            $dbSocket->escapeSimple($mobilephone) . "', '" . $dbSocket->escapeSimple($ui_address) . "', '" .
            $dbSocket->escapeSimple($ui_city) . "', '" . $dbSocket->escapeSimple($ui_state) . "', '" .
            $dbSocket->escapeSimple($ui_country) . "', '" .
            $dbSocket->escapeSimple($ui_zip) . "', '" . $dbSocket->escapeSimple($notes) . "', '" .
            $dbSocket->escapeSimple($ui_changeuserinfo) . "', '" .
            $dbSocket->escapeSimple($ui_PortalLoginPassword) . "', '" . $dbSocket->escapeSimple($ui_enableUserPortalLogin) .
            "', '$currDate', '$currBy')";
        $res = $dbSocket->query($sql);
        $logDebugSQL .= $sql . "\n";
    } //FIXME:
    //if the user already exist in userinfo then we should somehow alert the user
    //that this has happened and the administrator/operator will take care of it

}


function addUserBillInfo($dbSocket, $username)
{

    global $planName;
    global $bi_contactperson;
    global $bi_company;
    global $bi_email;
    global $bi_phone;
    global $bi_address;
    global $bi_city;
    global $bi_state;
    global $bi_country;
    global $bi_zip;
    global $bi_paymentmethod;
    global $bi_cash;
    global $bi_creditcardname;
    global $bi_creditcardnumber;
    global $bi_creditcardexp;
    global $bi_creditcardverification;
    global $bi_creditcardtype;
    global $bi_notes;
    global $bi_lead;
    global $bi_coupon;
    global $bi_ordertaker;
    global $bi_billstatus;
    global $bi_lastbill;
    global $bi_nextbill;
    global $bi_nextinvoicedue;
    global $bi_billdue;
    global $bi_postalinvoice;
    global $bi_faxinvoice;
    global $bi_emailinvoice;
    global $bi_changeuserbillinfo;
    global $logDebugSQL;
    global $configValues;

    $currDate = date('Y-m-d H:i:s');
    $currBy = $_SESSION['operator_user'];

    $sql = "SELECT * FROM " . $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] .
        " WHERE username='" . $dbSocket->escapeSimple($username) . "'";
    $res = $dbSocket->query($sql);
    $logDebugSQL .= $sql . "\n";

    // if there were no records for this user present in the userbillinfo table
    if ($res->numRows() == 0) {
        // insert user billing information table
        $sql = "INSERT INTO " . $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] .
            " (id, planname, username, contactperson, company, email, phone, " .
            " address, city, state, country, zip, " .
            " paymentmethod, cash, creditcardname, creditcardnumber, creditcardverification, creditcardtype, creditcardexp, " .
            " notes, changeuserbillinfo, " .
            " `lead`, coupon, ordertaker, billstatus, lastbill, nextbill, nextinvoicedue, billdue, postalinvoice, faxinvoice, emailinvoice, " .
            " creationdate, creationby) " .
            " VALUES (0, '" . $dbSocket->escapeSimple($planName) . "', 
                '" . $dbSocket->escapeSimple($username) . "', '" . $dbSocket->escapeSimple($bi_contactperson) . "', '" .
            $dbSocket->escapeSimple($bi_company) . "', '" . $dbSocket->escapeSimple($bi_email) . "', '" .
            $dbSocket->escapeSimple($bi_phone) . "', '" . $dbSocket->escapeSimple($bi_address) . "', '" .
            $dbSocket->escapeSimple($bi_city) . "', '" . $dbSocket->escapeSimple($bi_state) . "', '" .
            $dbSocket->escapeSimple($bi_country) . "', '" .
            $dbSocket->escapeSimple($bi_zip) . "', '" . $dbSocket->escapeSimple($bi_paymentmethod) . "', '" .
            $dbSocket->escapeSimple($bi_cash) . "', '" . $dbSocket->escapeSimple($bi_creditcardname) . "', '" .
            $dbSocket->escapeSimple($bi_creditcardnumber) . "', '" . $dbSocket->escapeSimple($bi_creditcardverification) . "', '" .
            $dbSocket->escapeSimple($bi_creditcardtype) . "', '" . $dbSocket->escapeSimple($bi_creditcardexp) . "', '" .
            $dbSocket->escapeSimple($bi_notes) . "', '" .
            $dbSocket->escapeSimple($bi_changeuserbillinfo) . "', '" .
            $dbSocket->escapeSimple($bi_lead) . "', '" . $dbSocket->escapeSimple($bi_coupon) . "', '" .
            $dbSocket->escapeSimple($bi_ordertaker) . "', '" . $dbSocket->escapeSimple($bi_billstatus) . "', '" .
            $dbSocket->escapeSimple($bi_lastbill) . "', '" . $dbSocket->escapeSimple($bi_nextbill) . "', '" .
            $dbSocket->escapeSimple($bi_nextinvoicedue) . "', '" . $dbSocket->escapeSimple($bi_billdue) . "', '" .
            $dbSocket->escapeSimple($bi_postalinvoice) . "', '" . $dbSocket->escapeSimple($bi_faxinvoice) . "', '" .
            $dbSocket->escapeSimple($bi_emailinvoice) .
            "', '$currDate', '$currBy')";
        $res = $dbSocket->query($sql);
        $logDebugSQL .= $sql . "\n";
        return true;
    } else {
        return false;
    }
}


function addAttributes($dbSocket, $username)
{

    global $logDebugSQL;
    global $configValues;

    foreach ($_POST as $element => $field) {

        // switch case to rise the flag for several $attribute which we do not
        // wish to process (ie: do any sql related stuff in the db)
        switch ($element) {

            case "authType":
            case "username":
            case "password":
            case "passwordType":
            case "groups":
            case "group_macaddress":
            case "group_pincode":
            case "macaddress":
            case "pincode":
            case "submit":
            case "firstname":
            case "lastname":
            case "email":
            case "department":
            case "company":
            case "workphone":
            case "homephone":
            case "mobilephone":
            case "address":
            case "city":
            case "state":
            case "country":
            case "zip":
            case "notes":
            case "bi_contactperson":
            case "bi_company":
            case "bi_email":
            case "bi_phone":
            case "bi_address":
            case "bi_city":
            case "bi_state":
            case "bi_country":
            case "bi_zip":
            case "bi_paymentmethod":
            case "bi_cash":
            case "bi_creditcardname":
            case "bi_creditcardnumber":
            case "bi_creditcardverification":
            case "bi_creditcardtype":
            case "bi_creditcardexp":
            case "bi_notes":
            case "bi_lead":
            case "bi_coupon":
            case "bi_ordertaker":
            case "bi_billstatus":
            case "bi_lastbill":
            case "bi_nextbill":
            case "bi_nextinvoicedue":
            case "bi_billdue":
            case "bi_postalinvoice":
            case "bi_faxinvoice":
            case "bi_emailinvoice":
            case "changeUserBillInfo":
            case "changeUserInfo":
            case "copycontact":
            case "portalLoginPassword":
            case "enableUserPortalLogin":
                $skipLoopFlag = 1;    // if any of the cases above has been met we set a flag
                // to skip the loop (continue) without entering it as
                // we do not want to process this $attribute in the following
                // code block
                break;
        }

        if ($skipLoopFlag == 1) {
            $skipLoopFlag = 0;              // resetting the loop flag
            continue;
        }

        if (isset($field[0]))
            $attribute = $field[0];
        if (isset($field[1]))
            $value = $field[1];
        if (isset($field[2]))
            $op = $field[2];
        if (isset($field[3]))
            $table = $field[3];

        if (isset($table) && ($table == 'check'))
            $table = $configValues['CONFIG_DB_TBL_RADCHECK'];
        if (isset($table) && ($table == 'reply'))
            $table = $configValues['CONFIG_DB_TBL_RADREPLY'];

        if ((isset($field)) && (!isset($field[1])))
            continue;

        $sql = "INSERT INTO $table (id,Username,Attribute,op,Value) " .
            " VALUES (0, '" . $dbSocket->escapeSimple($username) . "', '" .
            $dbSocket->escapeSimple($attribute) . "', '" . $dbSocket->escapeSimple($op) . "', '" .
            $dbSocket->escapeSimple($value) . "')  ";
        $res = $dbSocket->query($sql);
        $logDebugSQL .= $sql . "\n";
    } // foreach

}



// calculate the nextbill and other related billing information
function calculateNextBillingDate($dbSocket, $configValues, $planName)
{

    // calculate the nextbill and other related billing information
    $sql = "SELECT * FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'] .
        " WHERE planName='" . $dbSocket->escapeSimple($planName) . "' LIMIT 1";
    $res = $dbSocket->query($sql);
    $row = $res->fetchRow(DB_FETCHMODE_ASSOC);

    $planRecurring = $row['planRecurring'];
    $planRecurringPeriod = $row['planRecurringPeriod'];
    $planRecurringBillingSchedule = $row['planRecurringBillingSchedule'];


    // initialize next bill date string (Y-m-d style) 000-00-00 00:00:00 of today
    $nextBillDate = date('Y-m-d H:i:s');
    // get next billing date
    if ($planRecurring == "Yes") {
        $nextBillDate = getNextBillingDate($planRecurringBillingSchedule, $planRecurringPeriod);
    }



    return $nextBillDate;
}

function getInvoiceDetails($dbSocket,$configValues,$invoice_id)
{
    $sql = "SELECT a.id, a.date, a.status_id, a.type_id, a.user_id, a.notes, b.contactperson, b.username, ".
				" b.city, b.state, f.value as type, ".
				" c.value AS status, COALESCE(e2.totalpayed, 0) as totalpayed, COALESCE(d2.totalbilled, 0) as totalbilled ".
				" FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE']." AS a".
				" INNER JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERBILLINFO']." AS b ON (a.user_id = b.id) ".
				" INNER JOIN ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS']." AS c ON (a.status_id = c.id) ".
				" INNER JOIN ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICETYPE']." AS f ON (a.type_id = f.id) ".
				" LEFT JOIN (SELECT SUM(d.amount + d.tax_amount) ".
					" as totalbilled, invoice_id, amount, tax_amount, notes, plan_id FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS']." AS d ".
					" GROUP BY d.invoice_id) AS d2 ON (d2.invoice_id = a.id) ".
				" LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS']." AS bp2 ON (bp2.id = d2.plan_id) ".
				" LEFT JOIN (SELECT SUM(e.amount) as totalpayed, invoice_id FROM ". 
				$configValues['CONFIG_DB_TBL_DALOPAYMENTS']." AS e GROUP BY e.invoice_id) AS e2 ON (e2.invoice_id = a.id) ".
				" WHERE a.id = '".$dbSocket->escapeSimple($invoice_id)."'".
				" GROUP BY a.id ";
		$res = $dbSocket->query($sql);
	
		return $res->fetchRow(PDO::FETCH_ASSOC) ;
}