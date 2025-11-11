<?php
session_start();
require_once("../../../lib.php");
require_once("../../../DB.php");

$obj = (object)$_POST;

$db = new DB();

$query="select max(orderedon) orderedon from proc_purchaseorders left join proc_purchaseorderdetails on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id where proc_purchaseorderdetails.itemid='$obj->itemid'";
// $r = mysql_fetch_object(mysql_query($query));

//get sold since that date
$query="select case when inv_items.package>0 then sum(pos_orderdetails.quantity)/inv_items.package else sum(pos_orderdetails.quantity) end quantity from pos_orderdetails left join pos_orders on pos_orderdetails.orderid=pos_orders.id left join inv_items on inv_items.id=pos_orderdetails.itemid where pos_orderdetails.itemid='$obj->itemid' and pos_orders.orderedon>=date_sub(date(now()), interval 7 day) ";//echo $query;
$r = mysql_fetch_object(mysql_query($query));

echo $r->quantity;

?>
