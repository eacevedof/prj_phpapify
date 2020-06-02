<?php
//<project>\backend\src\routes\routes.php
//mapeo de rutas y controladores

return [   
    ["url"=>"/","controller"=>"App\Controllers\NotFoundController","method"=>"index"],
    ["url"=>"/logs","controller"=>"App\Controllers\LogsController","method"=>"index"],
    
    ["url"=>"/apify/contexts","controller"=>"App\Controllers\Apify\ContextsController","method"=>"index"],
    ["url"=>"/apify/contexts/{id}","controller"=>"App\Controllers\Apify\ContextsController","method"=>"index"],
    
    ["url"=>"/apify/dbs/{id_context}","controller"=>"App\Controllers\Apify\DbsController","method"=>"index"],//schemas
    
    ["url"=>"/apify/tables/{id_context}/{dbname}","controller"=>"App\Controllers\Apify\TablesController","method"=>"index"],
    //["url"=>"/apify/tables/{id_context}","controller"=>"App\Controllers\Apify\TablesController","method"=>"index"], standby pq me obliga a recorre todas las bds
    ["url"=>"/apify/fields/{id_context}/{dbname}/{tablename}/{fieldname}","controller"=>"App\Controllers\Apify\FieldsController","method"=>"index"],
    ["url"=>"/apify/fields/{id_context}/{dbname}/{tablename}","controller"=>"App\Controllers\Apify\FieldsController","method"=>"index"],
    
    ["url"=>"/apify/read/raw","controller"=>"App\Controllers\Apify\Rw\ReaderController","method"=>"raw"],
    ["url"=>"/apify/read","controller"=>"App\Controllers\Apify\Rw\ReaderController","method"=>"index"],

    ["url"=>"/apify/write/raw","controller"=>"App\Controllers\Apify\Rw\WriterController","method"=>"raw"],
    ["url"=>"/apify/write","controller"=>"App\Controllers\Apify\Rw\WriterController","method"=>"index"],

    ["url"=>"/apifiy/security/get-signature","controller"=>"App\Controllers\Apify\Security\SignatureController","method"=>"index"],
    ["url"=>"/apifiy/security/is-valid-signature","controller"=>"App\Controllers\Apify\Security\SignatureController","method"=>"is_valid_signature"],

//resto de rutas    
    ["url"=>"https://github.com/eacevedof/prj_phpapify/tree/master/backend/src/Controllers/Apify","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"],
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"]
];
