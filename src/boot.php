<?php

use PHPBB\Przemo\Core;
use PHPBB\Przemo\Sources;

require __DIR__ . '/../vendor/autoload.php';

$phpbb_dir = realpath(__DIR__ . '/..');

$configuration = new Core\Config();
$configuration->create('phpbb')->import([
    'dir' => $phpbb_dir
]);
$viewconfig = $configuration->create('view');
$viewconfig->set('theme', 'default');
$viewconfig->create('cache')->import([
    'dir' => $phpbb_dir . '/cache/twig'
]);
$viewconfig->create('templates')->import([
    'dir' => $phpbb_dir . '/assets/%s/html'
]);

$configuration->create('l10n')->import([
    'languages' => ['en', 'pl'],
    'dir' => $phpbb_dir . '/language'
]);

$sources = new Sources\Registry(new Sources\Redis(new Sources\SQL));

Core\StaticRegistry::set('phpbb_dir', $phpbb_dir);
Core\StaticRegistry::set('configuration', $configuration);
Core\StaticRegistry::set('sources', $sources);

if (file_exists("$phpbb_dir/config/config.php")) {
    require "$phpbb_dir/config/config.php";
}