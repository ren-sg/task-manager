<?php

namespace Core;

use \Core\View;

abstract class Controller{

    public function __construct(){
        $method = $_SERVER["REQUEST_METHOD"];
        if ($method == "GET"){
            $this->indexAction();
        } else if ($method == "POST"){
            $this->postAction($_POST);
        }
    }

    public function indexAction(){}

    public function postAction($data){
    }
}

?>
