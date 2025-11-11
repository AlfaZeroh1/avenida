<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Invoicedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Invoicedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8652";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$invoicedetails=new Invoicedetails();
if(!empty($delid)){
	$invoicedetails->id=$delid;
	$invoicedetails->delete($invoicedetails);
	redirect("invoicedetails.php");
}
//Authorization.
$auth->roleid="8651";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addinvoicedetails_proc.php',600,430);" value="Add Invoicedetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Invoice </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Price </th>
			<th>Discount </th>
			<th>Tax </th>
			<th>Bonus </th>
			<th>Profit </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="8653";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8654";//View
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
		$fields="pos_invoicedetails.id, pos_invoices.name as invoiceid, pos_items.name as itemid, pos_invoicedetails.quantity, pos_invoicedetails.price, pos_invoicedetails.discount, pos_invoicedetails.tax, pos_invoicedetails.bonus, pos_invoicedetails.profit, pos_invoicedetails.total, pos_invoicedetails.ipaddress, pos_invoicedetails.createdby, pos_invoicedetails.createdon, pos_invoicedetails.lasteditedby, pos_invoicedetails.lasteditedon";
		$join=" left join pos_invoices on pos_invoicedetails.invoiceid=pos_invoices.id  left join pos_items on pos_invoicedetails.itemid=pos_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$invoicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$invoicedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->invoiceid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->bonus); ?></td>
			<td><?php echo formatNumber($row->profit); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="8653";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinvoicedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8654";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='invoicedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
