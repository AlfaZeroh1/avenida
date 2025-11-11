<?php
session_start();
require_once("../../sys/vatclasses/Vatclasses_class.php");


$obj = (object)$_GET;

$i=$obj->i;
$id=$obj->id;
$shop = $_SESSION['shpinwards'];
$shop[$i]['vatclasseid']=$obj->id;


$vatclasses = new Vatclasses();
$fields="*";
$where=" where id='$id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$vatclasses = $vatclasses->fetchObject;

$shop[$i]['tax']=$vatclasses->perc;
$shop[$i]['total']=$shop[$i]['quantity']*$shop[$i]['costprice']*((100+$vatclasses->perc)/100);
$shop[$i]['vatamount']=$shop[$i]['quantity']*$shop[$i]['costprice']*$vatclasses->perc/100;

$_SESSION['shpinwards']=$shop;

echo $vatclasses->perc."|".$shop[$i]['vatamount']."|".$shop[$i]['total'];

?>
