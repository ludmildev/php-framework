<?php
namespace FW\Sessions;

use FW\Sessions\ISession as ISession;
use FW\Db\SimpleDb as SimpleDb;

class DBSession extends SimpleDb implements ISession {
    
    private $sessionName;
    private $tableName;
    private $lifetime;
    private $path;
    private $domain;
    private $secure;
    private $sessionId = null;
    private $sessionData = array();
    
    public function __construct($dbConnction, $name, $tableName = '', $lifetime = 3600, $path = null, $domain = null, $secure = false)
    {
        parent::__construct($dbConnction);
        
        $this->sessionName = $name;
        $this->tableName = $tableName;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->sessionId = $_COOKIE[$name];
        
        if (rand(0, 51) == 1) {
            $this->_cleanData();
        }
        
        if (strlen($this->sessionId) < 32)
            $this->_startNewSession();
        elseif (!$this->_validateSession())
            $this->_startNewSession();
            
    }

    private function _startNewSession()
    {
        $this->sessionId = md5(uniqid('fw', true));
        
        $this->prepare('
        INSERT INTO '.$this->tableName.' (
            session_id, valid_until
        ) VALUES (
            ?, ?
        )', array(
            $this->sessionId,
            (time()+$this->lifetime)
        ))->execute();
        
        setcookie($this->sessionName, $this->sessionId, (time()+$this->lifetime), $this->path, $this->domain, $this->secure, true);
    }
    
    private function _validateSession()
    {
        if ($this->sessionId)
        {
            $d = $this->prepare('
                SELECT *
                FROM '.$this->tableName.'
                WHERE 1
                    AND session_id = ?
                    AND valid_until <= ?', array(
                $this->sessionId,
                (time() + $this->lifetime)
            ))->execute()->fetchAllAssoc();
            
            if (is_array($d) && count($d) == 1 && !empty($d[0]))
            {
                $this->sessionData = unserialize($d[0]['sess_data']);
                return true;
            }
            
            return false;
        }
    }
    
    public function __get($name) {
        return !empty($this->sessionData[$name]) ? $this->sessionData[$name] : null;
    }

    public function __set($name, $value) {
        $this->sessionData[$name] = $value;
    }

    public function destroySession()
    {
        if (!empty($this->sessionId))
        {
            $this->prepare('DELETE FROM '.$this->tableName.' WHERE session_id = ? LIMIT 1', array(
                $this->sessionId
            ))->execute();
        }
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    public function saveSession()
    {
        if ($this->sessionId)
        {
            $this->prepare('
            UPDATE '.$this->tableName.' SET 
                sess_data = ?,
                valid_until = ?
            WHERE session_id = ?', array(
                serialize($this->sessionData),
                (time() + $this->lifetime),
                $this->sessionId
            ))->execute();
            
            setcookie($this->sessionName, $this->sessionId, (time()+$this->lifetime), $this->path, $this->domain, $this->secure, true);
        }
    }
    
    private function _cleanData()
    {
        $this->prepare('DELETE FROM '.$this->tableName.' WHERE valid_until < ? LIMIT 1', array(
            time()
        ))->execute();
    }
}
