<?php
// include once the config file
include_once "../config_read.php";

// include the MpesaService class
include_once "../library/services/MpesaService.php";

//  include SMS service class
include_once "../library/services/SmsService.php";

// include the User class
include_once "../library/models/User.php";


// create an instance of the MpesaService class
$mpesaService = new MpesaService();

// create an instance of the SmsService class
$smsService = new SmsService();

// create an instance of the User class
$user = new User();

