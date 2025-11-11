<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plantingdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plantingdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8584";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plantingdetails=new Plantingdetails();
if(!empty($delid)){
	$plantingdetails->id=$delid;
	$plantingdetails->delete($plantingdetails);
	redirect("plantingdetails.php");
}
//Authorization.
$auth->roleid="8583";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addplantingdetails_proc.php',600,430);" value="Add Plantingdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Planting </th>
			<th>Variety </th>
			<th>Area </th>
			<th>Quantity </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8585";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8586";//View
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
		$fields="prod_plantingdetails.id, prod_plantings.name as plantingid, prod_varietys.name as varietyid, prod_areas.name as areaid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
		$join=" left join prod_plantings on prod_plantingdetails.plantingid=prod_plantings.id  left join prod_varietys on prod_plantingdetails.varietyid=prod_varietys.id  left join prod_areas on prod_plantingdetails.areaid=prod_areas.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plantingdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plantingid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo $row->areaid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8585";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplantingdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8586";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plantingdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
