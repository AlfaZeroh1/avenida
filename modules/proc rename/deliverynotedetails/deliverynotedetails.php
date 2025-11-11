<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deliverynotedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Deliverynotedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8356";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$deliverynotedetails=new Deliverynotedetails();
if(!empty($delid)){
	$deliverynotedetails->id=$delid;
	$deliverynotedetails->delete($deliverynotedetails);
	redirect("deliverynotedetails.php");
}
//Authorization.
$auth->roleid="8355";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddeliverynotedetails_proc.php',600,430);" value="Add Deliverynotedetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Delivery Note </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Total </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8357";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8358";//View
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
		$fields="proc_deliverynotedetails.id, proc_deliverynotes.name as deliverynoteid, inv_items.name as itemid, proc_deliverynotedetails.quantity, proc_deliverynotedetails.costprice, proc_deliverynotedetails.total, proc_deliverynotedetails.memo, proc_deliverynotedetails.ipaddress, proc_deliverynotedetails.createdby, proc_deliverynotedetails.createdon, proc_deliverynotedetails.lasteditedby, proc_deliverynotedetails.lasteditedon";
		$join=" left join proc_deliverynotes on proc_deliverynotedetails.deliverynoteid=proc_deliverynotes.id  left join inv_items on proc_deliverynotedetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$deliverynotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$deliverynotedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->deliverynoteid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8357";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddeliverynotedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8358";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='deliverynotedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
