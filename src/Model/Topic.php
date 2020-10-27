<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;
use PhpBB\Forum\Url;

class Topic extends Entity
{
    public $topic_id;
    public $forum_id;
    public $topic_title;
    public $topic_votes_sum;
    public $topic_views;
    public $topic_time;
    public $topic_replies;
    public $topic_last_post_id;
    public $topic_status;
    public $topic_poster;

    protected $latest_post;
    protected $author;
    protected $forum;

    public function getTitle()
    {
        return $this->topic_votes_sum;
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        TopicsCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function getUrl()
    {
        return new Url('viewtopic.php?t=' . $this->topic_id, $this->topic_title);
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

    public function getPosts($page = 1, $limit = 15)
    {
        $criteria = ['topic_id' => $this->topic_id];
        $order = ['post_id' => 'ASC'];
        $offset = ($page - 1) * $limit;
        return $this->getPostsCollection()
            ->leftjoin(new PostsTextCollection, 'post_id', 'post_id', [], 'text')
            ->leftjoin(new UsersCollection, 'user_id', 'poster_id', [], 'poster')
            ->find($criteria, $order, $limit, $offset);
    }

    public function getLatestPost()
    {
        if (!$this->latest_post && $this->topic_last_post_id) {
            $this->latest_post = $this->getPostsCollection()->get($this->topic_last_post_id);
        }
        return $this->latest_post;
    }

    public function getAuthor()
    {
        if (!$this->author) {
            $this->author = $this->getUsersCollection()->get($this->topic_poster);
        }
        return $this->author;
    }

    public function getForum()
    {
        if (!$this->forum) {
            $this->forum = $this->getForumsCollection()->get($this->forum_id);
        }
        return $this->forum;
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