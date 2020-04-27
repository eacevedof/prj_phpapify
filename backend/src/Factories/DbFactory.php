<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Factories\DbFactory 
 * @file DbFactory.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Factories;

use TheFramework\Components\Db\ComponentMysql;
use TheFramework\Components\Db\Context\ComponentContext;

class DbFactory 
{

    public static function get_dbobject_by_ctx(ComponentContext $oCtx)
    {
        //pr($oCtx,"octx");
        $arConfig = $oCtx->get_selected();
        $arConfig = $arConfig["ctx"]["config"] ?? [];
        //pr($arConfig,"dbfactory.arconfig");die;
        $oDb = new ComponentMysql();
        if(!$arConfig)
            return $oDb;
        $oDb->add_conn("server",$arConfig["server"]);
        $oDb->add_conn("port",$arConfig["port"]);
        $oDb->add_conn("database",$arConfig["database"]);
        $oDb->add_conn("user",$arConfig["user"]);
        $oDb->add_conn("password",$arConfig["password"]);
        return $oDb;
    }  
    
    public static function get_dbobject_by_idctx($id)
    {
        //pr(\App\Services\$_ENV["APP_CONTEXTS"]);die;
        $oCtx = new ComponentContext("",$id);
        $arConfig = $oCtx->get_config_by("id",$id);
        //pr($arConfig,"DbFactory.get_dbobject_by_idctx id:$id ");die;
        $oDb = new ComponentMysql();
        $oDb->add_conn("server",$arConfig["server"]);
        $oDb->add_conn("port",$arConfig["port"]);
        $oDb->add_conn("database",$arConfig["database"]);
        $oDb->add_conn("user",$arConfig["user"]);
        $oDb->add_conn("password",$arConfig["password"]);
        return $oDb;
    }
    
}//DbFactory