<?php
//index.php 4.0.0
define("DS",DIRECTORY_SEPARATOR);

$pathpublic = $_SERVER["DOCUMENT_ROOT"];
if($pathpublic) $sPath = realpath($pathpublic.DS."..");
else $sPath = $_SERVER["PWD"];
define("PATH_ROOT",$sPath);

$sPath = realpath(PATH_ROOT.DS."public");
define("PATH_PUBLIC",$sPath);//carpeta public

$sPath = realpath(PATH_ROOT.DS."vendor");
define("PATH_VENDOR",$sPath);

$sPath = realpath(PATH_ROOT.DS."src");
define("PATH_SRC",$sPath);

define("PATH_SRC_CONFIG",PATH_SRC.DS."config");

$sPath = realpath(PATH_SRC.DS."logs");
define("PATH_LOGS",$sPath);