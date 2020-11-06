<?php

namespace PhpBB\Modules\Votes;
use PhpBB\Core\Context;

class Module
{
    public function start()
    {
        $template = Context::getService('templates');
        $template->addPath(__DIR__ . '/templates');
        $template->render('head.html');
    }

    public function render($topic = null, $post = null)
    {

    }
}