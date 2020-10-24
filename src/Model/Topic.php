<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;

class Topic extends Entity
{
    public $topic_id;
    public $topic_title;

    public function getTitle()
    {
        return $this->topic_title;
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        TopicsCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function getUrl()
    {
        return 'viewtopic.php?t=' . $this->topic_id;
    }
}