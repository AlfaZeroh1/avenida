<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedisplinarys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeedisplinarys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4831";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeedisplinarys=new Employeedisplinarys();
if(!empty($delid)){
	$employeedisplinarys->id=$delid;
	$employeedisplinarys->delete($employeedisplinarys);
	redirect("employeedisplinarys.php");
}
//Authorization.
$auth->roleid="4830";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeedisplinarys_proc.php',600,430);" value="Add Employeedisplinarys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Disciplinary Type </th>
			<th>Disciplinary Date </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4832";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4833";//Add
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
		$fields="hrm_employeedisplinarys.id, hrm_employees.name as employeeid, hrm_disciplinarytypes.name as disciplinarytypeid, hrm_employeedisplinarys.disciplinarydate, hrm_employeedisplinarys.description, hrm_employeedisplinarys.remarks, hrm_employeedisplinarys.createdby, hrm_employeedisplinarys.createdon, hrm_employeedisplinarys.lasteditedby, hrm_employeedisplinarys.lasteditedon";
		$join=" left join hrm_employees on hrm_employeedisplinarys.employeeid=hrm_employees.id  left join hrm_disciplinarytypes on hrm_employeedisplinarys.disciplinarytypeid=hrm_disciplinarytypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeedisplinarys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeedisplinarys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->disciplinarytypeid; ?></td>
			<td><?php echo formatDate($row->disciplinarydate); ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4832";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeedisplinarys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4833";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeedisplinarys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
