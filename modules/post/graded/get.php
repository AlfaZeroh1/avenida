<?php
require_once("../../../DB.php");
require_once("../../hrm/employees/Employees_class.php");

$employees = new Employees();
$fields="hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
$where=" where hrm_employees.id='".$_GET['id']."'";
$join="";
$having="";
$groupby="";
$orderby="";
$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$employees = $employees->fetchObject;
echo "$employees->pfnum  $employees->names";
?>