<?php

namespace PHPBB\Przemo\Sources;

use PHPBB\Przemo\Query\AbstractQuery;

class Registry extends AbstractSource
{
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return array|boolean
     */
    protected function get(AbstractQuery $query)
    {
        print __METHOD__ . '<br>';
        return false;
    }
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return boolean
     */
    protected function set(AbstractQuery $query)
    {
        print __METHOD__ . '<br>';
        return false;
    }
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return boolean
     */
    protected function delete(AbstractQuery $query)
    {
        print __METHOD__ . '<br>';
        return false;
    }
}