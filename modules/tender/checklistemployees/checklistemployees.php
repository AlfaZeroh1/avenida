<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklistemployees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Checklistemployees";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7732";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$checklistemployees=new Checklistemployees();
if(!empty($delid)){
	$checklistemployees->id=$delid;
	$checklistemployees->delete($checklistemployees);
	redirect("checklistemployees.php");
}
//Authorization.
$auth->roleid="7731";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addchecklistemployees_proc.php',600,430);" value="Add Checklistemployees " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Responsibility </th>
			<th>Assigned To </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7733";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7734";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="tender_checklistemployees.id, tender_checklists.name as checklistid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, tender_checklistemployees.remarks, tender_checklistemployees.ipaddress, tender_checklistemployees.createdby, tender_checklistemployees.createdon, tender_checklistemployees.lasteditedby, tender_checklistemployees.lasteditedon";
		$join=" left join tender_checklists on tender_checklistemployees.checklistid=tender_checklists.id  left join hrm_employees on tender_checklistemployees.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$checklistemployees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$checklistemployees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->checklistid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7733";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addchecklistemployees_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7734";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='checklistemployees.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
