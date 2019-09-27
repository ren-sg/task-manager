<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller {

    public function indexAction(){
        $context = ["test" => '12123'];
        View::render("Home.php", $context);
    }
}
?>
