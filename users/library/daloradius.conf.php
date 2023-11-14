<?php

// display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Path: library/daloradius.conf.php
// autoload vendor classes if not already included
if (!defined('VENDOR_AUTOLOAD_INCLUDED')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
    define('VENDOR_AUTOLOAD_INCLUDED', true);
}
// read
if (!defined('READ_ENV_FILE_INCLUDED')) {
    require_once __DIR__ . '/../../read_env_file.php';
    define('READ_ENV_FILE_INCLUDED', true);
}

if (!defined('VERSION_INCLUDED')) {
    require_once __DIR__ . '/../../library/version.php';
    define('VERSION_INCLUDED', true);
}

$configValues['SYSTEM_NAME'] = getenv ('SYSTEM_NAME');
$configValues['TIMEZONE'] = 'Africa/Nairobi';
$configValues['APP_URL'] = getenv ('BASE_URL');
$configValues['FREERADIUS_VERSION'] = '2';
$configValues['CONFIG_DB_ENGINE'] = getenv ('CONFIG_DB_ENGINE');
$configValues['CONFIG_DB_HOST'] = getenv ('CONFIG_DB_HOST');
$configValues['CONFIG_DB_PORT'] = getenv ('CONFIG_DB_PORT');
$configValues['CONFIG_DB_USER'] = getenv ('CONFIG_DB_USER');
$configValues['CONFIG_DB_PASS'] = getenv ('CONFIG_DB_PASS');
$configValues['CONFIG_DB_NAME'] = getenv ('CONFIG_DB_NAME');
$configValues['CONFIG_DB_TBL_RADCHECK'] = 'radcheck';
$configValues['CONFIG_DB_TBL_RADREPLY'] = 'radreply';
$configValues['CONFIG_DB_TBL_RADGROUPREPLY'] = 'radgroupreply';
$configValues['CONFIG_DB_TBL_RADGROUPCHECK'] = 'radgroupcheck';
$configValues['CONFIG_DB_TBL_RADUSERGROUP'] = 'radusergroup';
$configValues['CONFIG_DB_TBL_RADNAS'] = 'nas';
$configValues['CONFIG_DB_TBL_RADHG'] = 'radhuntgroup';
$configValues['CONFIG_DB_TBL_RADPOSTAUTH'] = 'radpostauth';
$configValues['CONFIG_DB_TBL_RADACCT'] = 'radacct';
$configValues['CONFIG_DB_TBL_RADIPPOOL'] = 'radippool';
$configValues['CONFIG_DB_TBL_DALOOPERATORS'] = 'operators';
$configValues['CONFIG_DB_TBL_DALOOPERATORS_ACL'] = 'operators_acl';
$configValues['CONFIG_DB_TBL_DALOOPERATORS_ACL_FILES'] = 'operators_acl_files';
$configValues['CONFIG_DB_TBL_DALORATES'] = 'rates';
$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'] = 'hotspots';
$configValues['CONFIG_DB_TBL_DALOUSERINFO'] = 'userinfo';
$configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'] = 'userbillinfo';
$configValues['CONFIG_DB_TBL_DALODICTIONARY'] = 'dictionary';
$configValues['CONFIG_DB_TBL_DALOREALMS'] = 'realms';
$configValues['CONFIG_DB_TBL_DALOPROXYS'] = 'proxys';
$configValues['CONFIG_DB_TBL_DALOBILLINGPAYPAL'] = 'billing_paypal';
$configValues['CONFIG_DB_TBL_DALOBILLINGMERCHANT'] = 'billing_merchant';
$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'] = 'billing_plans';
$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'] = 'billing_rates';
$configValues['CONFIG_DB_TBL_DALOBILLINGHISTORY'] = 'billing_history';
$configValues['CONFIG_DB_TBL_DALOBATCHHISTORY'] = 'batch_history';
$configValues['CONFIG_DB_TBL_DALOBILLINGPLANSPROFILES'] = 'billing_plans_profiles';
$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICE'] = 'invoice';
$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICEITEMS'] = 'invoice_items';
$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICESTATUS'] = 'invoice_status';
$configValues['CONFIG_DB_TBL_DALOBILLINGINVOICETYPE'] = 'invoice_type';
$configValues['CONFIG_DB_TBL_DALOPAYMENTS'] = 'payment';
$configValues['CONFIG_DB_TBL_DALOPAYMENTTYPES'] = 'payment_type';
$configValues['CONFIG_DB_TBL_DALONODE'] = 'node';
$configValues['CONFIG_FILE_RADIUS_PROXY'] = '/etc/freeradius/proxy.conf';
$configValues['CONFIG_PATH_RADIUS_DICT'] = '';
$configValues['CONFIG_PATH_DALO_VARIABLE_DATA'] = '/var/www/daloradius/var';
$configValues['CONFIG_DB_PASSWORD_ENCRYPTION'] = 'cleartext';
$configValues['CONFIG_LANG'] = 'en';
$configValues['CONFIG_LOG_PAGES'] = 'no';
$configValues['CONFIG_LOG_ACTIONS'] = 'no';
$configValues['CONFIG_LOG_QUERIES'] = 'no';
$configValues['CONFIG_DEBUG_SQL'] = 'no';
$configValues['CONFIG_DEBUG_SQL_ONPAGE'] = 'no';
$configValues['CONFIG_LOG_FILE'] = '/tmp/daloradius.log';
$configValues['CONFIG_IFACE_PASSWORD_HIDDEN'] = 'no';
$configValues['CONFIG_IFACE_TABLES_LISTING'] = '25';
$configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] = 'yes';
$configValues['CONFIG_IFACE_AUTO_COMPLETE'] = 'yes';
$configValues['CONFIG_MAINT_TEST_USER_RADIUSSERVER'] = '127.0.0.1';
$configValues['CONFIG_MAINT_TEST_USER_RADIUSPORT'] = '1812';
$configValues['CONFIG_MAINT_TEST_USER_NASPORT'] = '0';
$configValues['CONFIG_MAINT_TEST_USER_RADIUSSECRET'] = 'testing123';
$configValues['CONFIG_USER_ALLOWEDRANDOMCHARS'] = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
$configValues['CONFIG_MAIL_SMTPADDR'] = '127.0.0.1';
$configValues['CONFIG_MAIL_SMTPPORT'] = '25';
$configValues['CONFIG_MAIL_SMTPAUTH'] = '';
$configValues['CONFIG_MAIL_SMTPFROM'] = 'root@daloradius.xdsl.by';
$configValues['CONFIG_DASHBOARD_DALO_SECRETKEY'] = 'sillykey';
$configValues['CONFIG_DASHBOARD_DALO_DEBUG'] = '1';
$configValues['CONFIG_DASHBOARD_DALO_DELAYSOFT'] = '5';
$configValues['CONFIG_DASHBOARD_DALO_DELAYHARD'] = '15';

