<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;

class Config extends Entity
{

    public $config_name;
    public $config_value;
    
    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        PostsCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function save()
    {
        $collection = $this->getCollection(ConfigCollection::class);
        $collection->store([$this]);
    }

    public function delete()
    {
        $collection = $this->getCollection(ConfigCollection::class);
        $collection->dump([$this]);
    }

}