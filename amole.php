<?php

require 'vendor/autoload.php';


class Amole
{
    private $url;
    private $signature;
    private $ip_address;
    private $username;
    private $password;

    function __construct($url,
                         $signature,
                         $ip_address,
                         $username,
                         $password)
    {
        $this->url = $url;
        $this->signature = $signature;
        $this->ip_address = $ip_address;
        $this->username = $username;
        $this->password = $password;
    }

    function send_reqeust(
        $card_number,
        $merchant_id,
        $payment_action,
        $OTP = '',
        $amount = '',
        $expiration_date = '',
        $description = '',
        $source_transaction_id = '',
        $vendor_account = '',
        $additional_info_1 = '',
        $additional_info_2 = '',
        $additional_info_3 = '',
        $additional_info_4 = '')
    {
        $payload = [
            'BODY_CardNumber' => $card_number,
            'BODY_ExpirationDate' => $expiration_date,
            'BODY_PaymentAction' => $payment_action,
            'BODY_AmountX' => $amount,
            'BODY_PIN' => $OTP,
            'BODY_AmoleMerchantID' => $merchant_id,
            'BODY_OrderDescription' => $description,
            'BODY_SourceTransID' => $source_transaction_id,
            'BODY_VendorAccount' => $vendor_account,
            'BODY_AdditionalInfo1' => $additional_info_1,
            'BODY_AdditionalInfo2' => $additional_info_2,
            'BODY_AdditionalInfo3' => $additional_info_3,
            'BODY_AdditionalInfo4' => $additional_info_4
        ];

        $headers = [
            'HDR_Signature' => $this->signature,
            'HDR_IPAddress' => $this->ip_address,
            'HDR_UserName' => $this->username,
            'HDR_Password' => $this->password,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $client = new GuzzleHttp\Client();
        $response = $client->post($this->url, [
            'verify' => false,
            GuzzleHttp\RequestOptions::FORM_PARAMS => $payload,
            GUZZLEhTTP\RequestOptions::HEADERS => $headers
        ]);

        return $response;
    }

    function send_otp($card_number, $merchant_id)
    {
        return $this->send_reqeust($card_number, $merchant_id, '09');

    }

    function pay($card_number, $merchant_id, $OTP)
    {
        return $this->send_reqeust($card_number, $merchant_id, '01',$OTP);
    }

}

$fox = new Amole("https://uatc.api.myamole.com:8076/amole/pay",
    'UkI_nVLwxKRHa1CSBAIRBJK-7hCB7mjc4mS5mCC3XXyvlnN4u9lc6HQRq52qNOaOiRv_7r5-8OVb79nh83eM',
'196.188.54.245',
'eba', 'test');
$fox->send_otp('+251910867889', 'SERDOTRAVEL');