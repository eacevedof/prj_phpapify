<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\TablesController 
 * @file TablesController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use App\Services\Apify\ContextService;
use App\Services\Apify\DbsService;
use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use App\Services\Apify\TablesService;

class TablesController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:    <dominio>/apify/tables/{id_context}/{database}
     * // ruta comentada: <dominio>/apify/tables/{id_context} en standby, para poder obtener unas tablas necesito contexto y database
     * Muestra los schemas
     */
    public function index()
    {
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("dbname");

        $oJson = new HelperJson();
        $oServ = new ContextService();

        //obligatorio
        if(!$oServ->is_context($idContext))
            $oJson->set_code(HelperJson::CODE_NOT_FOUND)->
            set_error("context does not exist")->
            show(1);

        if (!$oServ->is_db($idContext,$sDb))
            $oJson->set_code(HelperJson::CODE_NOT_FOUND)->
            set_error("no database in context 2")->
            show(1);

        $oServ = new TablesService($idContext,$sDb);
        $arJson = $oServ->get_all();

        if($oServ->is_error())
            $oJson->set_code(HelperJson::CODE_INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    set_message("database error")->
                    show(1);

        $oJson->set_payload($arJson)->show();
    }//index

}//TablesController
