<?php

namespace App\Modules\Sms;

use GuzzleHttp\Client;

class SmsModule
{
    protected $client;
    protected $username;
    protected $header;
    protected $password;

    public function __construct()
    {
        $this->client = new Client([
            'decode_content' => false, // İçerik kodlamasını devre dışı bırak
        ]);
        $this->username = config('sms.username');
        $this->password = config('sms.password');
        $this->header = config('sms.header');
    }

    public function sendSms($gsm, $message)
    {
        $response = $this->client->post('https://api.senagsm.com.tr/api/smspost/v1', [
            'headers' => ['Content-Type' => 'text/xml; charset=UTF-8'],
            'body' => $this->generateSmsXml($gsm, $message)
        ]);

        return $response->getBody()->getContents();
    }

    public function checkCredit()
    {
        $response = $this->client->get('https://api.senagsm.com.tr/api/credit/v1', [
            'query' => [
                'username' => $this->username,
                'password' => $this->password
            ]
        ]);

        return $response->getBody()->getContents();
    }

    public function addToBlacklist($gsm)
    {
        $response = $this->client->get('https://api.senagsm.com.tr/api/blacklistadd/v1', [
            'query' => [
                'username' => $this->username,
                'password' => $this->password,
                'gsm' => $gsm
            ]
        ]);

        return $response->getBody()->getContents();
    }

    private function generateSmsXml($gsm, $message)
    {
        return "<sms>
                    <username>{$this->username}</username>
                    <password>{$this->password}</password>
                    <header>{$this->header}</header>
                    <validity>2880</validity>
                    <message>
                        <gsm>
                            <no>{$gsm}</no>
                        </gsm>
                        <msg><![CDATA[{$message}]]></msg>
                    </message>
                </sms>";
    }
}
