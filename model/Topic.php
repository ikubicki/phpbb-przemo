<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;
use PhpBB\Forum\Url;

class Topic extends Entity
{
    public $topic_id;
    public $forum_id;
    public $topic_title;
    public $topic_title_e;
    public $topic_votes_sum;
    public $topic_views;
    public $topic_time;
    public $topic_replies;
    public $topic_first_post_id;
    public $topic_last_post_id;
    public $topic_status;
    public $topic_poster;

    protected $latest_post;
    protected $author;
    protected $forum;

    public function getTitle()
    {
        return $this->topic_title;
    }

    public function getDescription()
    {
        return $this->topic_title_e;
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        TopicsCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function getUrl()
    {
        return new Url('index.php?t=' . $this->topic_id, $this->topic_title);
    }

    public function getVotesCount()
    {
        return $this->topic_votes_sum;
    }

    public function getRepliesCount()
    {
        return $this->topic_replies;
    }

    public function getViewsCount()
    {
        return $this->topic_views;
    }

    public function getFirstPost()
    {
        if (!$this->getRef('firstpost')) {
            $criteria = ['post_id' => $this->topic_first_post_id];
            $post = $this->getPostsCollection()
                ->leftjoin(new PostsTextCollection, 'post_id', 'post_id', [], 'text')
                ->one($criteria);
            $this->addRef('firstpost', $post);
        }
        return $this->getRef('firstpost');
    }

    public function getPosts($page = 1, $limit = 15)
    {
        $criteria = ['topic_id' => $this->topic_id];
        $order = ['post_id' => 'ASC'];
        $offset = ($page - 1) * $limit;
        $posts = $this->getPostsCollection()
            ->leftjoin(new PostsTextCollection, 'post_id', 'post_id', [], 'text')
            ->leftjoin(new UsersCollection, 'user_id', 'poster_id', [], 'poster')
            ->find($criteria, $order, $limit, $offset);
        foreach($posts as $post) {
            $post->addRef('topic', $this);
        }
        return $posts;
    }

    public function getReplies($page = 1, $limit = 15)
    {
        $criteria = ['topic_id' => $this->topic_id];
        $order = ['post_id' => 'ASC'];
        $offset = 1 + ($page - 1) * $limit;
        $posts = $this->getPostsCollection()
            ->leftjoin(new PostsTextCollection, 'post_id', 'post_id', [], 'text')
            ->leftjoin(new UsersCollection, 'user_id', 'poster_id', [], 'poster')
            ->find($criteria, $order, $limit, $offset);
        foreach($posts as $post) {
            $post->addRef('topic', $this);
        }
        return $posts;
    }

    public function getLatestPost()
    {
        if ($this->topic_last_post_id) {
            if (!$this->getRef('latestpost')) {
                $post = $this->getPostsCollection()->get($this->topic_last_post_id);
                $this->addRef('latestpost', $post);
            }
            return $this->getRef('latestpost');
        }
    }

    public function getAuthor()
    {
        if (!$this->getRef('poster')) {
            $user = $this->getUsersCollection()->get($this->topic_poster);
            $this->addRef('poster', $user);
        }
        return $this->getRef('poster');
    }

    public function getForum()
    {
        if (!$this->getRef('forum')) {
            $forum = $this->getForumsCollection()->get($this->forum_id);
            $this->addRef('forum', $forum);
        }
        return $this->getRef('forum');
    }

    public function save()
    {
        $collection = $this->getCollection(TopicsCollection::class);
        $collection->store([$this]);
    }
    
    protected function getForumsCollection()
    {
        return new ForumsCollection;
    }
    
    protected function getPostsCollection()
    {
        return new PostsCollection;
    }
    
    protected function getUsersCollection()
    {
        return new UsersCollection;
    }
}