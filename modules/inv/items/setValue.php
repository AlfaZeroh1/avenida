<?php
require_once("../../sys/currencyrates/Currencyrates_class.php");

$id = $_GET['currencyid'];
// $date = date("Y-m-d"); 
$date="2016-06-28";
$costprice=$_GET['costprice'];

$currencys = new Currencyrates();
$fields="*";
$join="";
$where=" where currencyid='$id' and fromcurrencydate<='$date' and tocurrencydate>='$date' ";
$having="";
$groupby="";
$orderby="";
$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$currencys = $currencys->fetchObject;

$value=$currencys->rate*$costprice;

echo $value;

?>