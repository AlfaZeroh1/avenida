<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Depreciations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Depreciations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11245";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$depreciations=new Depreciations();
if(!empty($delid)){
	$depreciations->id=$delid;
	$depreciations->delete($depreciations);
	redirect("depreciations.php");
}
//Authorization.
$auth->roleid="11244";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('adddepreciations_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset Name </th>
			<th>Deprecited On </th>
			<th>Amount </th>
			<th>Percentage </th>
			<th>Month </th>
			<th>Year </th>
<?php
//Authorization.
$auth->roleid="11246";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11247";//View
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
		$fields="assets_depreciations.id, assets_assets.name as assetid, assets_depreciations.depreciatedon, assets_depreciations.amount, assets_depreciations.perc, assets_depreciations.month, assets_depreciations.year, assets_depreciations.createdon, assets_depreciations.createdby, assets_depreciations.lasteditedon, assets_depreciations.lasteditedby";
		$join=" left join assets_assets on assets_depreciations.assetid=assets_assets.id ";
		$having="";
		$groupby="";
		$orderby="";
		$depreciations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$depreciations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo formatDate($row->depreciatedon); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->perc; ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
<?php
//Authorization.
$auth->roleid="11246";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddepreciations_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11247";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='depreciations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
