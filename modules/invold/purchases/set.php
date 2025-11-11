<?php
session_start();

$obj = (object)$_GET;

$i=$obj->i;
$shop = $_SESSION['shppurchases'];
$shop[$i]['quantity']=$obj->val;
$shop[$i]['vatamount'] = $shop[$i]['quantity']*$shop[$i]['costprice']*$shop[$i]['tax']/100;
$shop[$i]['total'] = ($shop[$i]['quantity']*$shop[$i]['costprice']);
$shop[$i]['ttotal'] = $shop[$i]['total']+$shop[$i]['vatamount'];
$_SESSION['shppurchases']=$shop;

echo $shop[$i]['vatamount']."|".$shop[$i]['total']."|".$shop[$i]['ttotal'];
?>