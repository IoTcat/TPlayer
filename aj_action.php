<?php
include '../../functions.php';

$code=$_REQUEST['code'];
$name=$_REQUEST['name'];
$artist=$_REQUEST['artist'];
$url=$_REQUEST['url'];
$cover=$_REQUEST['cover'];
$lrc=$_REQUEST['lrc'];
$theme=$_REQUEST['theme'];
$planstatus=$_REQUEST['planstatus'];
$plantime=$_REQUEST['plantime'];
$planseek=$_REQUEST['planseek'];


$index=substr(md5(time()),6);
$timestamp=time();

db__pushData(db__connect(),"tp_action",array("index_"=>$index,"timestamp"=>$timestamp,"code"=>$code,"name"=>$name,"artist"=>$artist,"url"=>$url,"cover"=>$cover,"lrc"=>$lrc,"theme"=>$theme,"planstatus"=>$planstatus,"plantime"=>$plantime,"planseek"=>$planseek));


echo json_encode(array("code"=>1));

die();
