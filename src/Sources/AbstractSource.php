<?php

namespace PHPBB\Przemo\Sources;

use PHPBB\Przemo\Query\AbstractQuery;

abstract class AbstractSource
{
    
    public function __construct($next = null)
    {
        $this->next = $next;
    }
    
    /**
     * 
     * @author ikubicki
     * @param AbstractQuery $query
     * @return boolean|array
     */
    public function handle(AbstractQuery $query)
    {
        $method = $this->getMethodForOperation($query::OPERATION);
        return $this->$method($query);
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function next()
    {
        return $this->next;
    }
    
    /**
     * 
     * @author ikubicki
     * @param AbstractQuery $query
     * @return array
     */
    protected function handleGet(AbstractQuery $query)
    {
        $result = $this->get($query);
        if (false === $result) {
            if ($this->next) {
                return $this->next->handleGet($query);
            }
            return [];
        }
        return $result;
    }
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return array
     */
    protected function handleSet(AbstractQuery $query)
    {
        $result = true;
        if ($this->next) {
            $result = $this->next->handleSet($query);
        }
        if ($result) {
            return $this->set($query);
        }
        return $result;
    }
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return array
     */
    protected function handleDelete(AbstractQuery $query)
    {
        $result = true;
        if ($this->next) {
            $result = $this->next->handleDelete($query);
        }
        if ($result) {
            return $this->delete($query);
        }
        return $result;
    }
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return array|boolean
     */
    abstract protected function get(AbstractQuery $query);
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return boolean
     */
    abstract protected function set(AbstractQuery $query);
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return boolean
     */
    abstract protected function delete(AbstractQuery $query);
    
    /**
     * 
     * @author ikubicki
     * @param string $operation
     * @return string
     */
    protected function getMethodForOperation($operation)
    {
        return 'handle' . ucfirst($operation);
    }
}