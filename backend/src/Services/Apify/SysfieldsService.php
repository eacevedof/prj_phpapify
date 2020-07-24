<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file SysfieldsService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify;

use TheFramework\Components\Db\Context\ComponentContext;
use App\Services\AppService;
use App\Behaviours\SchemaBehaviour;
use App\Factories\DbFactory;

class SysfieldsService extends AppService
{
    private $usertable = "base_user";
    private $useruuidfield = "code_cache";

    private $useruuid = "";
    private $action = "";

    public function __construct($idContext="",$sDb="", $action="", $useruuid="")
    {
        $this->idContext = $idContext;
        $this->sDb = $sDb;
        $this->action = $action;
        $this->useruuid = $useruuid;

        $this->oContext = new ComponentContext($_ENV["APP_CONTEXTS"],$idContext);
        $oDb = DbFactory::get_dbobject_by_ctx($this->oContext, $sDb);
        $this->oBehav = new SchemaBehaviour($oDb);
    }
        
    private function _get_allfields()
    {
        $allfields = $this->oBehav->get_fields_info($this->usertable, $this->sDb);
        if(!$allfields) return [];
        return array_column($allfields,"field_name");
    }

    private function _get_table_user()
    {
        return $this->oBehav->get_table($this->usertable, $this->sDb);
    }

    private function _get_userid()
    {
        $sql = "SELECT id FROM $this->usertable WHERE $this->useruuidfield='$this->useruuid'";
        $id = $this->oBehav->query($sql,0,0);
        return $id;
    }

    private function _get_autofilled()
    {
        $action = $this->action;
        if($action==="deletelogic") $action = "delete";
        return [
            "{$action}_date" => date("YmdHis"),
            "{$action}_user" => $this->_get_userid(),
        ];
    }
    
    private function _get_sysfields()
    {
        $action = $this->action;
        return [
            "{$action}_date", "{$action}_user"
        ];
    }

    private function _exist_sysfields()
    {
        $allfields = $this->_get_allfields();
        $fields = $this->_get_sysfields();
        $fields[] = $this->useruuidfield;

        foreach ($fields as $sysfield)
            if(!in_array($sysfield, $allfields))
                return false;
        return true;
    }

    private function _isvalid()
    {
        if(!$this->action) return false;
        if(!$this->_get_table_user()) return false;
        if(!$this->_exist_sysfields()) return false;
    }

    public function get_by_action()
    {
        if(!$this->_isvalid()) return [];

        switch ($this->action){
            case "insert":
            case "update":
            case "deletelogic":
                return $this->_get_autofilled();
            break;
            default:
                return [];
        }
    }
    
}//SysfieldsService
