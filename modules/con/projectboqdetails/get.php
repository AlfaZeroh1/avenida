<?php
require_once("../../../DB.php");
require_once("../../con/estimationmanuals/Estimationmanuals_class.php");

$ob = (object)$_GET;
$estimationmanuals = new Estimationmanuals();
$fields="*";
$where=" where id='$ob->id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$estimationmanuals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$estimationmanuals = $estimationmanuals->fetchObject;

echo "$estimationmanuals->unitofmeasureid";
?>