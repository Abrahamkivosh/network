<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '1024M');

// add headers to allow cross origin resource sharing (CORS) and content type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Accept: application/json');


// path: users/activation/confirmation.php

// Check if config_read.php has already been included
if (!defined('CONFIG_INCLUDED')) {
    require_once "../../library/config_read.php";
    define('CONFIG_INCLUDED', true);
}

// include the database connection file if it has not been included
if (!defined('OPENDB_INCLUDED')) {
    include_once "../../library/opendb.php";
    define('OPENDB_INCLUDED', true);
}

// include the MpesaService class if it has not been included
if (!class_exists('MpesaService')) {
    include_once "../../library/services/MpesaService.php";
    define('MPESASERVICE_INCLUDED', true);
}

// include the User class if it has not been included
if (!class_exists('User')) {
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
    echo json_encode(['error' => 'Mpesa response is empty']);
    die();
}

$callbackData = $mpesaService->getTransactionDetails();

// Check if the callbackData is empty
if (empty($callbackData)) {
    echo json_encode(['error' => 'Callback data is empty']);
    die();
}

// get the BillRefNumber
$billRefNumber = $callbackData['BillRefNumber'];

// Get transacted amount
$transactedAmount = $callbackData['TransAmount'];


// confirm if the user exists
if ($user->setUserNameFromAccountNumber($billRefNumber)) {
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


    $current_time = time();

    $smsTemplates->setPhone($userPhoneNumber);

    // Get user balance before adding transacted amount
    $current_balance = $user->getUserBalance();
    

    // check if invoice not paid
    $open_invoice = $user->getUserLatestInvoiceByStatus(['paid'], false);
    $invoice_exists = $open_invoice ? true : false;

    
    $payment_payload = [
        'amount' => $transactedAmount,
        'notes' => 'Payment for invoice',
        'type_id' => 1,
        'reference_no' => $callbackData['TransID'],
        'date' => date('Y-m-d H:i:s'),
        'transaction_id' => $callbackData['TransID'],
        'sender_name' => $callbackData['FirstName'] . ' ' . $callbackData['MiddleName'] . ' ' . $callbackData['LastName'],
        'status' => 1,
        'status_message' => 'Paid Via Mpesa',
        'sender_number' => $callbackData['MSISDN'],
    ];
    $newBalance = null ;

    if ($invoice_exists) {
        // create new payment for invoice
      
        $user->createUserInvoicePayments($open_invoice['id'], $payment_payload);

        $newBalance = $current_balance + $transactedAmount;
        // check if invoice balance is not negative
        if ($newBalance >= 0) {
            $invoice_status = 'paid';
        } else {
            $invoice_status = 'partial';
        }

        $user->updateUserInvoiceStatus($open_invoice['id'], $invoice_status);

    } else {
        // create invoice
        $invoice_payload = [
            "invoice_date" => date('Y-m-d H:i:s'),
            "status_id" => 1,
            "notes" => "Invoice for plan",
            "creationdate" => date('Y-m-d H:i:s'),
            "creationby" => $userBillInfo["username"],
            "type_id" => 1
        ];

        $invoice_id = $user->createUserInvoice($invoice_payload);
        // create new payment for invoice

    
        $user->createUserInvoicePayments($invoice_id, $payment_payload);

        $newBalance = $current_balance + $transactedAmount;
        // check if invoice balance is not negative
        $invoice_status = $newBalance >= 0 ? 'paid' : 'partial';

        $user->updateUserInvoiceStatus($invoice_id, $invoice_status);
    }
    // get

    // Update user balance getUserBalance()
    
    $user->updateUserBalance($newBalance);

    $smsTemplates->setUserInfo([
        'username' => $userInfo['username'],
        'accountExpirationDate' => $newDate,
        'balance' => $newBalance,
    ]);

    // if balance is positive, update user expiry date
    if ($newBalance >= 0) {
        if ( $userAccountExpirationDate['timestamp'] < $current_time ) {
            $user->updateUserAccountExpirationDate($newDate);
            // Send SMS to user
            $smsTemplates->sendAccountPlanRenewalSMS();
        }
        
    } else {
        // Check if account is expired
        $currentTimestamp = time();
        $accountExpirationTimestamp = $userAccountExpirationDate['timestamp'];
        if ($currentTimestamp > $accountExpirationTimestamp) { // Account is expired and payment is not enough to renew
            // Get Remaining Amount to renew account
            $remainingAmount = $userPlanCost - $newBalance;
            $smsTemplates->setUserInfo([
                'username' => $userInfo['username'], 'plan' => $userBillingPlan['planName'],
                'planCost' => $userBillingPlan['planCost'],'remainingAmount' => $remainingAmount,
            ]);
            // Send SMS to user
            $smsTemplates->sendAccountSuspensionSMS($remainingAmount);
            echo json_encode(['error' => 'Account is expired and payment is not enough to renew. ']);

        } else { // Account is not expired and payment is not enough to renew
            // Send SMS to user

            $remainingAmount = $userPlanCost - $newBalance;
            $smsTemplates->setUserInfo([
                'username' => $userInfo['username'],
                'plan' => $userBillingPlan['planName'],
                'planCost' => $userBillingPlan['planCost'],
                'remainingAmount' => $remainingAmount,
            
            ]);
            $smsTemplates->sendAccountPlanRenewalAmountNotEnoughToExtendExpiryDateSMS();

        }
    }

    // userinfo
    $userInfo = [
        'username' => $userInfo['username'],
        'phone' => $userBillInfo['phone'],
        'accountExpirationDate' => $newDate,
        'balance' => $newBalance,
        'planCost' => $userPlanCost
    ];


    // echo json_encode($userInfo);
    $mpesaService->validateTransaction(true);

} else {
    // Reject the transaction
    $mpesaService->validateTransaction(false);
}

//
