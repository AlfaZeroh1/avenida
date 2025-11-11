<?php
session_start();
require_once("../../../lib.php");
require_once("../banks/Banks_class.php");

$obj = (object)$_GET;
$banks=new Banks();
$fields="fn_banks.id,fn_banks.currencyid,sys_currencys.rate,sys_currencys.eurorate";
$join=" left join sys_currencys on fn_banks.currencyid=sys_currencys.id ";
$having="";
$groupby="";
$orderby="";
$where=" where fn_banks.id='$obj->id' ";
$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $banks->sql;
$banks=$banks->fetchObject;

echo $banks->currencyid."-".$banks->rate."-".$banks->eurorate;
?>