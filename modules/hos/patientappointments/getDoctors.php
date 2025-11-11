<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");

$ob = (object)$_GET;

$employees = new Employees();
$where=" where hrm_assignments.doctor=1  ";
$fields=" concat(hrm_employees.firstname,' ', hrm_employees.middlename,' ', hrm_employees.lastname) name, hrm_employees.id, hrm_employees.assignmentid ";
$join=" left join hrm_assignments on hrm_employees.assignmentid=hrm_assignments.id left join hrm_departments on hrm_departments.id=hrm_assignments.departmentid ";
$having="";
$groupby="";
$orderby="";
$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);//logging($employees->sql);
?>
<option value="">Select...</option>
<?php

while($row=mysql_fetch_object($employees->result)){
  ?>
    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
  <?php
}
?>