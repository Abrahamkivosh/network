<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '1024M');

// Check if config_read.php has already been included
if (!defined('CONFIG_READ_INCLUDED')) {
    require_once "../library/config_read.php";
    define('CONFIG_READ_INCLUDED', true);
}

// include the database connection file if it has not been included
if (!defined('OPENDB_INCLUDED')) {
    include_once "../library/opendb.php";
    define('OPENDB_INCLUDED', true);
}

// include the MpesaService class if it has not been included
if (!class_exists('MpesaService')) {
    include_once "../../library/services/MpesaService.php";
    define('MPESASERVICE_INCLUDED', true);
}


// include the User class if it has not been included
if (!class_exists('user')) {
    include_once "../../library/user.php";
    define('USER_INCLUDED', true);
}

// include the functions file if it has not been included
if (!function_exists('getNewDate')) {
    include_once "../../library/functions.php";
    define('FUNCTIONS_INCLUDED', true);
}

if (!class_exists('SMSTemplates')) {
    include_once "../../library/templates/SMSTemplates.php";
    define('SMSTEMPLATES_INCLUDED', true);

}


// create an instance of the MpesaService class
$mpesaService = new MpesaService();



// create an instance of the User class
$user = new user($dbSocket, $configValues);

// create an instance of the SMSTemplates class
$smsTemplates = new SMSTemplates();
$smsTemplates->setConfigValues($configValues);

// get the mpesa response
$mpesaResponse = file_get_contents('php://input');

// Check if the mpesaResponse is empty
if (empty($mpesaResponse)) {
    die("Mpesa response is empty");
}


$callbackData = $mpesaService->getTransactionDetails();

// Check if the callbackData is empty
if (empty($callbackData)) {
    die("Callback data is empty");
}


// get the BillRefNumber
$billRefNumber = $callbackData['BillRefNumber'];

// Get transacted amount
$transactedAmount = $callbackData['TransAmount'];

// set the user instance
$user->setUserInstance($billRefNumber);

// confirm if the user exists
if ($user->userExists()) {
    // Confirm the transaction
    // $mpesaService->validateTransaction(true);

    // get the user userbillinfo
    $userBillInfo = $user->getUserBillInfo();

    // get the user info
    $userInfo = $user->getUserInfo();

    // get the  user radius group
    $userRadiusGroup = $user->getUserRadiusGroup();

    // Get user Account Expiration Date
    $userAccountExpirationDate = $user->getUserAccountExpirationDate();

    //  Get user billing Plan
    $userBillingPlan = $user->getUserBillingPlan();
    

    // Get  user phone number from userBillInfo array
    $userPhoneNumber = isset($userBillInfo['phone']) ? $userBillInfo['phone'] : null;

    // Get user balance from userBillInfo array
    $userBalance = isset($userBillInfo['balance']) ? $userBillInfo['balance'] : 0;

    // Get user planCost from userBillingPlan array
    $userPlanCost = isset($userBillingPlan['planCost']) ? $userBillingPlan['planCost'] : 0;

    // Get user plan planTimeBank from userBillingPlan array this is in seconds
    $userPlanTimeBank = isset($userBillingPlan['planTimeBank']) ? $userBillingPlan['planTimeBank'] : 0;

    //Get new date after adding planTimeBank to userAccountExpirationDate
    $newDate = getNewDate($userAccountExpirationDate['timestamp'], $userPlanTimeBank);

 

    // check if transaction amount is equal to planCost
    if ($transactedAmount == $userPlanCost) {
        // Update user balance
        $balance = ($userBalance + $transactedAmount) - $userPlanCost;
       
        
    } else if ($transactedAmount > $userPlanCost) {
        // Update user balance
        $balance = ($userBalance + $transactedAmount) - $userPlanCost;
        
    } else if ($transactedAmount < $userPlanCost) {
       
        // Update user balance
        $new_amount = $userBalance + $transactedAmount;
        if ($new_amount >= $userPlanCost) {
            $balance = $new_amount - $userPlanCost;
        } else if ($new_amount < $userPlanCost) {
            $balance = $userPlanCost - $new_amount;
        }else {
            $balance = $userBalance;
        }

    }else {
        $balance = $userBalance;
       
    }
    // Update user balance
    $user->updateUserBalance($balance);

    // Update user account expiration date
    $user->updateUserAccountExpirationDate($newDate);

    // userinfo
    $userInfo = [
        'username' => $userInfo['username'],
        'phone' => $userBillInfo['phone'],
        'accountExpirationDate' => $newDate,
        'balance' => $balance,
    ];

    echo json_encode($userInfo);

    // Send SMS to user
    // $smsTemplates->setPhone($userPhoneNumber);
    // $smsTemplates->setUserInfo($userInfo);
    // $smsTemplates->sendAccountPlanRenewalSMS();

} else {
    // Reject the transaction
    $mpesaService->validateTransaction(false);
}

//
