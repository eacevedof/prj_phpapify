<?php
namespace App\Services\Apify\Security;
use \Exception;
use TheFramework\Components\Formatter\ComponentMoment;
use TheFramework\Components\Config\ComponentConfig;
use TheFramework\Components\Session\ComponentEncdecrypt;

class LoginService
{
    private $domain = null;
    private $arlogin = null;
    /**
     * @var ComponentEncdecrypt
     */
    private $encdec = null;

    public function __construct($domain, $arlogin)
    {
        //necesito el dominio pq la encriptación va por dominio en el encdecrypt.json
        $this->domain = $domain;
        //el post con los datos de usuario
        $this->arlogin = $arlogin;
        $this->_load_encdec();
    }

    private function _get_encdec_config()
    {
        $sPathfile = $_ENV["APP_ENCDECRYPT"] ?? __DIR__.DIRECTORY_SEPARATOR."encdecrypt.json";
        $arconf = (new ComponentConfig($sPathfile))->get_node("domain",$this->domain);
        return $arconf;
    }

    private function _load_encdec()
    {
        $config = $this->_get_encdec_config();
        if(!$config)
            throw new \Exception("Domain {$this->domain} is not authorized");

        $this->encdec = new ComponentEncdecrypt(1);
        $this->encdec->set_sslmethod($config["sslenc_method"]??"");
        $this->encdec->set_sslkey($config["sslenc_key"]??"");
        $this->encdec->set_sslsalt($config["sslsalt"]??"");
    }

    private function _get_login_config()
    {
        $sPathfile = $_ENV["APP_LOGIN"] ?? __DIR__.DIRECTORY_SEPARATOR."login.json";
        $arconf = (new ComponentConfig($sPathfile))->get_node("domain",$this->domain);
        return $arconf;
    }

    public function checklogin_login()
    {
        $config = $this->_get_login_config();
        $users = $config["users"] ?? [];
        foreach ($users as $user)
        {
            $postpassw = $this->arlogin["password"] ?? "";
            $postusr = $this->arlogin["user"] ?? "";
            if($user["user"] === $postusr && $this->encdec->check_hashpassword($postpassw,$user["password"])) {
                return $this->get_token();
            }
        }
        return "";
    }

    private function _get_remote_ip()
    {
        return $_SERVER["REMOTE_ADDR"]  ?? "127.0.0.1";
    }

    public function get_token()
    {
        $package = [
            "domain"   => $this->domain,
            "remoteip" => $this->_get_remote_ip(),
            "username" => $this->arlogin["user"],
            "today"    => date("Ymd-His"),
        ];

        $instring = implode("|",$package);
        $token = $this->encdec->get_sslencrypted($instring);
        return $token;
    }

    private function validate_package($arpackage)
    {
        if(!$arpackage)
            throw new Exception("Wrong token submitted");

        list($domain,$remoteip,$username,$date) = $arpackage;

        if($domain!==$this->domain)
            throw new Exception("Domain {$this->domain} not Authorized");

        if($remoteip!==$this->_get_remote_ip())
            throw new Exception("Wrong source {$remoteip} in token");

        list($day) = explode("-",$date);
        $now = date("Ymd");
        $moment = new ComponentMoment($day);
        $ndays = $moment->get_ndays($now);
        if($ndays>30)
            throw new Exception("Token has expired");
    }


    public function is_valid($token)
    {
        $instring = $this->encdec->get_ssldecrypted($token);
        $package = explode("|",$instring);
        $this->validate_package($package);
        return true;
    }
}