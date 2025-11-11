<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeedocuments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4194";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeedocuments=new Employeedocuments();
if(!empty($delid)){
	$employeedocuments->id=$delid;
	$employeedocuments->delete($employeedocuments);
	redirect("employeedocuments.php");
}
//Authorization.
$auth->roleid="4193";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeedocuments_proc.php',600,430);" value="Add Employeedocuments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Document Type </th>
			<th>Browse Document </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4195";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4196";//View
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
		$fields="hrm_employeedocuments.id, hrm_employees.name as employeeid, dms_documenttypes.name as documenttypeid, hrm_employeedocuments.file, hrm_employeedocuments.remarks, hrm_employeedocuments.createdby, hrm_employeedocuments.createdon, hrm_employeedocuments.lasteditedby, hrm_employeedocuments.lasteditedon, hrm_employeedocuments.ipaddress";
		$join=" left join hrm_employees on hrm_employeedocuments.employeeid=hrm_employees.id  left join dms_documenttypes on hrm_employeedocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeedocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeedocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->file; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4195";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeedocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4196";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeedocuments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
