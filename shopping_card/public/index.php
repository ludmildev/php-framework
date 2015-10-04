<?php 
include '../../fw/App.php';

$app = \FW\App::getInstance();

//ini_set('display_errors', 0);

//$db = new \FW\Db\SimpleDb();
//$users = $db->prepare('SELECT * FROM users WHERE user_id = ?',[1])->execute()->fetchAllAssoc();
//echo '<pre>' . print_r($users, true) . '</pre>';

$app->run();

//$app->getSession()->counter+=1;
//echo $app->getSession()->counter;
