<?php
  header('Access-Control-Allow-Origin: *');

  //db接続
  $user = 'root';
  $pass = 'secret';
  
  try {
      // MySQLへの接続
      //$dbh = new PDO('mysql:host=db;dbname=test', 'root', 'secret');
      $dbh = new PDO('mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_9699b41f8abea79', 'bdbc5765369b41', 'f99a0919');
  
      // 接続を使用する
      $sth = $dbh->query('SELECT * FROM heroku_9699b41f8abea79.fooo;');

      $data = array();
      while($row = $sth->fetch(PDO::FETCH_ASSOC)){
        $data[]=array(
        'id'=>$row['id'],
        'name'=>$row['name'],
        'notification_token'=>$row['notification_token'],
        'access_token'=>$row['access_token']
        );
      }
      
      header("Access-Control-Allow-Origin: *");
      echo json_encode($data);

      // 接続を閉じる
      $sth = null;
      $dbh = null;
  
  } catch (PDOException $e) { // PDOExceptionをキャッチする
      print "エラー!: " . $e->getMessage() . "<br/gt;";
      die();
  }

?>
