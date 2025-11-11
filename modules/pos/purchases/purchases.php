<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchases_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpurchases_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Purchases";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2185";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchases=new Purchases();
if(!empty($delid)){
	$purchases->id=$delid;
	$purchases->delete($purchases);
	redirect("purchases.php");
}
//Authorization.
$auth->roleid="2184";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addpurchases_proc.php'>New Purchases</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Document No. </th>
			<th>Supplier </th>
			<th>Description </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>Discount </th>
			<th>Tax </th>
			<th>Bonus </th>
			<th>Total Taxable Purchase </th>
			<th>Purchase Mode </th>
			<th>Bought On </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="2186";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2187";//View
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
		$fields="pos_purchases.id, pos_items.name as itemid, pos_purchases.documentno, pos_suppliers.name as supplierid, pos_purchases.description, pos_purchases.quantity, pos_purchases.costprice, pos_purchases.tradeprice, pos_purchases.discount, pos_purchases.tax, pos_purchases.bonus, pos_purchases.total, pos_purchases.mode, pos_purchases.boughton, pos_purchases.memo, pos_purchases.createdby, pos_purchases.createdon, pos_purchases.lasteditedby, pos_purchases.lasteditedon, pos_purchases.ipaddress";
		$join=" left join pos_items on pos_purchases.itemid=pos_items.id  left join pos_suppliers on pos_purchases.supplierid=pos_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchases->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->bonus); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->mode; ?></td>
			<td><?php echo formatDate($row->boughton); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="2186";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpurchases_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2187";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='purchases.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
