<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Harvests_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addharvests_proc.php?status=".$_GET['status']."&retrieve=".$_GET['retrieve']);

$page_title="Harvests";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8580";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$harvests=new Harvests();
if(!empty($delid)){
	$harvests->id=$delid;
	$harvests->delete($harvests);
	redirect("harvests.php");
}
//Authorization.
$auth->roleid="8579";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="btn btn-info" href='addharvests_proc.php'>New Harvests</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Variety </th>
			<th>Sizes </th>
			<th>Planting Detail </th>
			<th>Area </th>
			<th>Quantity </th>
			<th>Date Harvested </th>
			<th>Employee </th>
			<th>BarCode </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8581";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8582";//View
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
		$fields="prod_harvests.id, prod_varietys.name as varietyid, prod_sizes.name as sizeid, prod_plantingdetails.name as plantingdetailid, prod_areas.name as areaid, prod_harvests.quantity, prod_harvests.harvestedon, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, prod_harvests.barcode, prod_harvests.remarks, prod_harvests.status, prod_harvests.ipaddress, prod_harvests.createdby, prod_harvests.createdon, prod_harvests.lasteditedby, prod_harvests.lasteditedon";
		$join=" left join prod_varietys on prod_harvests.varietyid=prod_varietys.id  left join prod_sizes on prod_harvests.sizeid=prod_sizes.id  left join prod_plantingdetails on prod_harvests.plantingdetailid=prod_plantingdetails.id  left join prod_areas on prod_harvests.areaid=prod_areas.id  left join hrm_employees on prod_harvests.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$harvests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$harvests->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo $row->plantingdetailid; ?></td>
			<td><?php echo $row->areaid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->harvestedon); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->barcode; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8581";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addharvests_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8582";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='harvests.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
