<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Services_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Services";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7708";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$services=new Services();
if(!empty($delid)){
	$services->id=$delid;
	$services->delete($services);
	redirect("services.php");
}
//Authorization.
$auth->roleid="7707";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addservices_proc.php',600,430);" value="Add Services " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Service Schedule </th>
			<th>Supplier </th>
			<th>Invoice No </th>
			<th>Serviced On </th>
			<th>Service Type </th>
			<th>Description </th>
			<th>Recommendations </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7709";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7710";//View
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
		$fields="assets_services.id, assets_assets.name as assetid, assets_serviceschedules.name as servicescheduleid, proc_suppliers.name as supplierid, assets_services.documentno, assets_services.servicedon, assets_services.servicetype, assets_services.description, assets_services.recommendations, assets_services.remarks, assets_services.ipaddress, assets_services.createdby, assets_services.createdon, assets_services.lasteditedby, assets_services.lasteditedon";
		$join=" left join assets_assets on assets_services.assetid=assets_assets.id  left join assets_serviceschedules on assets_services.servicescheduleid=assets_serviceschedules.id  left join proc_suppliers on assets_services.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$services->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$services->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->servicescheduleid; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo formatDate($row->servicedon); ?></td>
			<td><?php echo $row->servicetype; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->recommendations; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7709";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addservices_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7710";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='services.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
