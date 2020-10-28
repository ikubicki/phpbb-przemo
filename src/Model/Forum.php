<?php

namespace PhpBB\Model;
use PhpBB\Forum\Url;

class Forum extends ForumHierarchicalEntity
{
    //public $forum_id;
    //public $cat_id;
    //public $forum_name;

    protected $latest_post;

    public function getType()
    {
        return 'forum';
    }

    public function getName()
    {
        return $this->forum_name;
    }

    public function getDescription()
    {
        return $this->forum_desc;
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

    public function getUrl($class = null)
    {
        return new Url('test.php?f=' . $this->forum_id, $this->getName(), ['class' => $class]);
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

    public function getLatestPost()
    {
        if (!$this->latest_post && $this->forum_last_post_id) {
            $this->latest_post = $this->getPostsCollection()->get($this->forum_last_post_id);
        }
        return $this->latest_post;
    }

    public function getPostsCount()
    {
        return $this->forum_posts;
    }

    public function getTopicsCount()
    {
        return $this->forum_topics;
    }
    
    protected function getTopicsCollection()
    {
        return new TopicsCollection;
    }
    
    protected function getPostsCollection()
    {
        return new PostsCollection;
    }
}