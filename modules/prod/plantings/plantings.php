<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plantings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addplantings_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Plantings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8588";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plantings=new Plantings();
if(!empty($delid)){
	$plantings->id=$delid;
	$plantings->delete($plantings);
	redirect("plantings.php");
}
//Authorization.
$auth->roleid="8587";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="btn btn-info" href='addplantings_proc.php'>New Plantings</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Planting No </th>
			<th>Breeder Delivery </th>
			<th>Breeder </th>
			<th>Planting Date </th>
			<th>Calendar Week </th>
			<th>Person In-Charge </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8589";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8590";//View
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
		$fields="prod_plantings.id, prod_plantings.documentno, prod_breederdeliverys.name as breederdeliveryid, prod_breeders.name as breederid, prod_plantings.plantedon, prod_plantings.week, hrm_employees.name as employeeid, prod_plantings.remarks, prod_plantings.ipaddress, prod_plantings.createdby, prod_plantings.createdon, prod_plantings.lasteditedby, prod_plantings.lasteditedon";
		$join=" left join prod_breederdeliverys on prod_plantings.breederdeliveryid=prod_breederdeliverys.id  left join prod_breeders on prod_plantings.breederid=prod_breeders.id  left join hrm_employees on prod_plantings.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plantings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plantings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->breederdeliveryid; ?></td>
			<td><?php echo $row->breederid; ?></td>
			<td><?php echo formatDate($row->plantedon); ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8589";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addplantings_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8590";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plantings.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
