<?php
session_start();
require_once("../../proc/suppliers/Suppliers_class.php");


$obj = (object)$_GET;

$i=$obj->i;
$id=$obj->id;

$suppliers = new Suppliers();
$fields=" case when status='Active' then 1 else 2 end status ";
$where=" where id='$id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$suppliers->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$suppliers = $suppliers->fetchObject;

echo $suppliers->status;

?>
