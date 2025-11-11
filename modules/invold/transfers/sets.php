<?php
session_start();

$obj = (object)$_GET;

$shop = $_SESSION['shptransfers'];
$shop[$obj->id]['id']=$obj->checked;
$_SESSION['shptransfers']=$shop;
?>