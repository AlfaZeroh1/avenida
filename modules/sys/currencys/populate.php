<?php
require_once("../currencyrates/Currencyrates_class.php");

$id = $_GET['id'];

$ob = (object)$_GET;

$currencys = new Currencyrates();
$fields="sys_currencyrates.rate, sys_currencyrates.eurorate, sys_currencys.name";
$join=" left join sys_currencys on sys_currencys.id=sys_currencyrates.currencyid ";
$where=" where currencyid='$id' and fromcurrencydate<='$ob->date' and tocurrencydate>='$ob->date' ";
$having="";
$groupby="";
$orderby="";
$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$currencys = $currencys->fetchObject;

echo $currencys->rate."-".$currencys->eurorate."-".$currencys->name;
?>