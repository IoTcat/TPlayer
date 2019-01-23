<?php
include '../../functions.php';

$fp=$_REQUEST['fp'];

$conn=db__connect();
$res=db__getData($conn,"tp_fp","fp",$fp);

$count=count($res);

if(isset($res[$count-1]['code'])&&$res[$count-1]['code']!=null&&$res[$count-1]['timestamp']>time()-3600*12)
{
	echo json_encode(array("code"=>$res[$count-1]['code']));
}
else
{
	db__pushData($conn,"tp_fp",array("fp"=>$fp,"timestamp"=>time(),"code"=>substr(strval(rand(10000,19999)),1,4)));
	$res=db__getData($conn,"tp_fp","fp",$fp);
	$count=count($res);
	echo json_encode(array("code"=>$res[$count-1]['code']));
	
}

die();