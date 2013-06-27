<?php
define('ENV_PRODUCTION', false);
define('APP_HOST', 'diet.cake.com');
define('APP_BASE_PATH', '/');
define('APP_URL', 'http://diet.cake.com/');
define('DEBUG_DUMP_EXCEPTION', false);

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
ini_set('error_log', LOGS_DIR.'php.log');
ini_set('session.auto_start', 0);

// MySQL: board
define('DB_DSN', 'mysql:host=localhost;dbname=board');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_ATTR_TIMEOUT', 3);
