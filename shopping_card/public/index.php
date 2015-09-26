<?php 
include '../../fw/App.php';

$app = \FW\App::getInstance();

//$config = \FW\Config::getInstance();
//$config->setConfigFolder('../config');

$app->run();

var_dump($app->getConnection());