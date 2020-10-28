<?php

$template = PhpBB\Core\Context::getService('templates');
$template->addPath(__DIR__ . '/templates');
$template->component('SHOUTS', 'shouts.html');