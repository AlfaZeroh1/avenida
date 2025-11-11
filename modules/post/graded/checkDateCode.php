<?php
session_start();
require_once "../../../lib.php";
require_once "../../../DB.php";
require_once "../../../modules/post/graded/Graded_class.php";

$db = new DB();

$obj = (object)$_GET;

$query="select * from post_graded where barcode like '$obj->vbarcode%' order by id desc limit 1";//echo $query;
$res=mysql_fetch_object(mysql_query($query));

$ebarcode=$obj->ebarcode;
$cod=strrpos($ebarcode,'-');
$datecode=substr($ebarcode,($cod+1)); 

$error="";
if($datecode!=$res->datecode){
$error="Please scan The correct employee bar code!";
$error="1|".$error;
}else{
$error="0|".$error;
}

echo $error;
?>