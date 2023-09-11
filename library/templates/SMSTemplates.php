<?php

include_once  "../services/SMSService.php";


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
        $message = "Welcome to $systemName. Your username is $userName and your password is $password. Login at $appUrl" ;
        $this->smsService->sendSms($this->phone, $message);
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
        $this->smsService->sendSms($this->phone, $message);
    }

}

?>
<?php
//  test the class
$smsTemplates = new SMSTemplates(  ) ;
$smsTemplates->setPhone( "+25407585566" ) ;
$smsTemplates->setUserInfo( array( "username" => "testuser", "password" => "testpass", "accountExpirationDate" => "2019-12-12", "balance" => "1000" ) ) ;
$smsTemplates->setConfigValues( array( "SYSTEM_NAME" => "Test System", "APP_URL" => "http://localhost" ) ) ;
$smsTemplates->sendNewUserRegistrationSMS() ;
$smsTemplates->sendAccountPlanRenewalSMS() ;
?>