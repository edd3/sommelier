<?php
session_start();

//defined('DEBUG') or define('DEBUG', true);
defined('DEBUG') or define('DEBUG', false);

require(__DIR__ . '/../vendor/autoload.php');

require __DIR__ . '/../vendor/sommelier/base/App.php';

$config = require __DIR__ . '/../config/config.php';

(new \sommelier\base\App())->work($config);
