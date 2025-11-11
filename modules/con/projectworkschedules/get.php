<?php
require_once("../../../DB.php");
require_once("../../con/projectworkschedules/Projectworkschedules_class.php");

$ob = (object)$_GET;
$projectworkschedules = new Projectworkschedules();
$fields="*";
$where=" where id='$ob->id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$projectworkschedules = $projectworkschedules->fetchObject;

echo $projectworkschedules->projectweek."|".$projectworkschedules->week."|".$projectworkschedules->year;
?>