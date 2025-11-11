<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Uproots_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Uproots";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8612";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$uproots=new Uproots();
if(!empty($delid)){
	$uproots->id=$delid;
	$uproots->delete($uproots);
	redirect("uproots.php");
}
//Authorization.
$auth->roleid="8611";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('adduproots_proc.php',600,430);" value="Add Uproots " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Planting Detail </th>
			<th>Area </th>
			<th>Variety </th>
			<th>Quantity </th>
			<th>Date Reported </th>
			<th>Date Uprooted </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8613";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8614";//View
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
		$fields="prod_uproots.id, prod_varietys.name varietyid, prod_areas.name areaid, prod_blocks.name blockid, prod_uproots.quantity, prod_uproots.reportedon,prod_uproots.uprootedon, prod_uproots.remarks, prod_uproots.ipaddress, prod_uproots.createdby, prod_uproots.createdon, prod_uproots.lasteditedby, prod_uproots.lasteditedon";
		$join=" left join prod_plantingdetails on prod_uproots.plantingdetailid=prod_plantingdetails.id  left join prod_areas on prod_uproots.areaid=prod_areas.id  left join prod_varietys on prod_uproots.varietyid=prod_varietys.id left join prod_blocks on prod_blocks.id=prod_areas.blockid";
		$having="";
		$groupby="";
		$orderby="";
		$uproots->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$uproots->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->blockid." ".$row->areaid." ".$row->varietyid); ?></td>
			<td><?php echo $row->areaid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->reportedon); ?></td>
			<td><?php echo formatDate($row->uprootedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8613";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adduproots_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8614";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='uproots.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
