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

    private static function get_dbconfig($arConfig,$i=0)
    {
        $arContext = $arConfig["ctx"]?? [];
        if(!$arContext) return [];

        $arDbconf = [
            //"type"=>$arContext["type"] ?? "",
            "server"=>$arContext["server"] ?? "",
            "port"=>$arContext["port"] ?? "3306",
            "database"=>$arContext["schemas"][$i]["database"] ?? "",
            "user"=>$arContext["schemas"][$i]["user"]?? "",
            "password"=>$arContext["schemas"][$i]["password"]?? ""
        ];
        //pr($arDbconf);
        return $arDbconf;
    }

    public static function get_dbobject_by_ctx(ComponentContext $oCtx)
    {
        //pr($oCtx,"octx");
        $arConfig = $oCtx->get_selected();
        $arConfig = self::get_dbconfig($arConfig);
        //bug($arConfig,"arconfig");die;
        if(!$arConfig) return new ComponentMysql();
        $oDb = new ComponentMysql($arConfig);
        return $oDb;
    }  

}//DbFactory
