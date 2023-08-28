<?
$rout = $_GET['rout'];
$error = $_GET['err'];


require_once('./database.php');
require_once('./functions.php');

if ($error) {
    http_response_code($error);
    include("./pages/{$error}.php");
    die();
}

switch ($rout) {
    case '':
        include('./pages/main.php');
        break;
    case 'update':
        include('./pages/update.php');
        break;
    default:
        http_response_code(404);
        include('./pages/404.php');
        break;
}