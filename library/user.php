<?php

// Check if opendb.php has already been included
if (!defined('OPENDB_INCLUDED')) {
    require_once "./opendb.php";
    define('OPENDB_INCLUDED', true);
}

// Check if config_read.php has already been included
if (!defined('CONFIG_READ_INCLUDED')) {
    require_once "./config_read.php";
    define('CONFIG_READ_INCLUDED', true);
}

class User
{
    public $configValues;
    public $userInstance;
    public $dbSocket;

    public function __construct($dbSocket, $configValues)
    {
        $this->dbSocket = $dbSocket;
        $this->configValues = $configValues;
    }

    /**
     * Set user instance
     * @param string $userInstance  // username
     *
     * @return mixed
     */
    public function setUserInstance(string $userInstance)
    {
        $this->userInstance = $userInstance;
    }

    /**
     * set config values
     * @param array $configValues
     */
    public function setConfigValues(array $configValues)
    {
        $this->configValues = $configValues;
    }

    /**
     * Get user instance
     * @return mixed
     */
    public function getUserInstance()
    {
        return $this->userInstance;
    }

    /**
     * Get config values
     */
    public function getConfigValues()
    {
        return $this->configValues;
    }

    // Check if user exists
    public function userExists()
    {
        $userInstance = $this->userInstance;
        $table_userInfo = $this->configValues['CONFIG_DB_TBL_DALOUSERINFO'];

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $query = "SELECT * FROM $table_userInfo WHERE username = '$userName'";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Get user userbillinfo
     * @return mixed
     */
    public function getUserBillInfo()
    {
        $userInstance = $this->userInstance;
        $table_userBillingInfo = $this->configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'];

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $query = "SELECT * FROM $table_userBillingInfo WHERE username = '$userName'";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            return $row;
        } else {
            return false;
        }

    }

    /**
     * Get user userinfo
     * @return mixed
     */
    public function getUserInfo()
    {
        $userInstance = $this->userInstance;
        $table_userInfo = $this->configValues['CONFIG_DB_TBL_DALOUSERINFO'];

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $query = "SELECT * FROM $table_userInfo WHERE username = '$userName'";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Get user radius group
     * @return mixed
     */
    public function getUserRadiusGroup()
    {
        $userInstance = $this->userInstance;
        $table_userGroup = $this->configValues['CONFIG_DB_TBL_RADUSERGROUP'];

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $query = "SELECT * FROM $table_userGroup WHERE username = '$userName'";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Get user radcheck
     * @return mixed
     */
    public function getUserRadCheck()
    {
        $userInstance = $this->userInstance;
        $table_userRadCheck = $this->configValues['CONFIG_DB_TBL_RADCHECK'];

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $query = "SELECT * FROM $table_userRadCheck WHERE username = '$userName'";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            // get all rows
            $rows = [];
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;

        } else {
            return false;
        }
    }

    /**
     * Get user Account Expiration Date
     * @return mixed
     */
    public function getUserAccountExpirationDate()
    {
        $userInstance = $this->userInstance;
        $table_userRadCheck = $this->configValues['CONFIG_DB_TBL_RADCHECK'];

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "SELECT value FROM $table_userRadCheck WHERE username = '$userName' AND attribute = 'Expiration'";
        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            $expire_date = $row['value'];
            // convert to date time

            $date = new DateTime($expire_date);
            // return 11 Sep 2023 00:00:00
            $expire_date = $date->format('d M Y H:i:s');
            $remaining_days = $date->diff(new DateTime())->format('%a');
            return [
                'expire_date' => $expire_date,
                'remaining_days' => $remaining_days,
                'timestamp' => $date->getTimestamp(),
            ];
        } else {
            return false;
        }

    }

