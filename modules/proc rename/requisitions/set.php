<?php
session_start();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shprequisitions'];
$shop[$i][$obj->field]=$obj->val;
$_SESSION['shprequisitions']=$shop;

?>