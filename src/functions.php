<?php

use PhpBB\Core\Context;
use PhpBB\Data\Memoizer;
use PhpBB\Data\MySQL;
use PhpBB\Forum\Url;

function cache($name, $data = null)
{
    static $cache = [];
    if (empty($cache)) {
        $cache = Context::getService('cache');
    }
    if ($data) {
        $cache->store($name, $data);
        return $cache;
    }
    return $cache->collect($name);
}

function memoize($object)
{
    return new Memoizer($object);
}

function get_authenticator($name)
{
    $authenticator = Context::getModule('Auth', $name);
    return $authenticator ?: false;
}

function recaptcha_check($verbose = false)
{
// return true;
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
        'title' => empty($title) ? $phrases->get('Message') : $phrases->get($title),
        'text' => $phrases->get($message),
    ]);
    $templates->display('main/message.html');
    exit;
}

function error404($type)
{
    message('Missing_' . $type, 'Page_missing');
}

function redirect($url)
{
    header('Location: ' . (new Url($url))->url);
    exit;
}

function start($rootdir)
{

    ob_start();

    require $rootdir . '/config.php';

    if ($encryption_key) {
        $encryption_key = md5_file($rootdir . '/config.php');
    }

    $request = new PhpBB\Core\Request;
    $dbdsn = MySQL\Connection::GetDSN($dbname, $dbhost, $dbport ?? 3306, $dbchars ?? 'utf8mb4');

    Context::register([
        'values' => [
            'rootdir' => $rootdir,
            'cache-path' => sys_get_temp_dir(),
            'collection-prefix' => $table_prefix ?? 'phpbb_',
            'file-handler' => PhpBB\Core\File::class,
            'query-builder' => MySQL\Query::class,
        ],
        'services' => [
            'cache' => (new PhpBB\Data\Cache)->ttl(15)->directory(sys_get_temp_dir()),
            'request' => $request,
            'encryption' => new PhpBB\Core\Encryption($encryption_key),
            'db-connection' => new MySQL\Connection($dbdsn, $dbuser, $dbpasswd, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]),
        ]
    ]);
    
    $config = new PhpBB\Forum\Config;
    if (!$config->isCached()) {
        $config->load();
        $config->storeCache();
    }
    $cookie = new PhpBB\Core\Cookie([
        'name' => 'sess',
        'path' => '/',
        'secure' => true,
        'samesite' => 'Strict',
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
    if (!$tree->isCached()) {
        $tree->import((new PhpBB\Model\CategoriesCollection)->getAll());
        $tree->import((new PhpBB\Model\ForumsCollection)->getAll());
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
        'U_SIGNIN' => new Url('auth.php', $phrases->Sign_in),
        'U_SIGNOUT' => new Url('auth.php?signout', $phrases->Sign_out),
        'U_SIGNUP' => new Url('auth.php?signup', $phrases->Sign_up),
        'URI' => $request->REQUEST_URI ?? (new Url('index.php'))->url,
        'SITE_NAME' => $config->sitename,
        'SITE_DESCRIPTION' => $config->site_desc,
    ]);
    if (file_exists($rootdir . '/extensions.php')) {
        require $rootdir . '/extensions.php';
    }
}