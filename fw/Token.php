<?php
namespace FW;

class Token
{
    private static $_instance = null;
    /**
     *
     * @var \FW\Sessions\ISession
     */
    private static $session = null;

    private function __construct() {
        self::$session = \FW\App::getInstance()->getSession();
    }

    public static function init()
    {
        if (self::$_instance == null) {
            self::$_instance = new Token();
        }

        return self::$_instance;
    }

    public static function render($samePage = false)
    {
        if (!$samePage) {
            self::generateToken();
        }

        $html = '<input type="hidden" name="_token" value="' . self::$session->_token . '">';
        echo $html;
    }

    public static function validates($token)
    {
        $isValid = (bool)(self::$session->_token === $token);
        self::generateToken();
        return $isValid;
    }

    public static function getToken($samePageToken = false)
    {
        if (!$samePageToken) {
            self::generateToken();
        }

        return self::$session->_token;
    }

    private static function generateToken() {
        self::$session->_token = base64_encode(openssl_random_pseudo_bytes(64));
    }
}