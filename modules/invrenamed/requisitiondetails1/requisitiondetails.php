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
$auth->roleid="9430";//View
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
$auth->roleid="9429";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addrequisitiondetails_proc.php',600,430);" value="Add Requisitiondetails " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Requisition </th>
			<th>Product </th>
			<th>Quantity </th>
			<th>Approved Qnt </th>
			<th>Purpose </th>
			<th>Memo </th>
			<th>Block </th>
			<th>Section </th>
			<th>Green House </th>
<?php
//Authorization.
$auth->roleid="9431";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9432";//View
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
		$fields="inv_requisitiondetails.id, inv_requisitiondetails.requisitionid, inv_items.name as itemid, inv_requisitiondetails.quantity, inv_requisitiondetails.aquantity, inv_requisitiondetails.purpose, inv_requisitiondetails.memo, prod_blocks.name as blockid, prod_sections.name as sectionid, prod_greenhouses.name as greenhouseid, inv_requisitiondetails.ipaddress, inv_requisitiondetails.createdby, inv_requisitiondetails.createdon, inv_requisitiondetails.lasteditedby, inv_requisitiondetails.lasteditedon";
		$join=" left join inv_items on inv_requisitiondetails.itemid=inv_items.id  left join prod_blocks on inv_requisitiondetails.blockid=prod_blocks.id  left join prod_sections on inv_requisitiondetails.sectionid=prod_sections.id  left join prod_greenhouses on inv_requisitiondetails.greenhouseid=prod_greenhouses.id ";
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
			<td><?php echo formatNumber($row->aquantity); ?></td>
			<td><?php echo $row->purpose; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->blockid; ?></td>
			<td><?php echo $row->sectionid; ?></td>
			<td><?php echo $row->greenhouseid; ?></td>
<?php
//Authorization.
$auth->roleid="9431";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addrequisitiondetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9432";//View
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
