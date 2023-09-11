<?php
// service to send SMS messages to users.

// Path: app/services/SMSService.php

class SMSService
{
    private $configValues;

    public function __construct()
    {
        // Load configuration
        include_once '../config_read.php';
        $this->configValues = $configValues;
    }

    public function sendSMS($phone, $message)
    {
        $smsGateway = $this->configValues['CONFIG_SMS_GATEWAY'];
        $response = null;

        switch ($smsGateway) {
            case 'clickatell':
                $response = $this->sendSMSClickatell($phone, $message);
                break;
            case 'twilio':
                $response = $this->sendSMSTwilio($phone, $message);
                break;
            case 'africastalking':
                $response = $this->sendSMSAfricastalking($phone, $message);
                break;
            case 'hostpinnacle':
                $response = $this->sendHostpinnacle($phone, $message);
                break;
            default:
                die("Unknown SMS gateway: $smsGateway");
        }
        
        return $response;
    }

    private function sendSMSClickatell($phone, $message)
    {
        $clickatellUser = $this->configValues['CONFIG_CLICKATELL_USER'];
        $clickatellPassword = $this->configValues['CONFIG_CLICKATELL_PASSWORD'];
        $clickatellApiId = $this->configValues['CONFIG_CLICKATELL_API_ID'];

        $url = "http://api.clickatell.com/http/sendmsg?user=$clickatellUser&password=$clickatellPassword&api_id=$clickatellApiId&to=$phone&text=$message";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        if ($result == false) {
            die("Error sending SMS: " . curl_error($ch));
        }
    }

    private function sendSMSTwilio($phone, $message)
    {
        $twilioAccountSid = $this->configValues['CONFIG_TWILIO_ACCOUNT_SID'];
        $twilioAuthToken = $this->configValues['CONFIG_TWILIO_AUTH_TOKEN'];
        $twilioFromNumber = $this->configValues['CONFIG_TWILIO_FROM_NUMBER'];

        $url = "https://api.twilio.com/2010-04-01/Accounts/$twilioAccountSid/SMS/Messages";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_USERPWD, "$twilioAccountSid:$twilioAuthToken");

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'From' => $twilioFromNumber,
            'To' => $phone,
            'Body' => $message,
        ));

        $result = curl_exec($ch);

        curl_close($ch);

        if ($result == false) {
            die("Error sending SMS: " . curl_error($ch));
        }
    }
    private function sendSMSAfricastalking($phone, $message)
    {
        // Set your app credentials
        $username = $this->configValues['CONFIG_AFRICASTALKING_USERNAME'];
        $apikey = $this->configValues['CONFIG_AFRICASTALKING_API_KEY'];

        // Initialize the SDK
        $AT = new AfricasTalking($username, $apikey);

        // Get the SMS service
        $sms = $AT->sms();

        // Set the numbers you want to send to in international format
        $recipients = $phone;

        // Set your message
        $message = $message;

        // Set your shortCode or senderId
        $from = $this->configValues['CONFIG_AFRICASTALKING_SHORTCODE'];

        try {
            // Thats it, hit send and we'll take care of the rest
            $result = $sms->send([
                'to' => $recipients,
                'message' => $message,
                'from' => $from,
            ]);

            print_r($result);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    private function sendHostpinnacle($phone, $message)
    {
        $username = $this->configValues['CONFIG_HOSTPINNACLE_USERNAME'];
        $password = $this->configValues['CONFIG_HOSTPINNACLE_PASSWORD'];
        $sender = $this->configValues['CONFIG_HOSTPINNACLE_SENDER'];
        $url = $this->configValues['CONFIG_HOSTPINNACLE_URL'];

        // GET request
        $url = $url . "?user=$username&password=$password&mobile=$phone&sender=$sender&message=$message&type=3";
        try {
            $message = rawurldecode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $res = curl_exec($ch);
            $curl_info = curl_getinfo($ch);

            if ($curl_info['http_code'] != 200) {
                throw new Exception($res);
            }
            curl_close($ch);
            return $res;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            throw new Exception($e->getMessage());
        }

    }

    public function sendSMSMessage($phone, $message)
    {

        return $this->sendSMS($phone, $message);
    }

    public function testsendsms($recp, $body, &$errmsg)
    {
        // enter your BulkSMS credentials here

        $api_host = 'https://bulksms.hostpinnacle.co.ke'; // regional BulkSMS
        $api_user = "sportieznet";
        $api_password = "g0UjvbJ7";
        $sender = "SPORTIEZNET";

        // clean up HTML entities

        $body = html_entity_decode($body, ENT_COMPAT, "UTF-8");

        // uncomment the following lines to see the SMS details

        //  print $recp . "<br>";
        //  print $body . "<br>";
        //  return true;

        // implement your own SMS gateway here

        $body = rawurlencode($body);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://$api_host/sendmessage.php?user=$api_user&password=$api_password&mobile=$recp&sender=$sender&message=$body&type=3");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);

        // uncomment the following line to see the result from the SMS gateway

        //  print $res;
        //  exit;

        $curl_info = curl_getinfo($ch);

        // detailed error logging (httpd error log)

        if ($res == false) {
            $errmsg = "sendsms cURL error: " . curl_error($ch);
            syslog(LOG_INFO, "[radiusmanager] " . $errmsg);
            return false;
        } elseif ($curl_info['http_code'] != 200) {
            $errmsg = "sendsms HTTP error code: " . $curl_info['http_code'];
            syslog(LOG_INFO, "[radiusmanager] " . $errmsg);
            return false;
        } else {
            $res = str_replace(str_split('{}"'), "", $res);
            $tokens = explode(",", $res);
            $errmsg = "ERR: " . $tokens[0] . ", " . $tokens[1];
        }

        curl_close($ch);

        // log result

        if ($tokens[0] == "status:failed") {
            $res_str = $errmsg;
        } else {
            $res_str = "OK";
        }

        syslog(LOG_INFO, "[radiusmanager] Sending SMS to " . $recp . " (" . $res_str . ")");

        // error has occured, return FALSE

        if ($tokens[0] == "status:failed") {
            return false;
        }

        // no error, return TRUE

        return true;
    }

}