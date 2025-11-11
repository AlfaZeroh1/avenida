<?php
session_start();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shpreturninwards'];
$shop[$i][$obj->field]=$obj->val;
$shop[$i]['total']=$obj->val*$obj->value2;
$_SESSION['shpreturninwards']=$shop;

?>