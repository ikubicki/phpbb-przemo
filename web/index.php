<?php

use PHPBB\Applications\Library\FrontController;
use PHPBB\Przemo\Core\StaticRegistry;

include '../src/boot.php';

$configuration = StaticRegistry::get('configuration');

if (!$configuration->get('installed', 0)) {
    include 'install.php';
    exit;
}

$controller = new FrontController;
$controller->application = $configuration->get('start', 'forum');
$controller->redirect('index')->send();