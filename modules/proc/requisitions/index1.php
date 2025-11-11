<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../inv/departments/Departments_class.php");

$db=new DB();

$page_title="Requisitions";
include"../../../head.php";
?>
<ul id="cmd-buttons">
<?php
$departments= new Departments();
$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
$join="";
$having="";
$groupby="";
$orderby="";
$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($row=mysql_fetch_object($departments->result)){
if(checkSubModule("proc","requisitions")){
?>
	
	<li><a class="button icon chat" href="../../proc/requisitions/addrequisitions_proc.php?departmentid=<?php echo $row->id; ?>&retrieve=1">Requisitions (<?php echo $row->code; ?>)</a></li>
	<?php
	}
}
?>
</ul>
<?php
include"../../../foot.php";
?>