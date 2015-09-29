<?php
/* $conf['package']['namespace'] = 'Controllers\Admin'; */
/* $conf['package/another']['namespace'] = 'Controllers\Admin'; */

$conf['administration']['namespace'] = 'Controllers\Admin';
$conf['administration']['controllers']['test']['to'] = 'index';
$conf['administration']['controllers']['test']['methods']['new'] = '_new';

$conf['*']['namespace'] = 'Controllers';
//$conf['*']['controllers']['products']['to'] = 'products';

return $conf;