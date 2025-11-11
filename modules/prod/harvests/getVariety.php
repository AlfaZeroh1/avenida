<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/varietys/Varietys_class.php");

$ob = (object)$_GET;

$varietys = new Varietys();
$where=" where id='$ob->id' ";
$fields="*";
$join=" ";
$having="";
$groupby="";
$orderby="";
$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

$varietys = $varietys->fetchObject;

echo $varietys->stems;

?>