<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchaseorders'];
$shop[$i]['costprice']=$obj->costprice;
$shop[$i]['total']=$shop[$i]['costprice']*$shop[$i]['quantity']*((100+$shop[$i]['tax'])/100);
$shop[$i]['discountamount']=$shop[$i]['quantity']*$obj->costprice*($shop[$i]['discount']/100);

mysql_query("update inv_items set costprice='$obj->costprice' where id='$obj->itemid'");

$_SESSION['shppurchaseorders']=$shop;

echo $shop[$i]['total'];

?>