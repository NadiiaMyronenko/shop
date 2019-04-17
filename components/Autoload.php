<?php

spl_autoload_register(function ($class_name){ //autoload
    $array_path = array (
        '/components/',
        '/models/'
    );
    foreach ($array_path as $path){
        $path = ROOT . $path . $class_name . '.php';
        if(file_exists($path)){
            include_once $path;
        }
    }
});