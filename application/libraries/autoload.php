<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

spl_autoload_register(function($path){
    var_dump($path);
    $path=str_replace("\\","/",APPPATH."libraries/$path.php");
    require_once($path);
});

?>