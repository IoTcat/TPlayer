<?php
include '../../functions.php';

$last=$_REQUEST['last'];
$code=$_REQUEST['code'];

$conn=db__connect();

$res=db__getData($conn,"tp_action","code",$code);

$count= count($res);

list($msec, $sec) = explode(' ', microtime());
$msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

if($res[$count-1]['index_']!=$last)
{
	echo json_encode(array("code"=>1,"index"=>$res[$count-1]['index_'],"name"=>$res[$count-1]['name'],"artist"=>$res[$count-1]['artist'],"url"=>$res[$count-1]['url'],"cover"=>$res[$count-1]['cover'],"lrc"=>$res[$count-1]['lrc'],"theme"=>$res[$count-1]['theme'],"plantime"=>$res[$count-1]['plantime'],"planseek"=>$res[$count-1]['planseek'],"planstatus"=>$res[$count-1]['planstatus'],"time"=>$msectime));
}
else echo json_encode(array("code"=>-1));

die();