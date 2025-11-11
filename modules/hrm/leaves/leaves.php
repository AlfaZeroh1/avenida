<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leaves_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Leaves";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4242";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leaves=new Leaves();
if(!empty($delid)){
	$leaves->id=$delid;
	$leaves->delete($leaves);
	redirect("leaves.php");
}
//Authorization.
$auth->roleid="4241";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addleaves_proc.php',600,430);" value="Add Leaves " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Leave </th>
			<th>No Of Days </th>
			<th>Remarks </th>
			<th>Allowance To Cash </th>
<?php
//Authorization.
$auth->roleid="4243";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4244";//View
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
		$fields="hrm_leaves.id, hrm_leaves.name, hrm_leaves.days, hrm_leaves.remarks, hrm_leaves.createdby, hrm_leaves.createdon, hrm_leaves.lasteditedby, hrm_leaves.lasteditedon, hrm_leaves.ipaddress, hrm_allowances.name as allowanceid";
		$join=" left join hrm_allowances on hrm_leaves.allowanceid=hrm_allowances.id ";
		$having="";
		$groupby="";
		$orderby="";
		$leaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leaves->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->days; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->allowanceid; ?></td>
<?php
//Authorization.
$auth->roleid="4243";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addleaves_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4244";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='leaves.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
