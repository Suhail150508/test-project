<?php

namespace App\SslWireless;

use GuzzleHttp\Client;

class SslWireless
{
    protected $client;
    protected $api_token;
    protected $api_username;
    protected $api_password;
    protected $sid;
    protected $csms_id;
    protected $msisdn;
    protected $sms;

    public function __construct()
    {
        $this->client = new client();
        $this->api_token = env('SSL_WIRELESS_API_TOKEN'); // d4abxvzq-yb5ptbly-vemkbuim-z8xq1ibq-uo2qlrej
        $this->api_username = env('SSL_WIRELESS_API_USERNAME'); // mahfuz
        $this->api_password = env('SSL_WIRELESS_API_PASSWORD'); // C5XzBV9
        $this->sid = env('SSL_WIRELESS_API_SID'); // EWU
        $this->csms_id = env('SSL_WIRELESS_API_CSMS_ID'); // 2934fe343
    }

    public function sendSms($to, $message)
    {
        $response = $this->client->post('https://smsplus.sslwireless.com/api/v3/send-sms', [
            'query' => [
                'api_token' => $this->api_token,
                'api_username' => $this->api_username,
                'api_password' => $this->api_password,
                'sid' => $this->sid,
                "csms_id" => $this->csms_id,
                'msisdn' => $to,
                'sms' => $message,
            ],
        ]);

        $responseBody = $response->getBody()->getContents();

        if ($responseBody == '1000') {
            return true; // SMS sent successfully
        } else {
            return false; // SMS sending failed
        }
    }


    // function singleSms($msisdn, $messageBody, $csmsId)
    // {
    //     $params = [
    //         "api_token" => $this->api_token,
    //         "sid" => $this->sid,
    //         "msisdn" => $msisdn,
    //         "sms" => $messageBody,
    //         "csms_id" => $csmsId
    //     ];
    //     $url = trim('https://smsplus.sslwireless.com', '/') . "/api/v3/send-sms";
    //     $params = json_encode($params);

    //     $this->callApi($url, $params);
    // }


    // function callApi($url, $params)
    // {
    //     $ch = curl_init(); // Initialize cURL
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'Content-Type: application/json',
    //         'Content-Length: ' . strlen($params),
    //         'accept:application/json'
    //     ));

    //     $response = curl_exec($ch);

    //     curl_close($ch);
    //     return $response;
    // }
}
