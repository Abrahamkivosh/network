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




class User {
    public $configValues;
    public $userInstance;
    public $dbSocket;

    public function __construct( $dbSocket, $configValues )
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
    public function setUserInstance( string $userInstance )
    {
        $this->userInstance = $userInstance;
    }

    /**
     * set config values
     * @param array $configValues
     */
    public function setConfigValues( array $configValues )
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

        if ($result->numRows()  > 0) {
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


        if ($result->numRows()  > 0) {
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

        if ($result->numRows()  > 0) {
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

        if ($result->numRows()  > 0) {
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

        if ($result->numRows()  > 0) {
            // get all rows
            $rows = [] ;
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

        if ($result->numRows()  > 0) {
            $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
            $expire_date =  $row['value']; 
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

        if ($result->numRows()  > 0) {
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



}

// test the class
$user = new User($dbSocket, $configValues);
$user->setUserInstance('kivosh');
$billingInfo = $user->getUserBillInfo();


