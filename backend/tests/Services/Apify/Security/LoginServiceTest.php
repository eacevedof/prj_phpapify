<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./tests/Services/Apify/Security/LoginServiceTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Services\Apify\Security\SignatureService;

$pathappboot = realpath(__DIR__ . "/../../../../boot/appbootstrap.php");
include_once($pathappboot);

class LoginServiceTest extends TestCase
{

    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_get_token()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new SignatureService("localhost:200",$post);
        $token = $oServ->get_token();
        $this->assertIsString($token);
    }


    
}//LoginServiceTest