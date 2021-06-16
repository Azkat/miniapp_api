<?php
  header('Access-Control-Allow-Origin: *');

  $notification_token = $_GET['notification_token']; 
  $channel_access_token = $_GET['channel_access_token'];

  //チャネルアクセストークンを取得する
  $url = 'https://api.line.me/v2/oauth/accessToken';
  $data = array(
      "grant_type" => "client_credentials",
      "client_id" => "1655993509",
      "client_secret" => "f065711da54cc0949483b9b1448d8a75",
  );
  $data = http_build_query($data, "", "&");
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
  $channel_access_token = $arr['access_token'];

  //後続メッセージを送信する
  $params = array(
    "number" => "1357"
  );
  $data = array(
    "templateName" => "order_comp_d_o_ja",
    //"params" => "",
    "notificationToken" => $notification_token,
  );
  $data = json_encode($data);
  echo   $data;
  echo   $channel_access_token;
  $header = array(
    "Content-Type:  application/json; charset=UTF-8",
    'Authorization: Bearer '. $channel_access_token,
    );
  $options = array(
    "http" => array(
      "method" => "POST",
      "header"  => implode("\r\n", $header),
      "content" => $data
    )
  );
  $context = stream_context_create($options);
  $json = file_get_contents("https://api.line.me/message/v3/notifier/send?target=service", false, $context);

?>
