<?php

namespace PHPBB\Przemo\Core\Store;

class SQLStatement
{
    
    /**
     * @var \PDOStatement
     */
    protected $statement;
    
    /**
     * @var array
     */
    protected $parameters;
    
    /**
     * 
     * @author ikubicki
     * @param \PDOStatement $statement
     * @param array $parameters
     */
    public function __construct(\PDOStatement $statement, array $parameters = [])
    {
        $this->statement = $statement;
        $this->parameters = $parameters;
    }
    
    /**
     * 
     * @author ikubicki
     */
    public function __destruct()
    {
        $this->close();
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $parameters
     * @param integer $columnNumber
     * @return mixed
     */
    public function column(array $parameters = [], $columnNumber = 0)
    {
        $this->execute($parameters);
        $result = $this->fetchColumn($columnNumber);
        $this->close();
        return $result;
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $parameters
     * @return boolean|\stdClass
     */
    public function row(array $parameters = [])
    {
        $this->execute($parameters);
        $result = $this->fetch();
        $this->close();
        return $result;
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $parameters
     * @return array
     */
    public function rows(array $parameters = [])
    {
        $this->execute($parameters);
        $results = $this->fetchAll();
        $this->close();
        return $results;
    }
    
    /**
     * 
     * @author ikubicki
     * @param integer $columnNumber
     * @return mixed
     */
    public function fetchColumn($columnNumber)
    {
        return $this->statement->fetchColumn($columnNumber);
    }
    
    /**
     * 
     * @author ikubicki
     * @return boolean|\stdClass
     */
    public function fetch()
    {
        return $this->statement->fetchObject();
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public function fetchAll()
    {
        return $this->statement->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $parameters
     */
    public function execute(array $parameters = [])
    {
        if (!count($parameters)) {
            $parameters = $this->parameters;
        }
        $this->statement->execute($parameters);
    }
    
    /**
     * 
     * @author ikubicki
     */
    public function close()
    {
        $this->statement->closeCursor();
    }
}