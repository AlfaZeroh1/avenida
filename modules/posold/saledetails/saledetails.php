<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saledetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Saledetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8332";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$saledetails=new Saledetails();
if(!empty($delid)){
	$saledetails->id=$delid;
	$saledetails->delete($saledetails);
	redirect("saledetails.php");
}
//Authorization.
$auth->roleid="8331";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsaledetails_proc.php',600,430);" value="Add Saledetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Sale </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>Retail Price </th>
			<th>Discount </th>
			<th>Tax </th>
			<th>Bonus </th>
			<th>Profit </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="8333";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8334";//View
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
		$fields="pos_saledetails.id, pos_sales.name as saleid, inv_items.name as itemid, pos_saledetails.quantity, pos_saledetails.costprice, pos_saledetails.tradeprice, pos_saledetails.retailprice, pos_saledetails.discount, pos_saledetails.tax, pos_saledetails.bonus, pos_saledetails.profit, pos_saledetails.total, pos_saledetails.ipaddress, pos_saledetails.createdby, pos_saledetails.createdon, pos_saledetails.lasteditedby, pos_saledetails.lasteditedon";
		$join=" left join pos_sales on pos_saledetails.saleid=pos_sales.id  left join inv_items on pos_saledetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$saledetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$saledetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->saleid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->retailprice); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->bonus); ?></td>
			<td><?php echo formatNumber($row->profit); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="8333";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsaledetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8334";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='saledetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
