<?php

define('IN_PHPBB', true);
define('SHOUTBOX', true);
$phpbb_root_path = '../../';
$shoutbox_config = [];
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
$userdata = session_pagestart($user_ip);
init_userprefs($userdata);

$user_id = intval($_POST['user']);

function url($path)
{
    global $board_config;
    $server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
    $server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
    $server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
    return $server_protocol . $server_name . $server_port . $path;
}

function pick_random_default_avatar()
{
    global $phpbb_root_path;
    $path = $phpbb_root_path . '/images/avatars/default/';
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

if (!$user_id || $userdata['user_id'] == $user_id) {
    $url = pick_random_default_avatar();
    header('Content-Type: image/png');
    print getUrlContents($url);
}