// invoice templates - optional
$configValues['CONFIG_INVOICE_TEMPLATE'] = 'invoice_template.html';
$configValues['CONFIG_INVOICE_ITEM_TEMPLATE'] = 'invoice_item_template.html';

// Hostpinnacle SMS Gateway
$configValues['CONFIG_SMS_GATEWAY'] = 'hostpinnacle';
$configValues['CONFIG_HOSTPINNACLE_USERNAME'] = '';
$configValues['CONFIG_HOSTPINNACLE_PASSWORD'] = '';
$configValues['CONFIG_HOSTPINNACLE_SENDER'] = 'SPORTIEZNET';
$configValues['CONFIG_HOSTPINNACLE_URL'] = 'https://bulksms.hostpinnacle.co.ke/sendmessage.php';

// Africas Talking SMS Gateway
$configValues['CONFIG_SMS_GATEWAY'] = 'africastalking';
$configValues['CONFIG_AFRICASTALKING_USERNAME'] = getenv('CONFIG_AFRICASTALKING_USERNAME');
$configValues['CONFIG_AFRICASTALKING_API_KEY'] = getenv('CONFIG_AFRICASTALKING_API_KEY');



$configValues['PEAR_PATH'] = getenv('PEAR_PATH');


 // Mpesa Gateway
 $configValues['CONFIG_MPESA_CONSUMER_KEY'] = 'EcRoSKtOdBHfEPzo6gwPLyHhp6etgOjz';
 $configValues['CONFIG_MPESA_CONSUMER_SECRET'] = 'bb4nKUEYIAtxMVeK';
 $configValues['CONFIG_MPESA_SHORTCODE'] = '600995';
 $configValues['CONFIG_MPESA_CONFIRMATION_URL'] = $configValues['APP_URL'] . '/users/activation/confirmation.php';
 $configValues['CONFIG_MPESA_VALIDATION_URL'] = $configValues['APP_URL'] . '/users/activation/validation.php';
 $configValues['CONFIG_MPESA_REGISTER_URL'] = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
 $configValues['CONFIG_MPESA_LNM_URL'] = '';
 $configValues['CONFIG_MPESA_LNM_CALLBACK_URL'] = '';
 $configValues['CONFIG_MPESA_LNM_PASSKEY'] = '';
$configValues['PAYBILL_NUMBER'] =  $configValues['CONFIG_MPESA_SHORTCODE'] ;




ini_set('error_log', $configValues['CONFIG_LOG_FILE']);
ini_set('log_errors', '1') ;

//  set timezone
date_default_timezone_set($configValues['TIMEZONE']);

//  set locale
setlocale(LC_ALL, $configValues['CONFIG_LANG']);

//  set debug mode
if ($configValues['CONFIG_DEBUG_SQL'] == 'yes') {
    $debug = true;
} else {
    $debug = false;
}
