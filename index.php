<?php

//LIFFアクセストークンを取得する
$liff_access_token = "";
if(isset($_GET['notification_token'])) {

  require "onwardMessages.php";

} else if(isset($_GET['access_token'])) { 

  require "firstMessages.php";

} else {

  require "getMessages.php";

}

?>
