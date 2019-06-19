<?php

namespace PHPBB\Przemo\Core;

class Routing
{
    public function getApplication($application)
    {
        return new Routing\Application($application);
    }
  
}