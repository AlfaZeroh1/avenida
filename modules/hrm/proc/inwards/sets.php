<?php
session_start();

$obj = (object)$_GET;

$shop = $_SESSION['shpinwards'];
$shop[$obj->id]['id']=$obj->checked;
$_SESSION['shpinwards']=$shop;

print_r($shop);
?>