<?
/**
 * Composer
 */
require __DIR__ . '/vendor/autoload.php';
error_reporting(E_ALL);

session_start();

$router = new Core\Router();
$router->add('/', ['HomeController']);
/* $router->add('create', ['TaskController', 'action'=>'createAction']); */
$router->add('add', ['TaskController', 'action'=>'addAction']);
$router->add('edit', ['TaskController', 'action'=>'editAction']);
$router->add('login', ['UserController']);
$router->add('logout', ['UserController', 'action'=>'logoutAction']);
/* $router->add('create', 'TaskCreate'); */
/* $router->add('edit', 'TaskEdit'); */
$router->dispatch($_SERVER["REQUEST_URI"]);
?>
