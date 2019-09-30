<?php

namespace Core;

abstract class Controller {
    protected $user = [];

    public function __construct() {
        $this->user = \Core\Model::getUser();
    }
}
