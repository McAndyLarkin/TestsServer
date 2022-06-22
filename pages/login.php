<?php
require '../config.php';

$config_private = $config_f['private'];
$post_body = file_get_contents('php://input');

if (!empty($post_body)) {
    $body = json_decode($post_body, true);
    $login = $body["login"];
    $password = $body["password"];
    if ($login == $config_private["admin_login"] 
            and $password == $config_private["admin_password"]) {
                http_response_code(200);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}