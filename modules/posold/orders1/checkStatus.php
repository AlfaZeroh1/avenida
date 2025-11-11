<?php
session_start();
require_once("../../crm/customers/Customers_class.php");


$obj = (object)$_GET;

$i=$obj->i;
$id=$obj->id;

$customers = new Customers();
$fields="*";
$where=" where id='$id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$customers->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$customers = $customers->fetchObject;

echo $customers->statusid;

?>
