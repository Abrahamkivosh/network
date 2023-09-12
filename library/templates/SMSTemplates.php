<?php

$path = "../../library/services/SMSService.php" ;
if( !file_exists( $path ) ) {
    die( "File not found" ) ;
}
if ( !class_exists( 'SMSService' ) ) {
    include_once $path ;
    define( 'SMSSERVICE_INCLUDED', true ) ;
}


class SMSTemplates {
    private $smsService ;
    private $phone ;
    private $userInfo ;
    private $configValues ;

    public function __construct(   )
    {
        $this->smsService = new SMSService() ;
    }

    public function setPhone( $phone )
    {
        $this->phone = $phone ;
    }

    public function setUserInfo( $userInfo )
    {
        $this->userInfo = $userInfo ;
    }

    public function setConfigValues( $configValues )
    {
        $this->configValues = $configValues ;
        $this->smsService->setConfigValues( $configValues ) ;
    }

    

    /**
     * Send new user registration SMS
     * Send When one registers for the first time 
     */
    public function sendNewUserRegistrationSMS()
    {
        $userName = $this->userInfo['username'] ;
        $password = $this->userInfo['password'] ;
        $systemName = $this->configValues['SYSTEM_NAME'] ;
        $appUrl = $this->configValues['APP_URL'] ;
        $fullName = $this->userInfo['fullName'] ;
        $paybillNumber = $this->configValues['PAYBILL_NUMBER'] ;
        $account_number = $userName ;
        $message = "Dear $fullName, Welcome to $systemName. Your username is $userName and password is $password. Please login at $appUrl. For Paybill, use $paybillNumber and account number $account_number. Thank you for using $systemName." ;
        return $this->smsService->sendSMSMessage($this->phone, $message);
    }

    

    /**
     * Send user when they renew their account plan
     * Send when one renews their account plan
     */
    public function sendAccountPlanRenewalSMS()
    {
        $userName = $this->userInfo['username'] ;
        $userAccountExpirationDate = $this->userInfo['accountExpirationDate'] ;
        $userBalance = $this->userInfo['balance'] ;
        $systemName = $this->configValues['SYSTEM_NAME'] ;
        $message = "Dear $userName, your account has been renewed. Your account will expire on $userAccountExpirationDate. Your new balance is $userBalance KES. Thank you for using $systemName." ;
        return $this->smsService->sendSMSMessage($this->phone, $message);
    }

    /**
     * Send user reminder to renew their account plan
     * Send when one has not renewed their account plan
     */
    public function sendAccountPlanRenewalReminderSMS()
    {
        $userName = $this->userInfo['username'] ;
        $userAccountExpirationDate = $this->userInfo['accountExpirationDate'] ;
        $systemName = $this->configValues['SYSTEM_NAME'] ;
        $plan = $this->userInfo['plan'] ;
        $paybillNumber = $this->configValues['PAYBILL_NUMBER'] ;
        $account_number = $userName ;
        $amount = $this->userInfo['amount'] ;
        $message = "Dear $userName, your account will be Due on $userAccountExpirationDate for the $plan plan. Paybill: $paybillNumber, A/C: $account_number Amount: $amount. Thank you for using $systemName." ;
        return $this->smsService->sendSMSMessage($this->phone, $message);
    }

    /**
     * Send user account suspension SMS
     */
    public function sendAccountSuspensionSMS(float $amount  = 0)
    {
        $userName = $this->userInfo['username'] ;
        $systemName = $this->configValues['SYSTEM_NAME'] ;
        $plan = $this->userInfo['plan'] ;
        $paybillNumber = $this->configValues['PAYBILL_NUMBER'] ;
        $account_number = $userName ;
        $amount = $amount == 0 ? $this->userInfo['amount'] : $amount ;
        $message = "Dear $userName, your account has been suspended. Please pay KES $amount to $paybillNumber A/C $account_number to reactivate your account. Thank you for using $systemName." ;
        return $this->smsService->sendSMSMessage($this->phone, $message);

    }



}

?>
