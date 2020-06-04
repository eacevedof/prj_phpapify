<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\LoginController
 * @file LoginController.php 1.0.0
 * @date 03-06-2020 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify\Security;

use App\Services\Apify\Security\LoginService;
use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;

class LoginController extends AppController
{

    /**
     * ruta:
     *  <dominio>/apifiy/security/login
     */
    public function index()
    {
        $domain = $_SERVER["REMOTE_HOST"] ?? "*";
        $this->logd($domain,"login.index.domain");
        //$this->request_log();
        $oJson = new HelperJson();
        try{
            $oServ = new LoginService($domain,$this->get_post());
            $token = $oServ->get_token();
            $oJson->set_payload(["result"=>$token])->show();
        }
        catch (\Exception $e)
        {
            $oJson->set_code(HelperJson::CODE_UNAUTHORIZED)->
            set_error([$e->getMessage()])->
            show(1);
        }
    }

    /**
     * ruta:
     *  <dominio>/apifiy/security/is-valid-token
     */
    public function is_valid_token()
    {
        $domain = $_SERVER["REMOTE_HOST"] ?? "*";
        $this->logd($domain,"login.is_valid_token.domain");
        $oJson = new HelperJson();
        try{
            $token = $this->get_header("apify-auth");
            $this->logd($token,"login.is_valid_token.header");
            $oServ = new LoginService($domain);
            $oServ->is_valid($token);
            $oJson->set_payload(["result"=>true])->show();
        }
        catch (\Exception $e)
        {
            $oJson->set_code(HelperJson::CODE_FORBIDDEN)->
            set_error([$e->getMessage()])->
            show(1);
        }
    }
}//LoginController
