<?php


// include the config file
include_once "../library/config_read.php";


// include MpesaService class
$mpesaFile =  "../../library/services/MpesaService.php";

// check if the MpesaService file exists
if (!file_exists($mpesaFile)) {
    die("MpesaService file not found");
}
include_once $mpesaFile;


// create an instance of the MpesaService class
$mpesaService = new MpesaService();
$mpesaService->setConfigValues($configValues);

// // call the registerURLs method
$response = $mpesaService->registerURLs();

// // print the response
echo "<pre>";
print_r($response);
echo "</pre>";