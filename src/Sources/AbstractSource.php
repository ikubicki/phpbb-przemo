<?php

namespace PHPBB\Przemo\Sources;

use PHPBB\Przemo\Query\AbstractQuery;

abstract class AbstractSource
{
    
    public function __construct($next = null)
    {
        $this->next = $next;
    }
        
    public function handle(AbstractQuery $query)
    {
        print $query::OPERATION;exit;
    }
    
    public function next()
    {
        return $this->next;
    }
}