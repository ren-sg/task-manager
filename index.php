<?
/**
 * Composer
 */
require __DIR__ . '/vendor/autoload.php';
error_reporting(E_ALL);

$router = new Core\Router();
$router->add('/', 'Home');
$router->add('task', 'Task');
$router->add('create', 'TaskCreate');
$router->add('edit', 'TaskEdit');
$router->dispatch($_SERVER["REQUEST_URI"]);
?>
