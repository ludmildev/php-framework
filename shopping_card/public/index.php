<?php 
include '../../fw/App.php';

$app = \FW\App::getInstance();

$config = \FW\Config::getInstance();
$config->setConfigFolder('../config');

echo $config->app['test'];

$app->run();