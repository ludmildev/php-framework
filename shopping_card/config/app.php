<?php
$conf['default_controller'] = 'Index';
$conf['default_method'] = 'index';
$conf['default_layout'] = 'default';

$conf['namespaces']['Controllers'] = '..'.DIRECTORY_SEPARATOR.'controllers';
$conf['namespaces']['Models'] = '..'.DIRECTORY_SEPARATOR.'models';

$conf['session']['autostart'] = true;
$conf['session']['type'] = 'native';
$conf['session']['name'] = '__sess';
$conf['session']['lifetime'] = 3600;
$conf['session']['path'] = '/';
$conf['session']['domain'] = '';
$conf['session']['secure'] = false;

$conf['session']['dbConnection'] = 'default';
$conf['session']['dbTable'] = 'sessions';

$conf['viewsDirectory']     = '..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;
$conf['displayExceptions']  = true;

$conf['defaultCash'] = 10000;

return $conf;