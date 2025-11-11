<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpurchaseorders_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Purchaseorders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="708";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchaseorders=new Purchaseorders();
if(!empty($delid)){
	$purchaseorders->id=$delid;
	$purchaseorders->delete($purchaseorders);
	redirect("purchaseorders.php");
}
//Authorization.
$auth->roleid="707";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addpurchaseorders_proc.php'>New Purchaseorders</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Document No. </th>
			<th>Requisition No </th>
			<th>Supplier </th>
			<th>Remarks </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>Tax </th>
			<th>Total </th>
			<th>Memo </th>
			<th>Order On </th>
<?php
//Authorization.
$auth->roleid="709";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="710";//View
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
		$fields="inv_purchaseorders.id, inv_purchaseorders.itemid, inv_purchaseorders.documentno, inv_purchaseorders.requisionno, inv_purchaseorders.supplierid, inv_purchaseorders.remarks, inv_purchaseorders.quantity, inv_purchaseorders.costprice, inv_purchaseorders.tradeprice, inv_purchaseorders.tax, inv_purchaseorders.total, inv_purchaseorders.memo, inv_purchaseorders.orderedon, inv_purchaseorders.createdby, inv_purchaseorders.createdon, inv_purchaseorders.lasteditedby, inv_purchaseorders.lasteditedon, inv_purchaseorders.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchaseorders->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->requisionno; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo formatDate($row->orderedon); ?></td>
<?php
//Authorization.
$auth->roleid="709";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpurchaseorders_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="710";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='purchaseorders.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
