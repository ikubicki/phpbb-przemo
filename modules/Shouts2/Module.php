<?php

namespace PhpBB\Modules\Shouts;
use PhpBB\Core\Context;

class Module
{
    public function start()
    {
        $template = Context::getService('templates');
        $template->addPath(__DIR__ . '/templates');
        $template->component('SHOUTS', 'shouts.html');
    }
}