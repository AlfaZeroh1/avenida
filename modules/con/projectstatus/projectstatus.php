<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectstatus_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectstatus";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7583";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectstatus=new Projectstatus();
if(!empty($delid)){
	$projectstatus->id=$delid;
	$projectstatus->delete($projectstatus);
	redirect("projectstatus.php");
}
//Authorization.
$auth->roleid="7582";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addprojectstatus_proc.php',600,430);">Add Projectstatus</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-stripped table-codensed" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project </th>
			<th>Status </th>
			<th>Status Changed On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7584";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7585";//View
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
		$fields="con_projectstatus.id, con_projects.name as projectid, con_statuss.name as statusid, con_projectstatus.changedon, con_projectstatus.remarks, con_projectstatus.ipaddress, con_projectstatus.createdby, con_projectstatus.createdon, con_projectstatus.lasteditedby, con_projectstatus.lasteditedon";
		$join=" left join con_projects on con_projectstatus.projectid=con_projects.id  left join con_statuss on con_projectstatus.statusid=con_statuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectstatus->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectstatus->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->statusid; ?></td>
			<td><?php echo formatDate($row->changedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7584";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectstatus_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7585";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectstatus.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
