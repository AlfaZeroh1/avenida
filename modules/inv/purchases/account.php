<?php
session_start();

$obj = (object)$_GET;

$i=$obj->i;
$id=$obj->id;
$shop = $_SESSION['shppurchases'];
$shop[$i]['accountid']=$obj->id;
$_SESSION['shppurchases']=$shop;

?>
