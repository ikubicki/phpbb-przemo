<?php

namespace PHPBB\Przemo\Core\Form;

class Text
{
    
    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $value;
    
    /**
     * @var string
     */
    public $error;
    
    /**
     * 
     * @author ikubicki
     * @param string $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }
}