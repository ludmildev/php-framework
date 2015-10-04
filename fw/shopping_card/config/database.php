<?php
$conf['default']['url'] = 'mysql:host=localhost;dbname=test';
$conf['default']['username'] = 'root';
$conf['default']['pass'] = 'delux919';
$conf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$conf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;


return $conf;