<?php
session_start();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchases'];
$shop[$i][$obj->field]=$obj->val;
$_SESSION['shppurchases']=$shop;
?>
