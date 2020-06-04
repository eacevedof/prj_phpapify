<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./tests/Services/Apify/Security/LoginServiceTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Services\Apify\Security\LoginService;

$pathappboot = realpath(__DIR__ . "/../../../../boot/appbootstrap.php");
include_once($pathappboot);

class LoginServiceTest extends TestCase
{

    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Source domain not authorized
     */
    public function test_get_token()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new LoginService("localhost:200",$post);
        $oServ->get_token();
    }


    
}//LoginServiceTest