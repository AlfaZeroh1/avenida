<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchaseorders'];
$shop[$i]['costprice']=$obj->costprice;
$shop[$i]['total']=$shop[$i]['costprice']*$shop[$i]['quantity']*((100+$shop[$i]['tax'])/100);


$_SESSION['shppurchaseorders']=$shop;

?>