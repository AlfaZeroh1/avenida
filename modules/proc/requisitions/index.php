<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../inv/departments/Departments_class.php");
require_once("../../hrm/assignments/Assignments_class.php");

$db=new DB();

$page_title="Requisitions";
include"../../../head.php";
?>
<ul id="cmd-buttons">
<?php

$query="select * from hrm_assignments  where id in(select assignmentid from hrm_employees where id='".$_SESSION['employeeid']."') ";
$rs=mysql_fetch_object(mysql_query($query));
if($rs->departmentid==1 or $rs->departmentid==10){
  $rs->departmentid='10,1';
}elseif($rs->departmentid==7 or $rs->departmentid==8){
  $rs->departmentid='7,8';
}

$departments= new Departments();
$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
$join="";
$having="";
$groupby="";
$where=" where departmentid in($rs->departmentid)";
$orderby="";
$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $departments->sql;
while($row=mysql_fetch_object($departments->result)){
if(checkSubModule("proc","requisitions")){
?>
	
	<li><a class="button icon chat" href="../../proc/requisitions/addrequisitions_proc.php?departmentid=<?php echo $row->id; ?>">Requisitions (<?php echo $row->code; ?>)</a></li>
	<?php
	}
}
?>
      <?php if(checkSubModule("proc","requisitions")){?>
      <li><a class="button icon chat" href="../../proc/requisitions/index1.php">Retrieve Requisitions</a></li>
      <?php } ?>
</ul>
<?php
include"../../../foot.php";
?>