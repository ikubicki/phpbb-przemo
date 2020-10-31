<?php

namespace PhpBB\Modules\Shouts;

class Module
{
    public function start()
    {
        $template = \PhpBB\Core\Context::getService('templates');
        $template->addPath(__DIR__ . '/templates');
        $template->component('SHOUTS', 'shouts.html');
    }
}