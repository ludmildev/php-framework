<?php

namespace FW\Routers;

use FW\Routers\IRouter as IRouter;

class DefaultRouter implements IRouter {
    
    public function getURI() {
        return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME'])+1);
    }

    public function getPost() {
        return $_POST;
    }

}