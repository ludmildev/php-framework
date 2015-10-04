<?php
/* $conf['package']['namespace'] = 'Controllers\Admin'; */
/* $conf['package/another']['namespace'] = 'Controllers\Admin'; */

$conf['admin']['namespace'] = 'Controllers\Admin';
$conf['admin']['controllers']['test']['to'] = 'index';
$conf['admin']['controllers']['test']['methods']['new'] = '_new';

$conf['*']['namespace'] = 'Controllers';

$conf['*']['controllers']['index']['to'] = 'index';

$conf['*']['controllers']['products']['to'] = 'products';

$conf['*']['controllers']['signin']['to'] = 'signin';
$conf['*']['controllers']['signup']['to'] = 'signin';

$conf['*']['controllers']['user']['to'] = 'user';

$conf['*']['controllers']['categories']['to'] = 'categories';
$conf['*']['controllers']['profile']['to'] = 'profile';
$conf['*']['controllers']['card']['to'] = 'card';


return $conf;