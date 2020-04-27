<?php
//index.php 4.0.0
define("DS",DIRECTORY_SEPARATOR);
define("PATH_PUBLIC",$_SERVER["DOCUMENT_ROOT"]);//carpeta public

$sPath = realpath(PATH_PUBLIC.DS."..");
define("PATH_ROOT",$sPath);

$sPath = realpath(PATH_ROOT.DS."vendor");
define("PATH_VENDOR",$sPath);

$sPath = realpath(PATH_ROOT.DS."src");
define("PATH_SRC",$sPath);
define("PATH_SRC_CONFIG",PATH_SRC.DS."config");

$sPath = realpath(PATH_SRC.DS."logs");
define("PATH_LOGS",$sPath);

$arEnvs = ["prod"=>".env","test"=>".env.test","dev"=>".env.dev","local"=>".env.local"];
foreach($arEnvs as $strenv){
    $pathenv = PATH_ROOT.DS.$strenv;
    if(is_file($pathenv))
    {
        $content = file_get_contents($pathenv);
        $lines = explode("\n",$content);

        $replace = [
            "%PATH_PUBLIC%"=>PATH_PUBLIC,"%PATH_ROOT%"=>PATH_ROOT,
            "%PATH_SRC%"=>PATH_SRC,"%PATH_SRC_CONFIG%"=>PATH_SRC_CONFIG
        ];

        foreach($lines as $strline)
        {
            if(strstr($strline,"="))
            {
                $keyval = explode("=",$strline);
                $key = trim($keyval[0]);
                if($key)
                {
                    $value = trim($keyval[1]) ?? "";
                    $value = str_replace(array_keys($replace),array_values($replace),$value);
                    $_ENV[$key] = $value;
                }
            }
        }
    }//if is file
}//for envs

$_SERVER += $_ENV;
//print_r($_SERVER);die;
//si se está en producción se desactivan los mensajes en el navegador
if($_ENV["APP_ENV"]=="prod")
{
    $sToday = date("Ymd");
    ini_set("display_errors",0);
    ini_set("log_errors",1);
    //Define where do you want the log to go, syslog or a file of your liking with
    ini_set("error_log",PATH_LOGS.DS."sys_$sToday.log"); // or ini_set("error_log", "/path/to/syslog/file")
}

//Código de configuración de cabeceras que permiten consumir la API desde cualquier origen
//fuente: https://stackoverflow.com/questions/14467673/enable-cors-in-htaccess
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"])) 
{
    //should do a check here to match $_SERVER["HTTP_ORIGIN"] to a
    //whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER["HTTP_ORIGIN"]}");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400");    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]}");
}

//autoload de composer
include_once '../vendor/autoload.php';
//arranque de mis utilidades
include_once '../vendor/theframework/bootstrap.php';
//rutas, mapeo de url => controlador.metodo()
$arRoutes = include_once '../src/routes/routes.php';

use TheFramework\Components\ComponentRouter;
$oR = new ComponentRouter($arRoutes);
$arRun = $oR->get_rundata();
//pr($arRun,"arRun");die;
//limpio las rutas
unset($arRoutes);

//con el controlador devuelto en $arRun lo instancio
$oController = new $arRun["controller"]();
//ejecuto el método asociado
$oController->{$arRun["method"]}();
