<?php

namespace PhpBB\Modules\Votes\Model;
use PhpBB\Data\Entity;

class PostsVote extends Entity
{
    public $forum_id;
    public $topic_id;
    public $post_id;
    public $user_id;
    public $vote;
    public $timestamp;

    public function save()
    {
        $collection = $this->getCollection(PostsVotesCollection::class);
        $collection->store([$this]);
    }
}