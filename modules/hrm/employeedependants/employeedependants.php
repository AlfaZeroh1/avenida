<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedependants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeedependants";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4190";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeedependants=new Employeedependants();
if(!empty($delid)){
	$employeedependants->id=$delid;
	$employeedependants->delete($employeedependants);
	redirect("employeedependants.php");
}
//Authorization.
$auth->roleid="4189";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeedependants_proc.php',600,430);" value="Add Employeedependants " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Dependant </th>
			<th>DoB </th>
<?php
//Authorization.
$auth->roleid="4191";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4192";//View
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
		$fields="hrm_employeedependants.id, hrm_employees.name as employeeid, hrm_employeedependants.name, hrm_employeedependants.dob, hrm_employeedependants.createdby, hrm_employeedependants.createdon, hrm_employeedependants.lasteditedby, hrm_employeedependants.lasteditedon";
		$join=" left join hrm_employees on hrm_employeedependants.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeedependants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeedependants->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatDate($row->dob); ?></td>
<?php
//Authorization.
$auth->roleid="4191";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeedependants_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4192";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeedependants.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
