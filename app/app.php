<?php

use Slim\App;

$rootPath = dirname(__DIR__);

define('VENDOR_PATH', "$rootPath/vendor");
define('APP_PATH', "$rootPath/app");
const APP_PREFIX = "PROJECT_"; // This is the global prefix for  prefix: "PROJECT_"

require_once VENDOR_PATH . "/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

if (file_exists($rootPath . "/.env")) {
    $dotenv->load();
}
$dotenv->required([
    'ENV',
    APP_PREFIX . 'LOG_FILE',
]);

$config = [];
require_once APP_PATH . '/config.php';

$app = new App($config);

require_once APP_PATH . '/dependencies.php';

require_once APP_PATH . '/services.php';

require_once APP_PATH . '/handlers.php';

require_once APP_PATH . '/routes.php';

