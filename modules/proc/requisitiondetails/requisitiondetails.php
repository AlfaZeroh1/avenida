<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitiondetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Requisitiondetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8368";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$requisitiondetails=new Requisitiondetails();
if(!empty($delid)){
	$requisitiondetails->id=$delid;
	$requisitiondetails->delete($requisitiondetails);
	redirect("requisitiondetails.php");
}
//Authorization.
$auth->roleid="8367";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addrequisitiondetails_proc.php',600,430);" value="Add Requisitiondetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition </th>
			<th>Inventory Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Total </th>
			<th>Memo </th>
			<th>Required On </th>
<?php
//Authorization.
$auth->roleid="8369";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8370";//View
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
		$fields="proc_requisitiondetails.id, proc_requisitions.name as requisitionid, inv_items.name as itemid, proc_requisitiondetails.quantity, proc_requisitiondetails.costprice, proc_requisitiondetails.total, proc_requisitiondetails.memo, proc_requisitiondetails.requiredon, proc_requisitiondetails.ipaddress, proc_requisitiondetails.createdby, proc_requisitiondetails.createdon, proc_requisitiondetails.lasteditedby, proc_requisitiondetails.lasteditedon";
		$join=" left join proc_requisitions on proc_requisitiondetails.requisitionid=proc_requisitions.id  left join inv_items on proc_requisitiondetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$requisitiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$requisitiondetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->requisitionid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo formatDate($row->requiredon); ?></td>
<?php
//Authorization.
$auth->roleid="8369";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addrequisitiondetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8370";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='requisitiondetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
