<?php
spl_autoload_register(function($className) {
    $className = str_replace('\\', '/', $className);
    $explode = explode('/', $className);
    try {
        if ($explode[0] == 'sommelier') {
            $filename = __DIR__ . '/' . $className . '.php';
        } else {
            $filename = __DIR__ . '/../' . $className . '.php';
        }
        include_once $filename;
    } catch (Exception $ex) {
        
    }
});
