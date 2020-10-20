<?php

namespace PhpBB\Model;

class Topic extends ForumHierarchicalEntity
{


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