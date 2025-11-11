<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Orderdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8660";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$orderdetails=new Orderdetails();
if(!empty($delid)){
	$orderdetails->id=$delid;
	$orderdetails->delete($orderdetails);
	redirect("orderdetails.php");
}
//Authorization.
$auth->roleid="8659";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addorderdetails_proc.php',600,430);" value="Add Orderdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product </th>
			<th>Quantity </th>
			<th>Memo </th>
			<th>Order </th>
<?php
//Authorization.
$auth->roleid="8661";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8662";//View
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
		$fields="pos_orderdetails.id, pos_items.name as itemid, pos_orderdetails.quantity, pos_orderdetails.memo, pos_orderdetails.ipaddress, pos_orderdetails.createdby, pos_orderdetails.createdon, pos_orderdetails.lasteditedby, pos_orderdetails.lasteditedon, pos_orders.name as orderid";
		$join=" left join pos_items on pos_orderdetails.itemid=pos_items.id  left join pos_orders on pos_orderdetails.orderid=pos_orders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$orderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$orderdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->orderid; ?></td>
<?php
//Authorization.
$auth->roleid="8661";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addorderdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8662";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='orderdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
