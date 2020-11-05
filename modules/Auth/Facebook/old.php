<?php

define('IN_PHPBB', true);
define('SHOUTBOX', true);
$phpbb_root_path = '../../';
$shoutbox_config = [];
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);


function fb_parse_signed_request($signed_request, $secret) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
 
    // decode the data
    $sig = fb_base64_url_decode($encoded_sig);
    $data = json_decode(fb_base64_url_decode($payload), true);
 
    // confirm the signature
    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
    if (!\hash_equals($sig, $expected_sig)) {
       print('Bad Signed JSON signature!');
       return null;
    }
    if (time() - $data['issued_at'] > 3600) {
       print('Request expired!');
       return null;
    }
    return $data;
}
 
function fb_base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

function fb_get_user($fbreq) {
    if ($fbreq) {
        $fields = "?fields=id,name,email&access_token={$fbreq['oauth_token']}";
        $url = "https://graph.facebook.com/{$fbreq['user_id']}$fields";
        return json_decode(file_get_contents($url), true);
    }
}

function fb_get_user_by_token($token, $secret) {
    return fb_get_user(
        fb_parse_signed_request($token, $secret)
    );
}

$token = $_POST['fb']['r'] ?? null;
$user = fb_get_user_by_token($token, $board_config['facebook_secret']);

if ($user) {
    $index = $user['email'];
    $hash = md5($user['id']);
    $resultset = $db->sql_query("
        select a.user_id
        from phpbb_users_auth a
        join phpbb_users u
        on u.user_id = a.user_id
        where a.type = 'facebook'
        and a.index = '" . $db->sql_escape($index) . "'
        and a.hash = '$hash'
        and a.active = 1
        limit 1
    ");

    $row = $db->sql_fetchrow($resultset);
    if ($row) {
        $admin = false;
        $autologin = isset($HTTP_POST_VARS['autologin']);
        $session_id = session_begin($row['user_id'], $user_ip, PAGE_INDEX, FALSE, $autologin, $admin);
        redirect(append_sid("index.$phpEx", true));
        exit;
    }
}
redirect(append_sid("login.$phpEx", true));