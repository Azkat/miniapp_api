<?php
header('Access-Control-Allow-Origin: *');

$liff_access_token = $_GET['access_token']; 

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
  $arr = json_decode($json, true);
  $notificationToken = $arr['notificationToken'];

  try {
    // MySQLへの接続
    //$dbh = new PDO('mysql:host=db;dbname=test', 'root', 'secret');
    $dbh = new PDO('mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_9699b41f8abea79', 'bdbc5765369b41', 'f99a0919');

    // 接続を使用する
    $sql = 'INSERT INTO heroku_9699b41f8abea79.fooo (notification_token, access_token, channel_access_token) values ( "'. $notificationToken .'" ,"'. $liff_access_token .'" ,"'. $access_token .'");';   
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // 接続を閉じる
    $sth = null;
    $dbh = null;
    $stmt = null;

    } catch (PDOException $e) { // PDOExceptionをキャッチする
        print "エラー!: " . $e->getMessage() . "<br/gt;";
        die();
    }

?>
