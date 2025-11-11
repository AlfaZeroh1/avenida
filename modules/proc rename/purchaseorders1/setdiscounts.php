<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchaseorders'];
$shop[$i]['discount']=$obj->val;
$shop[$i]['discountamount']=$shop[$i]['quantity']*$shop[$i]['costprice']*($obj->val/100);

$_SESSION['shppurchaseorders']=$shop;

?>