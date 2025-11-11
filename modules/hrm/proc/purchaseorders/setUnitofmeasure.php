<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchaseorders'];
$shop[$i]['unitofmeasureid']=$obj->val;

$_SESSION['shppurchaseorders']=$shop;

?>