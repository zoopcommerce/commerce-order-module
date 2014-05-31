<?php

putenv('SERVER_TYPE=test');

ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '512M');

$applicationRoot = '/../';

chdir(__DIR__ . $applicationRoot);

$loader = require_once('vendor/autoload.php');

$loader->add('Zoop\Order\Test', __DIR__);

$appConfig = include __DIR__ . '/test.application.config.php';

$creator = new Zoop\Order\Test\TestDataCreator();
$creator->createAll();
