<?php
session_start();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shpreturnoutwards'];
$shop[$i][$obj->field]=$obj->val;
$_SESSION['shpreturnoutwards']=$shop; 

?>