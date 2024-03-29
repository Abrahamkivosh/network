<?php

	require_once(dirname(__FILE__)."/../../notifications/processNotificationWelcome.php");
	
	if (!empty($email))
		$invoice_email = $email;
	else if (!empty($bi_emailinvoice))
		$invoice_email = $bi_emailinvoice;
	else if (!empty($bi_email))
		$invoice_email = $bi_email;
	else
		$invoice_email = "";
	
	if (!empty($mobilephone))
		$invoice_phone = $mobilephone;
	else if (!empty($workphone))
		$invoice_phone = $workphone;
	else if (!empty($homephone))
		$invoice_phone = $homephone;
	else
		$invoice_phone = "Unavailable";
		
	$invoice_address = "";
	if (!empty($ui_address))
		$invoice_address = $ui_address;
	
	if (!empty($ui_city))
		$invoice_address .= ", ".$ui_city;
	
	if (!empty($ui_state))
		$invoice_address .= "<br/>".$ui_state;
	
	if (!empty($ui_zip))
		$invoice_address .= " ".$ui_zip;
	
	if (empty($invoice_address))
		$invoice_address = "Unavailable";
	
	$customerInfo = array();
	$customerInfo['customer_name'] = $firstname ." ".$lastname;
	$customerInfo['customer_address'] = $invoice_address;
	
	$customerInfo['customer_phone'] = $invoice_phone;
	$customerInfo['customer_email'] = $invoice_email;
	$customerInfo['service_plan_name'] = $planName;
	

// Create the SMTP connection parameters
$smtpParams = array(
    'host' => $configValues['CONFIG_MAIL_SMTPADDR'],
    'port' => $configValues['CONFIG_MAIL_SMTPPORT'],
    'auth' =>  $configValues['CONFIG_MAIL_SMTPAUTH'],
    'username' => $configValues['CONFIG_MAIL_SMTPUSERNAME'],
    'password' => $configValues['CONFIG_MAIL_SMTPPASSWORD'],
    'tls' => $configValues['CONFIG_MAIL_SMTPtls']
);
	
	@sendWelcomeNotification($customerInfo, $smtpParams, $from);

?>