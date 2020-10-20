<?php

namespace PhpBB\Model;

class Forum extends ForumHierarchicalEntity
{
    //public $forum_id;
    //public $cat_id;
    //public $forum_name;

    protected $latest_topic;

    public function getName()
    {
        return $this->forum_name;
    }

    public function getIndex()
    {
        return "f:$this->forum_id";
    }

    public function getParentIndex()
    {
        switch($this->main_type) {
            default:
            case 'c':
                return "c:$this->cat_id";
            case 'f':
                return "f:$this->forum_id";
        }
    }

    public function getOrder()
    {
        return $this->forum_order;
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        ForumsCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function getUrl()
    {
        return 'viewforum.php?f=' . $this->forum_id;
    }

    public function getLatestTopic()
    {
        if (!$this->latest_topic && $this->forum_last_post_id) {
            $this->latest_topic = (new TopicsCollection)->get($this->forum_last_post_id);
        }
        return $this->latest_topic;
    }
}