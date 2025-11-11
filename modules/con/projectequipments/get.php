<?php
require_once("../../../DB.php");
require_once("../../con/equipments/Equipments_class.php");

$ob = (object)$_GET;
$equipments = new Equipments();
$fields="*";
$where=" where id='$ob->equipmentid' ";
$join="";
$having="";
$groupby="";
$orderby="";
$equipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$equipments = $equipments->fetchObject;

if($ob->type=="Hired")
  echo $equipments->hirecost;
if($ob->type=="Purchased")
  echo $equipments->purchasecost;
?>