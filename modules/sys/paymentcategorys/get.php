<?php
session_start();
require_once("../../../lib.php");
require_once("../../../DB.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");

$ob = (object)$_GET;

$paymentmodes=new Paymentmodes();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$ob->paymentmodeid' ";
$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$paymentmodes = $paymentmodes->fetchObject;

echo $paymentmodes->remarks;

?>

