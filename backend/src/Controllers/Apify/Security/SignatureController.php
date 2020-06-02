<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\SignatureController 
 * @file SignatureController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify\Security;

use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use App\Services\Apify\Security\SignatureService;

class SignatureController extends AppController
{

    /**
     * ruta:
     *  <dominio>/apify/sign
     */
    public function index()
    {
        $domain = $_SERVER["REMOTE_HOST"] ?? "";
        $oJson = new HelperJson();
        try{
            $oServ = new SignatureService($domain,$this->get_post());
            $token = $oServ->get_token();
            $oJson->set_payload([$token])->show();
        }
        catch (\Exception $e)
        {
            $oJson->set_code(HelperJson::CODE_INTERNAL_SERVER_ERROR)->
            set_error(["no sign possible"])->
            set_message($e->getMessage())->
            show(1);
        }

    }//index

    public function is_valid_signature()
    {
        $domain = $_SERVER["REMOTE_HOST"] ?? "";
        $oJson = new HelperJson();
        try{
            $oServ = new SignatureService($domain,$this->get_post());
            $token = $oServ->get_token();
            $oJson->set_payload([$token])->show();
        }
        catch (\Exception $e)
        {
            $oJson->set_code(HelperJson::CODE_INTERNAL_SERVER_ERROR)->
            set_error(["no sign possible"])->
            set_message($e->getMessage())->
            show(1);
        }

    }//index
    
}//SignatureController
