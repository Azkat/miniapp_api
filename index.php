<?php

//LIFFアクセストークンを取得する
$liff_access_token = "";
if(isset($_GET['access_token'])) { 
  require "firstMessages.php";
    $liff_access_token = $_GET['access_token']; 
} else {
  require "getMessages.php";
}

?>
