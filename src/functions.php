<?php

use PhpBB\Data\Cache;
use PhpBB\Forum\Url;

function cache($object)
{
    return new Cache($object);
}

function start($rootdir)
{

    require $rootdir . '/config.php';

    if ($encryption_key) {
        $encryption_key = md5_file($rootdir . '/config.php');
    }

    $dbdsn = PhpBB\Data\MySQL\Connection::GetDSN($dbname, $dbhost, $dbport ?? 3306, $dbchars ?? 'utf8mb4');

    PhpBB\Core\Context::register([
        'values' => [
            'collection-prefix' => $table_prefix ?? 'phpbb_',
            'file-handler' => PhpBB\Core\File::class,
            'cookie-handler' => PhpBB\Core\Cookie::class,
            'query-builder' => PhpBB\Data\MySQL\Query::class,
        ],
        'services' => [
            'request' => new PhpBB\Core\Request,
            'encryption' => new PhpBB\Core\Encryption($encryption_key),
            'db-connection' => new PhpBB\Data\MySQL\Connection($dbdsn, $dbuser, $dbpasswd, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]),
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

    PhpBB\Core\Context::registerServices([
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