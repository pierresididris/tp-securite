<?php

class Autoloader {
    public function __construct(){
        ///Call each time a class not included is call
        spl_autoload_register(function($className){
            include dirname(__FILE__) . '/' . str_replace('\\', '/', $className) . '.class.php';
        }); 
    }
}