<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectusage_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectusage";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7591";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectusage=new Projectusage();
if(!empty($delid)){
	$projectusage->id=$delid;
	$projectusage->delete($projectusage);
	redirect("projectusage.php");
}
//Authorization.
$auth->roleid="7590";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addprojectusage_proc.php',800,430);">Add Projectusage</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-stripped table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Used On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7592";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7593";//View
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
		$fields="con_projectusage.id, con_projects.name as projectid, inv_items.name as itemid, con_projectusage.quantity, con_projectusage.usedon, con_projectusage.remarks, con_projectusage.ipaddress, con_projectusage.createdby, con_projectusage.createdon, con_projectusage.lasteditedby, con_projectusage.lasteditedon";
		$join=" left join con_projects on con_projectusage.projectid=con_projects.id  left join inv_items on con_projectusage.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectusage->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectusage->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->usedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7592";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectusage_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7593";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectusage.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
