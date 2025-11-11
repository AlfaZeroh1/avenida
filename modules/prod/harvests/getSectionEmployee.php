<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/sections/Sections_class.php");

$ob = (object)$_GET;

$sections = new Sections();
$where=" where prod_sections.id='$ob->id' ";
$fields=" hrm_employees.id, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
$join=" left join hrm_employees on hrm_employees.id=prod_sections.employeeid ";
$having="";
$groupby="";
$orderby="";
$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

$sections = $sections->fetchObject;

echo $sections->id."-".$sections->name;
?>