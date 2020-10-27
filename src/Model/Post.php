<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;
use PhpBB\Forum\Url;

class Post extends Entity
{

    public $post_id;
    public $topic_id;
    public $forum_id;
    public $poster_id;
    public $post_time;
    public $poster_ip;
    public $post_username;

    protected $author;

    public function getTitle()
    {
        return $this->post_title;
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        PostsCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function getAuthor()
    {
        if (!$this->author) {
            $this->author = $this->getUsersCollection()->get($this->poster_id);
        }
        return $this->author;
    }

    public function getUrl($class = null)
    {
        return new Url('viewtopic.php?t=' . $this->topic_id . '#' . $this->post_id, $this->getTime(), ['class' => $class]);
    }

    public function getTime($format = 'Y-m-d H:i')
    {
        return date($format, $this->post_time);
    }

    public function getText()
    {
        $text = $this->getRef('text');
        if (!$text) {
            $text = $this->getPostsTextCollection()->get($this->post_id);
            $this->addRef('text', $text);
        }
        return $text;
    }

    protected function getUsersCollection()
    {
        return new UsersCollection;
    }

    protected function getPostsTextCollection()
    {
        return new PostsTextCollection;
    }
}