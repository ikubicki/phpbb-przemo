<?php

namespace PHPBB\Przemo\Sources;

use PHPBB\Przemo\Query\AbstractQuery;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Core\Store;
use PHPBB\Przemo\Sources\Query\Builders;

class SQL extends AbstractSource
{
    
    /**
     *
     * @author ikubicki
     * @param AbstractQuery $query
     * @return array|boolean
     */
    protected function get(AbstractQuery $query)
    {
        print_r((new Builders\SQL($query))->getStatement());
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
        print_r((new Builders\SQL($query))->getStatement());
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
        print_r((new Builders\SQL($query))->getStatement());
        print __METHOD__ . '<br>';
        return false;
    }
    
    /**
     * 
     * @author ikubicki
     * @return Store\SQL
     */
    protected function sql()
    {
        if (!StaticRegistry::has('sql')) {
            StaticRegistry::set('sql', new Store\SQL);
        }
        return StaticRegistry::get('sql');
    }
}