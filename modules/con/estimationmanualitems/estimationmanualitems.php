<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimationmanualitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimationmanualitems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8524";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$estimationmanualid = $_GET['estimationmanualid'];
$estimationmanualitems=new Estimationmanualitems();
if(!empty($delid)){
	$estimationmanualitems->id=$delid;
	$estimationmanualitems->delete($estimationmanualitems);
	redirect("estimationmanualitems.php");
}
//Authorization.
$auth->roleid="8523";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addestimationmanualitems_proc.php',600,430);" value="Add Estimationmanualitems " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Inventory Item </th>
			<th>Labour </th>
			<th>Quantity </th>
			<th>Rate </th>
			<th>Total </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8525";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8526";//View
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
		$fields="con_estimationmanualitems.id, con_estimationmanuals.name as estimationmanualid, inv_items.name as itemid, con_labours.name as labourid, con_estimationmanualitems.quantity, con_estimationmanualitems.rate, con_estimationmanualitems.total, con_estimationmanualitems.remarks, con_estimationmanualitems.ipaddress, con_estimationmanualitems.createdby, con_estimationmanualitems.createdon, con_estimationmanualitems.lasteditedby, con_estimationmanualitems.lasteditedon";
		$join=" left join con_estimationmanuals on con_estimationmanualitems.estimationmanualid=con_estimationmanuals.id  left join inv_items on con_estimationmanualitems.itemid=inv_items.id  left join con_labours on con_estimationmanualitems.labourid=con_labours.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_estimationmanualitems.estimationmanualid='$estimationmanualid'";
		$estimationmanualitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$estimationmanualitems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->labourid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8525";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addestimationmanualitems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8526";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='estimationmanualitems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
