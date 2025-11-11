<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Purchaseorderdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8364";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchaseorderdetails=new Purchaseorderdetails();
if(!empty($delid)){
	$purchaseorderdetails->id=$delid;
	$purchaseorderdetails->delete($purchaseorderdetails);
	redirect("purchaseorderdetails.php");
}
//Authorization.
$auth->roleid="8363";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpurchaseorderdetails_proc.php',600,430);" value="Add Purchaseorderdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Purchase Order </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>Applicable Tax </th>
			<th>Total </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8365";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8366";//View
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
		$fields="proc_purchaseorderdetails.id, proc_purchaseorders.name as purchaseorderid, inv_items.name as itemid, proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.tradeprice, proc_purchaseorderdetails.tax, proc_purchaseorderdetails.total, proc_purchaseorderdetails.memo, proc_purchaseorderdetails.ipaddress, proc_purchaseorderdetails.createdby, proc_purchaseorderdetails.createdon, proc_purchaseorderdetails.lasteditedby, proc_purchaseorderdetails.lasteditedon";
		$join=" left join proc_purchaseorders on proc_purchaseorderdetails.purchaseorderid=proc_purchaseorders.id  left join inv_items on proc_purchaseorderdetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$purchaseorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchaseorderdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->purchaseorderid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8365";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpurchaseorderdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8366";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='purchaseorderdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
