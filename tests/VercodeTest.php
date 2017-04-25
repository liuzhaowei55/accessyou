<?php
namespace Moorper\Accessyou\Tests;

use Moorper\Accessyou\Vercode;

class VercodeTest extends \PHPUnit_Framework_TestCase
{
    protected $vercode;
    public function __construct()
    {
        $accountno = '*********';
        $user      = '*********';
        $pwd       = '*********';

        $this->vercode = new Vercode($accountno, $user, $pwd);
    }
    public function testSend()
    {
        $msg   = '*********';
        $phone = '*********';

        $result = $this->vercode
            ->setMsg($msg)
            ->setPhone($phone)
            ->send();
        var_dump($result);
    }
    public function testResponseParse()
    {
        $response = '<?xml version="1.0"?><xml><msg><msg_status>100</msg_status><msg_status_desc>Successfully submitted message. 执行成功;</msg_status_desc><phoneno>*********</phoneno><msg_id>*********</msg_id></msg></xml>';

        $result = $this->vercode->responseParse($response);
        print_r($result);

    }
}
