<?php
include '../../functions.php';

$fp=$_REQUEST['fp'];
$code=$_REQUEST['code'];

if(strlen($code)!=4) die();

$conn=db__connect();

db__pushData($conn,"tp_fp",array("fp"=>$fp,"timestamp"=>time(),"code"=>$code),array("fp"=>$fp));

echo json_encode(array("code"=>$code));