<?php


$rootdir = __DIR__ . '/../..';
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$user_id = intval($_POST['user']);

function url($path)
{
    $config = PhpBB\Core\Context::getService('config');
    $server_protocol = ($config->cookie_secure) ? 'https://' : 'http://';
    $server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($config->server_name));
    $server_port = $config->server_port == 80 || $config->server_port == 443 ? '' : ':' . trim($config->server_port);
    return $server_protocol . $server_name . $server_port . $path;
}

function pick_random_default_avatar()
{
    global $rootdir;
    $path = $rootdir . '/images/avatars/default/';
    $files = scandir($path);
    foreach($files as $i => $file) {
        if (!is_file($path . $file)) {
            unset($files[$i]);
        }
    }

    $file = $files[array_rand($files)];
    return url('/images/avatars/default/' . $file);
}

function getUrlContents($url)
{
    $context = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
    return file_get_contents($url, false, $context);
}

// if (!$user_id || $userdata['user_id'] == $user_id) {
    $url = pick_random_default_avatar();
    header('Content-Type: image/png');
    ob_clean();
    print getUrlContents($url);
// }

