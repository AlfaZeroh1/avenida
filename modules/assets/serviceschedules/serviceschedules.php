<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Serviceschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Serviceschedules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7712";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$serviceschedules=new Serviceschedules();
if(!empty($delid)){
	$serviceschedules->id=$delid;
	$serviceschedules->delete($serviceschedules);
	redirect("serviceschedules.php");
}
//Authorization.
$auth->roleid="7711";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addserviceschedules_proc.php',600,430);" value="Add Serviceschedules " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Service Date </th>
			<th>Service Type </th>
			<th>Description </th>
			<th>Recommendations </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7714";//View
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
		$fields="assets_serviceschedules.id, assets_assets.name as assetid, assets_serviceschedules.servicedate, assets_servicetypes.name as servicetypeid, assets_serviceschedules.description, assets_serviceschedules.recommendations, assets_serviceschedules.remarks, assets_serviceschedules.ipaddress, assets_serviceschedules.createdby, assets_serviceschedules.createdon, assets_serviceschedules.lasteditedby, assets_serviceschedules.lasteditedon";
		$join=" left join assets_assets on assets_serviceschedules.assetid=assets_assets.id  left join assets_servicetypes on assets_serviceschedules.servicetypeid=assets_servicetypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$serviceschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$serviceschedules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo formatDate($row->servicedate); ?></td>
			<td><?php echo $row->servicetypeid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->recommendations; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addserviceschedules_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7714";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='serviceschedules.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
