<?php

use PHPBB\Przemo\Core\Routing;
use Symfony\Component\HttpFoundation\Request;

include 'src/boot.php';
include 'src/dev.php';

$application = (new Routing)->getApplication('install');
$response = $application->dispatch(Request::createFromGlobals());
$response->send();
exit;