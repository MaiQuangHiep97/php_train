<?php
define('_DIR_ROOT', __DIR__);
define('URL_ASSET', 'http://localhost/demo/public/uploads/');
define('URL', 'http://localhost/demo');
require_once "configs/routes.php";

// Xử lý Http
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
    $web_root = 'https://'.$_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://'.$_SERVER['HTTP_HOST'];
}

$dirRoot = str_replace('\\', '/', _DIR_ROOT);

$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

$folder = str_replace(strtolower($documentRoot), '', strtolower($dirRoot));

$web_root = $web_root.$folder;

define('_WEB_ROOT', $web_root);
// Load config tự dộng
$config_dir = scandir('configs');
if (!empty($config_dir)) {
    foreach ($config_dir as $item) {
        if ($item != '.' && $item != '..' && file_exists('configs/'.$item)) {
            require_once 'configs/'.$item;
        }
    }
}
//require_once "configs/routes.php";
require_once "core/Route.php";
require_once "core/Connection.php";
require_once "app/App.php";
// Kiểm tra config và kêt nối db
if (!empty($config['database'])) {
    $db_config = array_filter($config['database']);

    if (!empty($db_config)) {
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';
    }
}
require_once "core/Controller.php";
require_once "core/Model.php";
require_once "Repositories/RepositoryInterface.php";
require_once "Repositories/BaseRepository.php";
require_once "Repositories/User/UserRepositoryInterface.php";
require_once "Repositories/User/UserRepository.php";
require_once "Repositories/Customer/CustomerRepositoryInterface.php";
require_once "Repositories/Customer/CustomerRepository.php";
require_once "Repositories/Order/OrderRepositoryInterface.php";
require_once "Repositories/Order/OrderRepository.php";
require_once "Repositories/OrderProduct/OrderProductRepositoryInterface.php";
require_once "Repositories/OrderProduct/OrderProductRepository.php";
require_once "Repositories/ProductCat/ProductCatRepositoryInterface.php";
require_once "Repositories/ProductCat/ProductCatRepository.php";
require_once "Repositories/Product/ProductRepositoryInterface.php";
require_once "Repositories/Product/ProductRepository.php";
require_once "Repositories/ProductImage/ProductImageRepositoryInterface.php";
require_once "Repositories/ProductImage/ProductImageRepository.php";
require_once "core/Session.php";
require_once "core/Request.php";
require_once "core/Response.php";
require_once "vendor/Paginator.php";
