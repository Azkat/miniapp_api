<?php

$url = 'https://api.line.me/v2/oauth/accessToken';

// POSTデータ
$data = array(
    "grant_type" => "client_credentials",
    "client_id" => "1655993509",
    "client_secret" => "f065711da54cc0949483b9b1448d8a75",
);
$data = http_build_query($data, "", "&");

// header
$header = array(
    "Content-Type: application/x-www-form-urlencoded",
    "Content-Length: ".strlen($data)
);

$context = array(
    "http" => array(
        "method"  => "POST",
        "header"  => implode("\r\n", $header),
        "content" => $data
    )
);

$json = file_get_contents($url, false, stream_context_create($context));
$arr = json_decode($json, true);

//echo $json
$access_token = $arr['access_token'];
echo $access_token

/* $url = 'https://api.line.me/message/v3/notifier/token';

// POSTデータ
$data = array(
    "liffAccessToken" => "1",
);
$data = http_build_query($data, "", "&");

// header
$header = array(
    "Content-Type: application/json",
    'Authorization: Bearer LWRqBo5PflLofo4At25WXs4pAW7b7h4bMLH0eASO8CNuHSU8VPY9qQxtZbfhjuxBEAlLZ8uHJxSIF6PbJV2+Arrfh3pDv9Y6r2fNq937FUw0YMPIor8ly/7sy7WAm9Vigy+YMeM61H0TqzpksKU+i49PbdgDzCFqoOLOYbqAITQ=',
);

$context = array(
    "http" => array(
        "method"  => "POST",
        "header"  => implode("\r\n", $header),
        "content" => $data
    )
);

$html = file_get_contents($url, false, stream_context_create($context));

echo $html; */



?>