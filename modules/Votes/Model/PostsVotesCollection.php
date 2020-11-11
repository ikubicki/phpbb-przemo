<?php

namespace PhpBB\Modules\Votes\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;
use PhpBB\Model\Post;

class PostsVotesCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('posts_votes', PostsVote::class, ['post_id', 'user_id']);
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('posts_votes', $entity);
    }

    public function getTopicVotes($user_id, $topic_id)
    {
        $query = "SELECT `post_id` `id`, " . 
                "SUM(`vote`) `sum`, " . 
                "COUNT(1) `count`, " . 
                "SUM(IF(`user_id` = ?, `vote`, null)) `voted` " . 
            "FROM {$this->getName()} " .
            "WHERE `topic_id` = ? " .
            "GROUP BY `post_id`";
        $result = [];
        $records = $this->getConnection()->all($query, [$user_id, $topic_id]);
        foreach ($records as $record) {
            $result[$record['id']] = $record;
        }
        return $result;
    }

    public function sumVotesForTopic($topic_id)
    {
        $query = "SELECT SUM(vote) " . 
            "FROM {$this->getName()} " . 
            "WHERE topic_id = ?";
        return $this->getConnection()->value($query, [$topic_id]);
    }

    public function new($user_id, Post $post, $vote)
    {

        $entity = $this->get([$post->post_id, $user_id]);

        if (!$entity) {
            $entity = new PostsVote;
            $entity->user_id = $user_id;
            $entity->forum_id = $post->forum_id;
            $entity->topic_id = $post->topic_id;
            $entity->post_id = $post->post_id;
        }
        if ($entity->vote != $vote) {
            $entity->vote = $vote;
            $entity->timestamp = time();
            $entity->save();
        }
        return $entity;
    }
    

}