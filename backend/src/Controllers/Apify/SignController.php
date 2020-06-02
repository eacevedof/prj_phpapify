<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\SignController 
 * @file SignController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use TheFramework\Components\Session\ComponentEncdecrypt;

class SignController extends AppController
{

    private $encdec;

    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
        $this->encdec = new ComponentEncdecrypt();
    }

    /**
     * ruta:
     *  <dominio>/apify/sign
     */
    public function index()
    {
        $oJson = new HelperJson();

        if($iserror = 1)
            $oJson->set_code(HelperJson::CODE_INTERNAL_SERVER_ERROR)->
                    set_error(["no sign possible"])->
                    set_message("no signature generated")->
                    show(1);

        //$oJson->set_payload($arJson)->show();

    }//index
    
}//SignController
