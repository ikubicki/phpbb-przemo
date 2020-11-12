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

    public function getTypes()
    {
        $types = [];
        if ($this->isFirst()) {
            $types[] = 'first';
        }
        return $types;
    }

    public function isFirst()
    {
        return $this->post_id == $this->getTopic()->topic_first_post_id;
    }

    public function getTopic()
    {
        if (!$this->getRef('topic')) {
            $topic = $this->getTopicsCollection()->get($this->topic_id);
            $this->addRef('topic', $topic);
        }
        return $this->getRef('topic');
    }

    public function getAuthor()
    {
        if (!$this->getRef('poster')) {
            $user = $this->getUsersCollection()->get($this->poster_id);
            $this->addRef('poster', $user);
        }
        return $this->getRef('poster');
    }

    public function getUrl($class = null)
    {
        return new Url('index.php?t=' . $this->topic_id . '#post_' . $this->post_id, $this->getTime(), ['class' => $class]);
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

    public function getImages()
    {
        return $this->getText()->getImages();
    }

    protected function getUsersCollection()
    {
        return new UsersCollection;
    }

    protected function getPostsTextCollection()
    {
        return new PostsTextCollection;
    }

    protected function getTopicsCollection()
    {
        return new TopicsCollection;
    }
}