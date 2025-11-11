<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchaseorders'];
$shop[$i]['vatclasseid']=$obj->vatclasseid;
$shop[$i]['tax']=$obj->tax;
$shop[$i]['taxamount']=(($shop[$i]['costprice']*$shop[$i]['quantity'])-($obj->discount*$shop[$i]['costprice']*$shop[$i]['quantity']/100))*(($obj->tax)/100);
$shop[$i]['total']=(($shop[$i]['costprice']*$shop[$i]['quantity'])-($obj->discount*$shop[$i]['costprice']*$shop[$i]['quantity']/100))*((100+$obj->tax)/100);

mysql_query("update inv_items set vatclasseid='$obj->vatclasseid' where id='$obj->itemid'");

$_SESSION['shppurchaseorders']=$shop;

?>