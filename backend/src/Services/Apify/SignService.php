<?php
namespace App\Services\Apify;
use Matrix\Exception;
use TheFramework\Components\Session\ComponentEncdecrypt;

class SignService
{
    private $domain = null;
    private $data = null;
    /**
     * @var ComponentEncdecrypt
     */
    private $encdec = null;

    public function __construct($domain,$data)
    {
        $this->domain = $domain;
        $this->data = $data;
        $this->_load_encdec();
    }

    private function _load_encdec()
    {
        $config = $this->_get_config($this->domain);
        if(!$config)
            throw new \Exception("No config found for domain: $config");

        $this->encdec = new ComponentEncdecrypt(1);
        $this->encdec->set_sslmethod($config["sslenc_method"]??"");
        $this->encdec->set_sslkey($config["sslenc_key"]??"");
        $this->encdec->set_sslsalt($config["sslsalt"]??"");
    }

    private function _get_config()
    {
        $sPathfile = $_ENV["APP_ENCDECRYPT"] ?? __DIR__.DIRECTORY_SEPARATOR."encdecrypt.json";
        if(!is_file($sPathfile)) {
            throw new \Exception("No encdecrypt file found: $sPathfile");
        }
        $sJson = file_get_contents($sPathfile);
        $arconfig = json_decode($sJson,1);
        foreach ($arconfig as $arconf)
        {
            if($arconf["domain"]===$this->domain)
                return $arconfig;
        }
        return [];
    }

    private function to_string($data)
    {
        if(is_string(data))
            return data;
        return var_export(data,1);
    }

    public function get_token()
    {
        $data = var_export($this->data,1);
        $package = [
            "domain"   => $this->domain,
            "remoteip" => $_SERVER["REMOTE_ADDR"],
            "hash"     => md5($data),
            "today"    => date("Ymd"),
        ];

        $instring = implode("-",$package);
        //$instring = $this->to_string($data);
        $token = $this->encdec->get_sslencrypted($instring);
        return $token;
    }

    private function validate_package($arpackage)
    {
        $data = var_export($this->data,1);
        $md5 = md5($data);

        if(!$arpackage)
            throw new Exception("Wrong token submitted");

        if($arpackage[0]!==$this->domain)
            throw new Exception("Domain {$this->domain} not Authorized");

        if($arpackage[1]!==$_SERVER["REMOTE_ADDR"])
            throw new Exception("Wrong source {$arpackage[0]} in token");

        if($arpackage[2]!==$md5)
            throw new Exception("Wrong hash submitted");

        if($arpackage[3]!==date("Ymd"))
            throw new Exception("token has expired");

    }

    public function is_valid($token)
    {
        $instring = $this->encdec->get_ssldecrypted($token);
        $package = explode("-",$instring);
        $this->validate_package($package);
        return true;
    }
}