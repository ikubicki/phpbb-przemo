<?php

namespace PhpBB\Model;
use PhpBB\Forum\Url;

class Forum extends ForumHierarchicalEntity
{
    public $forum_id;
    public $cat_id;
    public $forum_name;
    public $forum_desc;
    public $main_type;
    public $forum_order;
    public $forum_topics;
    public $forum_posts;
    public $forum_last_post_id;

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
        return new Url('index.php?f=' . $this->forum_id, $this->getName(), ['class' => $class]);
    }

    public function getTopics($page = 1, $limit = 15)
    {
        $criteria = ['forum_id' => $this->forum_id];
        $order = ['topic_id' => 'DESC'];
        $offset = ($page - 1) * $limit;
        return $this->getTopicsCollection()
            ->leftjoin(new UsersCollection, 'user_id', 'topic_poster', [], 'poster')
            ->leftjoin(new PostsCollection, 'post_id', 'topic_last_post_id', [], 'latestpost')
            ->find($criteria, $order, $limit, $offset);
    }

    public function getLatestPost()
    {
        if ($this->forum_last_post_id) {
            if (!$this->getRef('latestpost')) {
                $post = $this->getPostsCollection()->get($this->forum_last_post_id);
                $this->addRef('latestpost', $post);
            }
            return $this->getRef('latestpost');
        }
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