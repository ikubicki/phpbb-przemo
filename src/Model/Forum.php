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

    public function getTopics($page = 1, $limit = 15)
    {
        $criteria = ['forum_id' => $this->forum_id];
        $order = ['topic_id' => 'DESC'];
        $offset = ($page - 1) * $limit;
        return $this->getTopicsCollection()
            ->leftjoin(new UsersCollection, 'user_id', 'topic_poster')
            ->find($criteria, $order, $limit, $offset);
    }

    public function getLatestTopic()
    {
        if (!$this->latest_topic && $this->forum_last_post_id) {
            $this->latest_topic = $this->getTopicsCollection()->get($this->forum_last_post_id);
        }
        return $this->latest_topic;
    }
    
    protected function getTopicsCollection()
    {
        return new TopicsCollection;
    }
}