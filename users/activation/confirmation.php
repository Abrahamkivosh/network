<?php
// include once the config file
include_once "../config_read.php";

// include the database connection file
include_once "../library/opendb.php";

// include the MpesaService class
include_once "../library/services/MpesaService.php";

//  include SMS service class
include_once "../library/services/SmsService.php";

// include the User class
include_once "../library/user.php";

// include the functions file
include_once "../library/functions.php";

// include the SMSTemplates class
include_once "../library/templates/SMSTemplates.php";

// create an instance of the MpesaService class
$mpesaService = new MpesaService();

// create an instance of the SmsService class
$smsService = new SmsService();

// create an instance of the User class
$user = new user($dbSocket, $configValues);

// create an instance of the SMSTemplates class
$smsTemplates = new SMSTemplates($smsService);

// get the mpesa response
$mpesaResponse = file_get_contents('php://input');

$callbackData = $mpesaService->getTransactionDetails();

// get the BillRefNumber
$billRefNumber = $callbackData['BillRefNumber'];

// Get transacted amount
$transactedAmount = $callbackData['TransAmount'];

// set the user instance
$user->setUserInstance($billRefNumber);

// confirm if the user exists
if ($user->userExists()) {
    // Confirm the transaction
    $mpesaService->validateTransaction(true);

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
    $userPlanCost = isset($userBillingPlan['planCost']) ? $userBillingPlan['cost'] : 0;

    // Get user plan planTimeBank from userBillingPlan array this is in seconds
    $userPlanTimeBank = isset($userBillingPlan['planTimeBank']) ? $userBillingPlan['planTimeBank'] : 0;

    //Get new date after adding planTimeBank to userAccountExpirationDate
    $newDate = getNewDate($userAccountExpirationDate, $userPlanTimeBank);

    // check if transaction amount is equal to planCost
    if ($callbackData['TransAmount'] == $userPlanCost) {
        // Update user account expiration date
        $user->updateUserAccountExpirationDate($newDate);

        // userinfo
        $userInfo = [
            'username' => $userInfo['username'],
            'phone' => $userInfo['phone'],
            'accountExpirationDate' => $newDate,
            'balance' => $userBalance,
        ];

        // Send SMS to user
        $smsTemplates->setPhone($userPhoneNumber);
        $smsTemplates->setUserInfo($userInfo);
        $smsTemplates->sendAccountPlanRenewalSMS();

    } else if ($callbackData['TransAmount'] > $userPlanCost) {
        // Update user account expiration date
        $user->updateUserAccountExpirationDate($newDate);

        // Update user balance
        $balance = ($userBalance + $transactedAmount) - $userPlanCost;
        $user->updateUserBalance($balance);

        // userinfo
        $$userInfo = [
            'username' => $userInfo['username'],
            'phone' => $userInfo['phone'],
            'accountExpirationDate' => $newDate,
            'balance' => $balance,
        ];

        // Send SMS to user
        $smsTemplates->setPhone($userPhoneNumber);
        $smsTemplates->setUserInfo($userInfo);
        $smsTemplates->sendAccountPlanRenewalSMS();

        // Send SMS to admin
    } else {
        // Update user balance
        $balance = ($userBalance + $transactedAmount) - $userPlanCost;
        $user->updateUserBalance($balance);

        // Update user account expiration date
        $user->updateUserAccountExpirationDate($newDate);

        // userinfo
        $userInfo = [
            'username' => $userInfo['username'],
            'phone' => $userInfo['phone'],
            'accountExpirationDate' => $newDate,
            'balance' => $balance,
        ];

        // Send SMS to user
        $smsTemplates->setPhone($userPhoneNumber);
        $smsTemplates->setUserInfo($userInfo);
        $smsTemplates->sendAccountPlanRenewalSMS();

        // Send SMS to admin
    }

} else {
    // Reject the transaction
    $mpesaService->validateTransaction(false);
}

//
