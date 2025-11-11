<?php
require_once("../../../DB.php");
require_once("../../prod/forecastings/Forecastings_class.php");

$ob = (object)$_GET;
$forecastings = new Forecastings();
$fields="*";
$where=" where id='$ob->id' ";
$join="";
$having="";
$groupby="";
$orderby="";
$forecastings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$forecastings = $forecastings->fetchObject;

echo $forecastings->week."|".$forecastings->year."|".date('n',strtotime($forecastings->year.'-W'.$forecastings->week));
?>