<?php

//LIFFアクセストークンを取得する
$liff_access_token = "";
if(isset($_GET['access_token'])) { 
    $liff_access_token = $_GET['access_token']; 
}

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
$access_token = $arr['access_token'];
echo $access_token ;


//サービス通知トークンを取得する
$data = array(
    "liffAccessToken" => $liff_access_token,
  );
  $data = json_encode($data);
  $header = array(
    "Content-Type: application/json; charset=UTF-8",
    'Authorization: Bearer '. $access_token,
    );
  $options = array(
    "http" => array(
      "method" => "POST",
      "header"  => implode("\r\n", $header),
      "content" => $data
    )
  );
  $context = stream_context_create($options);
  $json = file_get_contents("https://api.line.me/message/v3/notifier/token", false, $context);
  $arr = json_decode($json, true);
  $notificationToken = $arr['notificationToken'];
  echo $notificationToken;


  //サービスメッセージを送る
  $params = array(
    "number" => "1357"
  );
  $data = array(
    "templateName" => "order_comp_s_o_ja",
    //"params" => "",
    "notificationToken" => $notificationToken,
  );
  $data = json_encode($data);
  echo   $data;
  $header = array(
    "Content-Type: application/json; charset=UTF-8",
    'Authorization: Bearer '. $access_token,
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

  //db接続
  $user = 'root';
  $pass = 'secret';
  
  try {
      // MySQLへの接続
      $dbh = new PDO('mysql:host=db;dbname=test', $user, $pass);
  
      // 接続を使用する
      $sth = $dbh->query('SELECT * from fooo');
      echo "<pre>";
      foreach($sth as $row) {
          print_r($row);
      }
      echo "</pre>";
  
      // 接続を閉じる
      $sth = null;
      $dbh = null;
  
  } catch (PDOException $e) { // PDOExceptionをキャッチする
      print "エラー!: " . $e->getMessage() . "<br/gt;";
      die();
  }

?>
