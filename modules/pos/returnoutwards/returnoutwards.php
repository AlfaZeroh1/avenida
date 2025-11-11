<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnoutwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addreturnoutwards_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Returnoutwards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2197";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returnoutwards=new Returnoutwards();
if(!empty($delid)){
	$returnoutwards->id=$delid;
	$returnoutwards->delete($returnoutwards);
	redirect("returnoutwards.php");
}
//Authorization.
$auth->roleid="2196";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addreturnoutwards_proc.php'>New Returnoutwards</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
			<th>Receipt/Invoice No </th>
			<th>Credit Note No. </th>
			<th>Purchase Mode </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>VAT </th>
			<th>Discount </th>
			<th>Total </th>
			<th>Returned On </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="2198";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2199";//View
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
		$fields="pos_returnoutwards.id, pos_suppliers.name as supplierid, pos_returnoutwards.documentno, pos_returnoutwards.creditnoteno, pos_returnoutwards.mode, pos_items.name as itemid, pos_returnoutwards.quantity, pos_returnoutwards.costprice, pos_returnoutwards.tradeprice, pos_returnoutwards.tax, pos_returnoutwards.discount, pos_returnoutwards.total, pos_returnoutwards.returnedon, pos_returnoutwards.memo, pos_returnoutwards.createdby, pos_returnoutwards.createdon, pos_returnoutwards.lasteditedby, pos_returnoutwards.lasteditedon, pos_returnoutwards.ipaddress";
		$join=" left join pos_suppliers on pos_returnoutwards.supplierid=pos_suppliers.id  left join pos_items on pos_returnoutwards.itemid=pos_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returnoutwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returnoutwards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->creditnoteno; ?></td>
			<td><?php echo $row->mode; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo formatDate($row->returnedon); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="2198";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addreturnoutwards_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2199";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returnoutwards.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
