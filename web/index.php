<?php

use PHPBB\Applications\Library\RichController;
use PHPBB\Przemo\Core\StaticRegistry;

include '../src/boot.php';

$configuration = StaticRegistry::get('configuration');

if (!$configuration->get('installed', 0)) {
    include 'install.php';
    exit;
}

$controller = new RichController;
$controller->application = $configuration->get('start', 'forum');
$controller->redirect('index')->send();