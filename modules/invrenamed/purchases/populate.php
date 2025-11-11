<?php
session_start();
require_once("../../sys/vatclasses/Vatclasses_class.php");


$obj = (object)$_GET;

$i=$obj->i;
$id=$obj->id;
$shop = $_SESSION['shppurchases'];
$shop[$i]['vatclasseid']=$obj->id;
$_SESSION['shppurchases']=$shop;

$vatclasses = new Vatclasses();
$fields="*";
$where=" where id='$id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$vatclasses = $vatclasses->fetchObject;

echo $vatclasses->perc;

?>
