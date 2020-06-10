<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file ReaderService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify\Rw;

use TheFramework\Components\Db\Context\ComponentContext;
use TheFramework\Components\Db\ComponentCrud;
use App\Services\AppService;
use App\Behaviours\SchemaBehaviour;
use App\Factories\DbFactory;


class ReaderService extends AppService
{
    private $idContext;
    private $sDb;
    
    private $oContext;
    private $oBehav;
    private $sSQL;
    
    public function __construct($idContext="",$sDb="") 
    {
        $this->idContext = $idContext;
        $this->sDb = $sDb;
        
        if(!$this->idContext) return $this->add_error("Error in context: $idContext");
        $this->oContext = new ComponentContext($_ENV["APP_CONTEXTS"],$idContext);
        
        $oDb = DbFactory::get_dbobject_by_ctx($this->oContext,$sDb);
        if($oDb->is_error()) return $this->add_error($oDb->get_errors());

        $this->oBehav = new SchemaBehaviour($oDb);
    }
    
    private function get_parsed_tosql($arParams)
    {
        //pr($arParams,"get_parsed_tosql");die;
        $oCrud = new ComponentCrud();
        if(!isset($arParams["table"])) $this->add_error("get_sql no table");
        if(!isset($arParams["fields"]) || !is_array($arParams["fields"])) $this->add_error("get_sql no fields");
        if($this->isError) return;

        $oCrud->set_table($arParams["table"]);
        if(isset($arParams["distinct"])) $oCrud->is_distinct($arParams["distinct"]);
        if(isset($arParams["foundrows"])) $oCrud->is_foundrows($arParams["foundrows"]);

        $oCrud->set_getfields($arParams["fields"]);
        $oCrud->set_joins($arParams["joins"]??[]);
        $oCrud->set_and($arParams["where"]??[]);
        $oCrud->set_groupby($arParams["groupby"]??[]);
        $oCrud->set_having($arParams["having"]??[]);

        $arTmp = [];
        if(isset($arParams["orderby"]))
        {
            foreach($arParams["orderby"] as $sField)
            {
                $arField = explode(" ",trim($sField));
                $arTmp[$arField[0]] = $arField[1] ?? "ASC";
            }
        }
        //pr($oCrud);die;
        $oCrud->set_orderby($arTmp);

        if(isset($arParams["limit"]["perpage"]))
            $oCrud->set_limit($arParams["limit"]["perpage"] ?? 1000,$arParams["limit"]["regfrom"]??0);

        $oCrud->get_selectfrom();
        $sql =  $oCrud->get_sql();
        //pr($sql,"sql");
        return $sql;
    }

    public function read_raw($sSQL)
    {
        if(!$sSQL) return [];
        $this->sSQL = $sSQL;
        $r = $this->oBehav->read_raw($sSQL);   
        if($this->oBehav->is_error())
            $this->add_error($this->oBehav->get_errors());
        return $r;
    }
    
    public function get_read($arParams)
    {
        if(!$arParams)
            return $this->add_error("get_read No params");
        $sSQL = $this->get_parsed_tosql($arParams);
        $this->sSQL = $sSQL;
        $r = $this->read_raw($sSQL);
        return $r;
    }

    public function get_foundrows($arParams)
    {
        $isFoundrows = $arParams["foundrows"] ?? 0;
        if(!$isFoundrows) return null;

        $sSQL = "SELECT FOUND_ROWS()";
        $r = $this->read_raw($sSQL);
        return $r;
    }
    
    public function get_sql(){return $this->sSQL;}

}//ReaderService
