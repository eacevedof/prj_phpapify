<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file ContextService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify;

use App\Services\AppService;
use TheFramework\Components\Db\Context\ComponentContext;

class ContextService extends AppService
{
    private $oContext;

    public function __construct()
    {
        $this->oContext = new ComponentContext($_ENV["APP_CONTEXTS"]);
        //bug($this->oContext,"ContextService");
    }
    
    public function get_context_by_id($id){return $this->oContext->get_by("id", $id);}
    public function get_noconfig(){return $this->oContext->get_noconfig();}
    public function get_noconfig_by_id($id){return $this->oContext->get_noconfig_by("id",$id);}
    public function is_context($idContext)
    {
        $arContext = $this->oContext->get_by_id($idContext);
        //bug($arContext,"is_context");
        return !empty($arContext);
    }

    public function is_db($idContext,$dbname)
    {
        $arContext = $this->oContext->get_by_id($idContext);
        $this->logd($arContext,"is_db.arcontext ($dbname)");
        //pr($arContext);die;
        $schemas = $arContext[0]["schemas"] ?? [];
        foreach ($schemas as $arschema)
            if($arschema["database"] === $dbname)
                return true;

        return false;
    }

}//ContextService
