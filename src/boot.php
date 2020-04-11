<?php

use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Sources;

if (getenv('DEBUG') == '1') {
    include __DIR__ . '/dev.php';
}

$phpbb_dir = realpath(__DIR__ . '/..');

require $phpbb_dir . '/vendor/autoload.php';

$configuration = new Config();
$configuration->create('phpbb')->import(['dir' => $phpbb_dir]);
$viewconfig = $configuration->create('view');
$viewconfig->set('theme', 'default');
$viewconfig->create('cache')->import(['dir' => $phpbb_dir . '/cache/twig']);
$viewconfig->create('templates')->import(['dir' => $phpbb_dir . '/assets/%s/html']);
$configuration->create('l10n')->import(['languages' => ['en', 'pl'], 'dir' => $phpbb_dir . '/language']);

$sources = new Sources\Registry(new Sources\Redis(new Sources\SQL));

StaticRegistry::set('phpbb_dir', $phpbb_dir);
StaticRegistry::set('configuration', $configuration);
StaticRegistry::set('sources', $sources);

if (file_exists("$phpbb_dir/config/config.php")) {
    require "$phpbb_dir/config/config.php";
}