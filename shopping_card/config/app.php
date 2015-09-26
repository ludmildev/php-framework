<?php
$conf['default_controller'] = 'Index';
$conf['default_method'] = 'indexmd';
$conf['namespaces']['Controllers'] = 'C:\xampp\htdocs\framework\trunk\shopping_card\controllers';

$conf['session']['autostart'] = true;
$conf['session']['type'] = 'native';
$conf['session']['name'] = '__sess';
$conf['session']['lifetime'] = 3600;
$conf['session']['path'] = '/';
$conf['session']['domain'] = '';
$conf['session']['secure'] = false;

return $conf;