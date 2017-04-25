<?php
namespace Moorper\Accessyou;

use GuzzleHttp\Client;

class Vercode
{
    const URL_HTTP = 'http://api.accessyou.com/sms/sendsms-vercode.php';

    protected $accountno = '';
    protected $user      = '';
    protected $pwd       = '';
    protected $msg       = '';
    protected $phone     = '';

    public function __construct($accountno, $user, $pwd)
    {
        $this->accountno = $accountno;
        $this->user      = $user;
        $this->pwd       = $pwd;
    }
    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    public function send()
    {
        $client   = new Client();
        $response = $client->request('GET', self::URL_HTTP, [
            'query' => [
                'accountno' => $this->accountno,
                'user'      => $this->user,
                'pwd'       => $this->pwd,
                'msg'       => $this->msg,
                'phone'     => $this->phone,
            ],
        ]);
        return $this->responseParse($response->getBody()->getContents());
    }
    public function responseParse($response)
    {
        $dom = new \DOMDocument;
        $dom->loadXML($response);
        $xml = simplexml_import_dom($dom);

        $msg_status      = (string) $xml->msg->msg_status;
        $msg_status_desc = (string) $xml->msg->msg_status_desc;
        $phoneno         = (string) $xml->msg->phoneno;
        $msg_id          = (string) $xml->msg->msg_id;

        return compact('msg_status', 'msg_status_desc', 'phoneno', 'msg_id');
    }
}
