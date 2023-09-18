<?php
// include once the config file
include_once "../config_read.php";

// include the MpesaService class
include_once "../library/services/MpesaService.php";

// include the User class
include_once "../library/user.php";



// create an instance of the MpesaService class
$mpesaService = new MpesaService();


// create an instance of the User class
$user = new user($dbSocket, $configValues);


// get the mpesa response
$mpesaResponse = file_get_contents('php://input');

$callbackData = $mpesaService->getTransactionDetails();

// get the BillRefNumber
$billRefNumber = $callbackData['BillRefNumber'];



// set the user instance
$user->setUserInstance($billRefNumber);

// confirm if the user exists
if ($user->userExists()) {
    // Confirm the transaction
    $mpesaService->validateTransaction(true);
} else {
    // Reject the transaction
    $mpesaService->validateTransaction(false);
}