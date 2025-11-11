<?php
require_once("Currencyrates_class.php");

$id = $_GET['id'];
$date = $_GET['date']; 

$currencys = new Currencyrates();
$fields="*";
$join="";
$where=" where currencyid='$id' and fromcurrencydate<='$date' and tocurrencydate>='$date' ";
$having="";
$groupby="";
$orderby="";
$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$currencys = $currencys->fetchObject;
if(empty($currencys->rate))
   echo 1;
else
   echo $currencys->rate."-".$currencys->eurorate;
?>