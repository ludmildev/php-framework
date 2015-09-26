<?php
namespace FW\Db;

use FW\App as App;

class SimpleDb {
    
    protected $connection = 'default';
    private $db = null;
    
    private $stmt = null;
    private $params = array();
    private $sql;
    
    public function __construct($connection = null) 
    {
        if ($connection instanceof \PDO) {
            $this->db = $connection;
        }
        elseif (!empty($connection))
        {
            $this->db = App::getInstance()->getConnection($connection);
            $this->connection = $connection;
        }
        else {
            $this->db = App::getInstance()->getConnection($this->connection);
        }
    }
    
    /**
     * 
     * @param string $sql
     * @param array $params
     * @param options $pdoOptions
     * @return \FW\Db\SimpleDb
     */
    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;
        
        return $this;
    }

    /**
     * 
     * @param array $params
     * @return \FW\Db\SimpleDb
     */
    public function execute($params = array())
    {
        if (!empty($params)) {
            $this->params = $params;
        }
//        if ($this->logSQL) {
//            \FW\Logger::getInstace()->set($this->sql . ' '.print_r($this->params, true), 'db');
//        }
        
        $this->stmt->execute($this->params);
        
        return $this;
    }
    
    public function fetchAllAssoc() {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function fetchRowAssoc() {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function fetchAllNum() {
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }
    public function fetchRowNum() {
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }
    public function fetchAllObj() {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function fetchRowObj() {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }
    public function fetchAllColunm($column) {
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN, $column);
    }
    public function fetchRowColumn($column) {
        return $this->stmt->fetch(\PDO::FETCH_COLUMN, $column);
    }
    public function fetchAllClass($class) {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }
    public function fetchRowClass($class) {
        return $this->stmt->fetch(\PDO::FETCH_CLASS, $class);
    }
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
    public function getAffectedRows() {
        return $this->stmt->rowCount();
    }
    public function getSTMT() {
        return $this->stmt;
    }
}
