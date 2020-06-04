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
    public function test_get_token_nok()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new LoginService("localhost:200",$post);
        $oServ->get_token();
    }

    public function test_get_token_ok()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new LoginService("*",$post);
        $token = $oServ->get_token();
        $this->assertNotEmpty($token);
    }

    public function test_is_valid_token_ok()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new LoginService("*",$post);
        $token = $oServ->get_token();
        $oServ = new LoginService("*");
        $isvalid = $oServ->is_valid($token);
        $this->assertTrue($isvalid);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Wrong token submitted
     */
    public function test_valid_token_nok()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new LoginService("*",$post);
        $token = $oServ->get_token();
        $token .= "xxxx";

        $oServ = new LoginService("*");
        $oServ->is_valid($token);
    }


    
}//LoginServiceTest