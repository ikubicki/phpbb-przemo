<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;

class PostText extends Entity
{

    public $post_id;
    public $bbcode_uid;
    public $post_text;

    protected $author;

    public function __toString()
    {
        return $this->transcode($this->post_text);
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        PostsTextCollection::registerEntity(null, $entity);
        return $entity;
    }

    protected function transcode($text)
    {
        return preg_replace('#\[(\/?[a-zA-Z0-9]+)\:[a-f0-9]+\]#', '[$1]', $text);
    }
}