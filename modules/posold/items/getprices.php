<?php
require_once("../../../DB.php");
require_once("../categorys/Categorys_class.php");

$db = new DB();

$id = $_GET['id'];

$categorys = new Categorys();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$id' ";
$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

$categorys = $categorys->fetchObject;

echo $categorys->price;

?>