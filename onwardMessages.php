<?php
  header('Access-Control-Allow-Origin: *');

  $notification_token = $_GET['notification_token']; 
  $channel_access_token = $_GET['channel_access_token']; 

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
  $header = array(
    "Content-Type: application/json; charset=UTF-8",
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
