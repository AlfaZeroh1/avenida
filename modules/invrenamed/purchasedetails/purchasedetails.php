<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchasedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Purchasedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8372";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchasedetails=new Purchasedetails();
if(!empty($delid)){
	$purchasedetails->id=$delid;
	$purchasedetails->delete($purchasedetails);
	redirect("purchasedetails.php");
}
//Authorization.
$auth->roleid="8371";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpurchasedetails_proc.php',600,430);" value="Add Purchasedetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Purchase </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Discount </th>
			<th>Applicable Tax </th>
			<th>Bonus </th>
			<th>Total </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8373";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8374";//View
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
		$fields="inv_purchasedetails.id, inv_purchasedetails.purchaseid, inv_items.name as itemid, inv_purchasedetails.quantity, inv_purchasedetails.costprice, inv_purchasedetails.discount, inv_purchasedetails.tax, inv_purchasedetails.bonus, inv_purchasedetails.total, inv_purchasedetails.memo, inv_purchasedetails.ipaddress, inv_purchasedetails.createdby, inv_purchasedetails.createdon, inv_purchasedetails.lasteditedby, inv_purchasedetails.lasteditedon";
		$join=" left join inv_items on inv_purchasedetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$purchasedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchasedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->purchaseid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->bonus); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8373";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpurchasedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8374";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='purchasedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
