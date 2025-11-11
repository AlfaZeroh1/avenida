<?php
require_once("../../../DB.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");

$greenhouses = new Greenhouses();
$fields=" prod_blocks.id as id ";
$where=" where prod_greenhouses.id='".$_GET['id']."'";
$join=" left join prod_sections on prod_sections.id=prod_greenhouses.sectionid left join prod_blocks on prod_blocks.id=prod_sections.blockid ";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $greenhouses->sql;
$greenhouses = $greenhouses->fetchObject;
echo $greenhouses->id;

?>