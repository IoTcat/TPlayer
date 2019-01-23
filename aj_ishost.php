<?php
include '../../functions.php';

$fp=$_REQUEST['fp'];
$code=$_REQUEST['code'];


$conn=db__connect();

$res=db__getData($conn,"tp_host","code",$code);

if($res[0]['fp']==$fp) echo json_encode(array("code"=>1));
else echo json_encode(array("code"=>0));
