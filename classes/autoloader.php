<?php

class Autoloader {
    public function __construct(){
        spl_autoload_register(function($class){
            include dirname(__FILE__) . '/' . str_replace('\\', '/', $class) . '.class.php';
        });
    }
}