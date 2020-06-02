<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./tests/Services/EncdecryptTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Services\Apify\SignService;

$pathappboot = realpath(__DIR__."/../../boot/appbootstrap.php");
include_once($pathappboot);


class EncdecryptTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_get_token()
    {
        $post=["user"=>"fulanito","password"=>"menganito"];
        $oServ = new SignService("localhost:200",$post);
        $token = $oServ->get_token();
        print_r($token);
        $this->assertIsString($token);
    }

    

    
}//EncdecryptTest