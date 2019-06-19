<?php

namespace PHPBB\Przemo\Core\Form;

class Select
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
     * @var array
     */
    public $options = [];
    
    /**
     *
     * @author ikubicki
     * @param string $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $value
     * @param string $label
     */
    public function addOption($value, $label)
    {
        $this->options[$value] = $label;
    }
}