    /**
     * Get user billing Plan
     * @return mixed
     */
    public function getUserBillingPlan()
    {
        $userInstance = $this->userInstance;
        $userBillInfo = $this->getUserBillInfo();
        $plan = $userBillInfo['planName'];
        $table_billingPlan = $this->configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'];
        $sql = "SELECT * FROM $table_billingPlan WHERE planName = '$plan'";
        $result = $this->dbSocket->query($sql);

        if ($result->numRows() > 0) {
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Update user account expiration date
     * @param $newDate
     * @return mixed
     */
    public function updateUserAccountExpirationDate($newDate)
    {
        $userInstance = $this->userInstance;
        $table_userRadCheck = $this->configValues['CONFIG_DB_TBL_RADCHECK'];

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "UPDATE $table_userRadCheck SET value = '$newDate' WHERE username = '$userName' AND attribute = 'Expiration'";
        $result = $this->dbSocket->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update user balance
     * @param $newBalance
     * @return mixed
     */
    public function updateUserBalance($newBalance)
    {
        $userInstance = $this->userInstance;
        $table_userBillInfo = $this->configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'];

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "UPDATE $table_userBillInfo SET balance = '$newBalance' WHERE username = '$userName'";
        $result = $this->dbSocket->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get user all invoices
     * @return mixed
     */
    public function getUserInvoices()
    {

        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $orderBy = 'a.id';
        $orderType = 'DESC';
        $rowsPerPage = 10;
        $offset = 0;

        $sql_WHERE = " WHERE b.username = '$userInstance' ";

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $query = "SELECT a.id, a.date, a.status_id, a.type_id, b.contactperson, b.username, " .
            " c.value AS status, COALESCE(e2.totalpayed, 0) as totalpayed, COALESCE(d2.totalbilled, 0) as totalbilled " .
            " FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE'] . " AS a" .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] . " AS b ON (a.user_id = b.id) " .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS'] . " AS c ON (a.status_id = c.id) " .
            " LEFT JOIN (SELECT SUM(d.amount + d.tax_amount) " .
            " as totalbilled, invoice_id FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'] . " AS d " .
            " GROUP BY d.invoice_id) AS d2 ON (d2.invoice_id = a.id) " .
            " LEFT JOIN (SELECT SUM(e.amount) as totalpayed, invoice_id FROM " .
            $configValues['CONFIG_DB_TBL_DALOPAYMENTS'] . " AS e GROUP BY e.invoice_id) AS e2 ON (e2.invoice_id = a.id) " .
            $sql_WHERE .
            " GROUP BY a.id " .
            " ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            // get all rows
            $rows = [];
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;

        } else {
            return false;
        }

    }

    /**
     * Get user invoice by id
     * @param $invoiceId
     * @return mixed
     */
    public function getUserInvoiceById($invoiceId)
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $orderBy = 'a.id';
        $orderType = 'DESC';
        $rowsPerPage = 10;
        $offset = 0;

        $sql_WHERE = " WHERE b.username = '$userInstance' AND a.id = '$invoiceId' ";

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "SELECT a.id, a.date, a.status_id, a.type_id, b.contactperson, b.username, " .
            " c.value AS status, COALESCE(e2.totalpayed, 0) as totalpayed, COALESCE(d2.totalbilled, 0) as totalbilled " .
            " FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE'] . " AS a" .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] . " AS b ON (a.user_id = b.id) " .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS'] . " AS c ON (a.status_id = c.id) " .
            " LEFT JOIN (SELECT SUM(d.amount + d.tax_amount) " .
            " as totalbilled, invoice_id FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'] . " AS d " .
            " GROUP BY d.invoice_id) AS d2 ON (d2.invoice_id = a.id) " .
            " LEFT JOIN (SELECT SUM(e.amount) as totalpayed, invoice_id FROM " .
            $configValues['CONFIG_DB_TBL_DALOPAYMENTS'] . " AS e GROUP BY e.invoice_id) AS e2 ON (e2.invoice_id = a.id) " .
            $sql_WHERE .
            " GROUP BY a.id " .
            " ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            // get all rows
            $rows = [];
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;

        } else {
            return false;
        }

    }

    /**
     * Get user latest invoice by status
     * @param $status
     */
    public function getUserLatestInvoiceByStatus(array  $status, $whereIn = true)
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $orderBy = 'a.id';
        $orderType = 'DESC';
        $rowsPerPage = 10;
        $offset = 0;

        if ($whereIn)
        {
            $sql_WHERE = " WHERE b.username = '$userInstance' AND c.value IN ('" . implode("','", $status) . "') ";
        }else 
        {
            $sql_WHERE = " WHERE b.username = '$userInstance' AND c.value NOT IN ('" . implode("','", $status) . "') ";
        }
        

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "SELECT a.id, a.date, a.status_id, a.type_id, b.contactperson, b.username, " .
            " c.value AS status, COALESCE(e2.totalpayed, 0) as totalpayed, COALESCE(d2.totalbilled, 0) as totalbilled, " .
            " COALESCE(e2.totalpayed, 0) - COALESCE(d2.totalbilled, 0)  AS balance " .
            " FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE'] . " AS a" .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] . " AS b ON (a.user_id = b.id) " .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS'] . " AS c ON (a.status_id = c.id) " .
            " LEFT JOIN (SELECT SUM(d.amount + d.tax_amount) as totalbilled," .

            " invoice_id FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'] . " AS d " .
            " GROUP BY d.invoice_id) AS d2 ON (d2.invoice_id = a.id) " .
            " LEFT JOIN (SELECT SUM(e.amount) as totalpayed, invoice_id FROM " .
            $configValues['CONFIG_DB_TBL_DALOPAYMENTS'] . " AS e GROUP BY e.invoice_id) AS e2 ON (e2.invoice_id = a.id) " .
            $sql_WHERE .
            " GROUP BY a.id " .
            " ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            // get first row
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            return $row;

        } else {
            return false;
        }

    }

    /**
     * Get user invoice items
     * @param $invoiceId
     * @return mixed
     */
    public function getUserInvoiceItems($invoiceId)
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $orderBy = 'a.id';
        $orderType = 'DESC';
        $rowsPerPage = 10;
        $offset = 0;

        $sql_WHERE = " WHERE  a.invoice_id = '$invoiceId' ";

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "SELECT a.id, a.invoice_id, a.amount, a.tax_amount, a.notes, a.plan_id, " .
            " b.planName, b.planCost, b.planTimeBank " .
            " FROM " . $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'] . " AS a" .
            " INNER JOIN " . $configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'] . " AS b ON (a.plan_id = b.id) " .
            $sql_WHERE
            . " ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            // get all rows
            $rows = [];
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;

        } else {
            return false;
        }

    }

    /**
     * Get user invoice payments
     * @param $invoiceId
     */
    public function getUserInvoicePayments($invoiceId)
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $orderBy = 'a.id';
        $orderType = 'DESC';
        $rowsPerPage = 10;
        $offset = 0;

        $sql_WHERE = " WHERE  a.invoice_id = '$invoiceId' ";

        $userName = $this->dbSocket->escapeSimple($userInstance);

        $query = "SELECT a.id, a.invoice_id, a.amount, a.type_id, a.date, a.notes," .
            "b.value as type" .
            " FROM " . $configValues['CONFIG_DB_TBL_DALOPAYMENTS'] . " AS a" .
            " LEFT JOIN " . $configValues['CONFIG_DB_TBL_DALOPAYMENTTYPES'] . " AS b ON (a.type_id = b.id) " .
            $sql_WHERE
            . " ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";

        $result = $this->dbSocket->query($query);

        if ($result->numRows() > 0) {
            // get all rows
            $rows = [];
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;

        } else {
            return false;
        }
    }

    /**
     * Get user balance from invoices payments
     * Deduct invoice items amount to get balance
     */
    public function getUserBalance()
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $user_id = $this->getUserBillInfo()['id'];

        $sql_WHERE = " WHERE b.username = '$userInstance' ";

        $sql = "SELECT COUNT(distinct(a.id)) AS TotalInvoices, a.id, a.date, a.status_id, a.type_id, b.contactperson, b.username, ".
			" c.value AS status, COALESCE(SUM(e2.totalpayed), 0) as totalpayed, COALESCE(SUM(d2.totalbilled), 0) as totalbilled, ".
			" SUM(a.status_id = 1) as openInvoices ".
			" FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE']." AS a".
			" INNER JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERBILLINFO']." AS b ON (a.user_id = b.id) ".
			" INNER JOIN ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS']." AS c ON (a.status_id = c.id) ".
			" LEFT JOIN (SELECT SUM(d.amount + d.tax_amount) ".
					" as totalbilled, invoice_id FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS']." AS d ".
			" GROUP BY d.invoice_id) AS d2 ON (d2.invoice_id = a.id) ".
			" LEFT JOIN (SELECT SUM(e.amount) as totalpayed, invoice_id FROM ".
			$configValues['CONFIG_DB_TBL_DALOPAYMENTS']." AS e GROUP BY e.invoice_id) AS e2 ON (e2.invoice_id = a.id) ".
			" WHERE (a.user_id = $user_id)".
			" GROUP BY b.id ";
        $result = $this->dbSocket->query($sql);

        if ($result->numRows() > 0) {
            // get all rows
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            $balance = $row['totalpayed'] - $row['totalbilled'];
           
            return $balance;

        } else {
            return false;
        }

    }

    /**
     * Create user invoice if no invoice  with status  open exists
     * status open is picked from invoice_type table
     */
    public function createUserInvoice(array $data)
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $table_invoice = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE'];
        $table_invoice_items = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'];
        $table_invoice_status = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS'];
        $table_invoice_type = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICETYPE'];
        $table_userBillInfo = $configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'];

        $userName = $this->dbSocket->escapeSimple($userInstance);
        $userBillInfo = $this->getUserBillInfo();
        $userId = $userBillInfo['id'];

        $invoice_type = $data['invoice_type'];
        $invoice_status = $data['invoice_status'];
        $invoice_date = $data['invoice_date'];
        $invoice_notes = $data['invoice_notes'];
        $invoice_plan_id = $data['invoice_plan_id'];

        // create invoice
        $sql = "INSERT INTO $table_invoice (user_id, date, status_id, type_id, notes) VALUES " .
            "('$userId', '$invoice_date', '$invoice_status', '$invoice_type', '$invoice_notes')";
        $result = $this->dbSocket->query($sql);
        if ($result) {
            // get invoice id
            $invoice_id = $this->dbSocket->lastInsertID();
            // return $invoice_id;
            return $invoice_id;

        } else {
            return false;
        }

    }

    /**
     * Update user invoice status
     */
    public function updateUserInvoiceStatus(int $invoice_id, string $status)
    {
        $userInstance = $this->userInstance;
        $configValues = $this->configValues;
        $table_invoice = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE'];
        $table_invoice_status = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS'];

        $sql = "UPDATE $table_invoice SET status_id = (SELECT id FROM $table_invoice_status WHERE value = '$status') " .
            " WHERE id = '$invoice_id'";
        $result = $this->dbSocket->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create user invoice items
     * @param array $data
     * @return mixed
     */
    public function createUserInvoiceItems(int $invoice_id, array $data)
    {
        $plan_id = $data['plan_id'];
        $amount = $data['amount'];
        $tax_amount = $data['tax_amount'];
        $notes = $data['notes'];
        $total = $amount + $tax_amount;

        $configValues = $this->configValues;
        $table_invoice_items = $configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'];

        $sql = "INSERT INTO $table_invoice_items (invoice_id, plan_id, amount, tax_amount, notes) VALUES " .
            "('$invoice_id', '$plan_id', '$amount', '$tax_amount', '$notes')";
        $result = $this->dbSocket->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Create user invoice payments
     * @param array $data
     * @return mixed
     */
    public function createUserInvoicePayments(int $invoice_id, array $data)
    {
        $amount = $data['amount'];
        $type_id = $data['type_id'];
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
        $notes = isset($data['notes']) ? $data['notes'] : '';

        $configValues = $this->configValues;
        $table_invoice_payments = $configValues['CONFIG_DB_TBL_DALOPAYMENTS'];

        $sql = "INSERT INTO $table_invoice_payments (invoice_id, amount, type_id, date, notes) VALUES " .
            "('$invoice_id', '$amount', '$type_id', '$date', '$notes')";
        $result = $this->dbSocket->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

// // test the class
// $user = new User($dbSocket, $configValues);
// $user->setConfigValues($configValues);
// $user->setUserInstance('kivosh');
// $userExists = $user->userExists();
// $getUserBalance = $user->getUserBalance();

// echo '<pre>';
// print_r($getUserBalance);
// echo '</pre>';
