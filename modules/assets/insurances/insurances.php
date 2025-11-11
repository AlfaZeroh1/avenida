<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Insurances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Insurances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7659";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../hd.php";

$delid=$_GET['delid'];
$insurances=new Insurances();
if(!empty($delid)){
	$insurances->id=$delid;
	$insurances->delete($insurances);
	redirect("insurances.php");
}
//Authorization.
$auth->roleid="7658";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addinsurances_proc.php',600,430);" value="Add Insurances " class="btn"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Insurer </th>
			<th>Insur. Company </th>
			<th>Ref. # </th>
			<th>Insurance Date </th>
			<th>Scanned Copy </th>
			<th>Expiry Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7660";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7661";//View
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
		$fields="assets_insurances.id, assets_insurances.assetid, assets_insurances.insurerid, assets_insurances.insurcompany, assets_insurances.refno, assets_insurances.insuredon, assets_insurances.file, assets_insurances.expireson, assets_insurances.remarks, assets_insurances.ipaddress, assets_insurances.createdby, assets_insurances.createdon, assets_insurances.lasteditedby, assets_insurances.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$insurances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->insurerid; ?></td>
			<td><?php echo $row->insurcompany; ?></td>
			<td><?php echo $row->refno; ?></td>
			<td><?php echo formatDate($row->insuredon); ?></td>
			<td><?php echo $row->file; ?></td>
			<td><?php echo formatDate($row->expireson); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7660";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinsurances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7661";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='insurances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
