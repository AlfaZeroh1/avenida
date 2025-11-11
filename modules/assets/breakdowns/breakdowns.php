<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breakdowns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Breakdowns";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7615";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../hd.php";

$delid=$_GET['delid'];
$breakdowns=new Breakdowns();
if(!empty($delid)){
	$breakdowns->id=$delid;
	$breakdowns->delete($breakdowns);
	redirect("breakdowns.php");
}
//Authorization.
$auth->roleid="7614";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addbreakdowns_proc.php',600,430);" value="Add Breakdowns " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Breakdown Description </th>
			<th>Break Down Date </th>
			<th>Date Of Reactivation </th>
			<th>Cost </th>
			<th>Ref. # </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7616";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7617";//View
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
		$fields="assets_breakdowns.id, assets_breakdowns.assetid, assets_breakdowns.description, assets_breakdowns.brokedownon, assets_breakdowns.reactivatedon, assets_breakdowns.cost, assets_breakdowns.refno, assets_breakdowns.remarks, assets_breakdowns.ipaddress, assets_breakdowns.createdby, assets_breakdowns.createdon, assets_breakdowns.lasteditedby, assets_breakdowns.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$breakdowns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$breakdowns->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo formatDate($row->brokedownon); ?></td>
			<td><?php echo formatDate($row->reactivatedon); ?></td>
			<td><?php echo formatNumber($row->cost); ?></td>
			<td><?php echo $row->refno; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7616";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbreakdowns_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7617";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='breakdowns.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
