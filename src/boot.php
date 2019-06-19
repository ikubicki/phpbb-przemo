<?php

use PHPBB\Przemo\Core;
use Symfony\Component\HttpFoundation\Request;
use PHPBB\Przemo\Core\L10n;

require __DIR__ . '/../vendor/autoload.php';

// $board = new Core\Board();
// $board->setConfig(new Core\Config);
// $board->setUser(new Core\User);
// $board->setView(new Core\View);
// $board->setRequest(Request::createFromGlobals());
// $phpbbConfig = $board->config->create('phpbb');
// $phpbbConfig->set('phpbb_dir', realpath(__DIR__ . '/..'));
$phpbb_dir = realpath(__DIR__ . '/..');
$view = new Core\View;
$view->setCacheDirectory($phpbb_dir . '/cache/twig');
$view->setTemplatesDirectory($phpbb_dir . '/assets/%s/html');
$view->setTheme('default');
$localisation = new L10n;
$localisation->setPhrasesDirectory($phpbb_dir . '/language');
$localisation->addAvailableLanguage('pl');