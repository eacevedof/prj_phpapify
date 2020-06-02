<?php
namespace App\Services\Apify;

use TheFramework\Components\Session\ComponentEncdecrypt;
class SignService
{
    private $tosign = null;
    private $encdecrypt = null;

    public function __construct()
    {

    }

    public function to_sign($mxvar)
    {
        $this->tosign = $mxvar;
        return $this;
    }
}