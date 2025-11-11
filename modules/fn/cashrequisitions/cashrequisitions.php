<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cashrequisitions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addcashrequisitions_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Cashrequisitions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8140";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$cashrequisitions=new Cashrequisitions();
if(!empty($delid)){
	$cashrequisitions->id=$delid;
	$cashrequisitions->delete($cashrequisitions);
	redirect("cashrequisitions.php");
}
//Authorization.
$auth->roleid="8139";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<a class="btn btn-info" href='addcashrequisitions_proc.php'>New Cashrequisitions</a>
<?php }?>
<div style="clear:both;"></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition No </th>
			<th>Project </th>
			<th>Requested By </th>
			<th>Req Description </th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8141";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8142";//View
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
		$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, con_projects.name as projectid, fn_cashrequisitions.employeeid, fn_cashrequisitions.description, fn_cashrequisitions.status, fn_cashrequisitions.remarks, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
		$join=" left join con_projects on fn_cashrequisitions.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$cashrequisitions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8141";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addcashrequisitions_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8142";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='cashrequisitions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
