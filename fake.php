<?php

function get_qq_status($uin) {
  if($uin > 9999) {
    error_reporting(0);
    $data = file_get_contents("http://webpresence.qq.com/getonline?type=1&{$uin}:");
    $data || $data = strlen(file_get_contents("http://wpa.qq.com/pa?p=2:{$uin}:45"));
    if(!$data) { return 0; }
    switch((string)$data) {
      case '854': case 'online[0]=0;': return 1;
      case '834': case 'online[0]=1;': return 2;
    }
  }
  return 3;
}

echo get_qq_status($_GET["uid"]);

?>