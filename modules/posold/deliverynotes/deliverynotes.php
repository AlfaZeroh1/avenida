<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deliverynotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Deliverynotes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7507";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$deliverynotes=new Deliverynotes();
if(!empty($delid)){
	$deliverynotes->id=$delid;
	$deliverynotes->delete($deliverynotes);
	redirect("deliverynotes.php");
}
//Authorization.
$auth->roleid="7506";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('adddeliverynotes_proc.php',600,430);" value="Add Deliverynotes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Delivery Note </th>
			<th>LPO Number </th>
			<th>Customer </th>
			<th>Delivery Date </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7508";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7509";//View
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
		$fields="pos_deliverynotes.id, pos_deliverynotes.documentno, pos_deliverynotes.lpono, pos_deliverynotes.customerid, pos_deliverynotes.deliveredon, inv_items.name as itemid, pos_deliverynotes.quantity, pos_deliverynotes.remarks, pos_deliverynotes.ipaddress, pos_deliverynotes.createdby, pos_deliverynotes.createdon, pos_deliverynotes.lasteditedby, pos_deliverynotes.lasteditedon";
		$join=" left join inv_items on pos_deliverynotes.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$deliverynotes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->lpono; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo formatDate($row->deliveredon); ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7508";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddeliverynotes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7509";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='deliverynotes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
