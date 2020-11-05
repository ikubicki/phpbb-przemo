<?php

use PhpBB\Core\Context;
use PhpBB\Data\Cache;
use PhpBB\Data\MySQL;
use PhpBB\Forum\Url;

function cache($object)
{
    return new Cache($object);
}

function get_authenticator($authenticator)
{
    $class = sprintf('PhpBB\\Modules\\Auth\\%s\\Module', ucfirst($authenticator));
    if (class_exists($class)) {
        return new $class;
    }
    return false;
}

function recaptcha_check($verbose = false)
{
    $config = Context::getService('config');
    $request = Context::getService('request');
    if ($config->recaptcha_key && $config->recaptcha_secret) {
        if ($request->post->recaptcha) {
            return (new PhpBB\Modules\Recaptcha\Module($verbose))->verify($config->recaptcha_secret, $request->post->recaptcha);
        }
        return false;
    }
    return true;
}

function message($message, $title = null)
{
    $phrases = Context::getService('phrases');
    $templates = Context::getService('templates');
    $templates->var('message', [
        'title' => $title ?? $phrases->get('Message'),
        'text' => $phrases->get($message),
    ]);
    $templates->display('message.html');
    exit;
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function start($rootdir)
{

    ob_start();

    require $rootdir . '/config.php';

    if ($encryption_key) {
        $encryption_key = md5_file($rootdir . '/config.php');
    }

    $dbdsn = MySQL\Connection::GetDSN($dbname, $dbhost, $dbport ?? 3306, $dbchars ?? 'utf8mb4');

    Context::register([
        'values' => [
            'collection-prefix' => $table_prefix ?? 'phpbb_',
            'file-handler' => PhpBB\Core\File::class,
            'query-builder' => MySQL\Query::class,
        ],
        'services' => [
            'request' => new PhpBB\Core\Request,
            'encryption' => new PhpBB\Core\Encryption($encryption_key),
            'db-connection' => new MySQL\Connection($dbdsn, $dbuser, $dbpasswd, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]),
        ]
    ]);
    
    $config = new PhpBB\Forum\Config;
    $cookie = new PhpBB\Core\Cookie([
        'name' => 'sess',
        'path' => '/',
        'secure' => true,
        'samesite' => true,
    ]);
    $session = new PhpBB\Forum\Session($cookie);
    $phrases = new PhpBB\Forum\Phrases("$rootdir/languages");
    $templates = new PhpBB\Forum\Templates($rootdir, [
        'cache' => false,
        'debug' => true,
        'vars' => [
            'theme' => 'test',
        ],
    ]);
    $templates->addPath("$rootdir/templates/default");
    $tree = new PhpBB\Forum\Tree;
    $tree->cache('/tmp/tree.' . date('ymd') . '.php');
    if (!$tree->isCached()) {
        $tree->import((new PhpBB\Model\CategoriesCollection)->all());
        $tree->import((new PhpBB\Model\ForumsCollection)->all());
        $tree->storeCache();
    }

    Context::registerServices([
        'config' => $config,
        'session' => $session,
        'phrases' => $phrases,
        'templates' => $templates,
        'tree' => $tree,
    ]);
    $templates->vars([
        'c' => $config,
        'l' => $phrases,
        's' => $session,
        'U_HOME' => new Url('index.php', $phrases->Forum_index),
        'SITE_NAME' => $config->sitename,
        'SITE_DESCRIPTION' => $config->site_desc,
    ]);
}