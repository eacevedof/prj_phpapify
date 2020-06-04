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

    public function __construct($domain, $arlogin=[])
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
        //print($sPathfile);die;
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

    private function _get_login_config($domain="")
    {
        if(!$domain) $domain = $this->domain;
        $sPathfile = $_ENV["APP_LOGIN"] ?? __DIR__.DIRECTORY_SEPARATOR."login.json";
        $arconfig = (new ComponentConfig($sPathfile))->get_node("domain",$domain);
        return $arconfig;
    }

    private function _user_exists($domain, $username)
    {
        $arconfig = $this->_get_login_config($domain);
        //print_r($arconfig);die;
        foreach($arconfig["users"] as $aruser)
            if($aruser["user"] === $username)
                return true;

        return false;
    }

    private function _get_user_password($domain, $username)
    {
        $arconfig = $this->_get_login_config($domain);
        foreach($arconfig["users"] as $aruser)
            if($aruser["user"] === $username)
                return $aruser["password"] ?? "";

        return false;
    }

    private function _get_remote_ip()
    {
        return $_SERVER["REMOTE_ADDR"]  ?? "127.0.0.1";
    }

    private function _get_data_tokenized()
    {
        $username = $this->arlogin["user"] ?? "";
        $package = [
            "domain"   => $this->domain,
            "remoteip" => $this->_get_remote_ip(),
            "username" => $username,
            "password" => md5($this->_get_user_password($this->domain, $username)),
            "today"    => date("Ymd-His"),
        ];

        $instring = implode("|",$package);
        $token = $this->encdec->get_sslencrypted($instring);
        return $token;
    }

    public function get_token()
    {
        $username = $this->arlogin["user"] ?? "";
        $password = $this->arlogin["password"] ?? "";
        if(!$username)
            throw new \Exception("No user provided");

        if(!$password)
            throw new \Exception("No password provided");

        $config = $this->_get_login_config();
        $users = $config["users"] ?? [];
        foreach ($users as $user)
        {
            //$hashpass = $this->encdec->get_hashpassword($postpassw);
            //print_r($hashpass);die;
            if($user["user"] === $username && $this->encdec->check_hashpassword($password,$user["password"])) {
                return $this->_get_data_tokenized();
            }
        }
        throw new \Exception("Bad user or password");
    }

    private function validate_package($arpackage)
    {
        //print_r($arpackage);
        if(count($arpackage)!==5)
            throw new Exception("Wrong token submitted");

        list($domain,$remoteip,$username,$password,$date) = $arpackage;

        if($domain!==$this->domain)
            throw new Exception("Domain {$this->domain} not Authorized");

        if($remoteip!==$this->_get_remote_ip())
            throw new Exception("Wrong source {$remoteip} in token");

        $md5pass = $this->_get_user_password($domain,$username);
        $md5pass = md5($md5pass);
        if($md5pass!==$password)
            throw new Exception("Wrong user or password submitted");

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
        //print_r($instring);die;
        $package = explode("|",$instring);
        $this->validate_package($package);
        return true;
    }
}