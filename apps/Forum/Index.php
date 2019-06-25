<?php

namespace PHPBB\Applications\Forum;

use PHPBB\Applications\Library\RichController;
use PHPBB\Applications\Forum\Model\Post;
use PHPBB\Applications\Forum\Model\Posts;

class Index extends RichController
{
    
    public function getIndex($request)
    {
        echo 'hello world';
        $post1 = new Post();
        $post1->text = md5(microtime());
        $post2 = new Post();
        $post2->text = md5(microtime());
        (new Posts())->store([$post1, $post2]);
    }
}