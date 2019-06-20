<?php

use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Core\L10n;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Core\View;

require __DIR__ . '/../vendor/autoload.php';

$phpbb_dir = realpath(__DIR__ . '/..');

$configuration = new Config();
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

StaticRegistry::set('phpbb_dir', $phpbb_dir);
StaticRegistry::set('configuration', $configuration);

if (file_exists("$phpbb_dir/config/config.php")) {
    require "$phpbb_dir/config/config.php";
}