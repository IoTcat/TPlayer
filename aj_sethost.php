<?php
include '../../functions.php';

$fp=$_REQUEST['fp'];
$code=$_REQUEST['code'];

if(strlen($code)==4)
{
	db__pushData(db__connect(),"tp_host",array("code"=>$code,"fp"=>$fp),array("code"=>$code));
	echo json_encode(array("code"=>1));
}
else
	echo json_encode(array("code"=>-1));

die();