<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saleorderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Saleorderdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8336";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$saleorderdetails=new Saleorderdetails();
if(!empty($delid)){
	$saleorderdetails->id=$delid;
	$saleorderdetails->delete($saleorderdetails);
	redirect("saleorderdetails.php");
}
//Authorization.
$auth->roleid="8335";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsaleorderdetails_proc.php',600,430);" value="Add Saleorderdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Sale Order </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>Discount </th>
			<th>Tax </th>
			<th>Bonus </th>
			<th>Profit </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="8337";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8338";//View
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
		$fields="pos_saleorderdetails.id, pos_saleorders.name as saleorderid, pos_saleorderdetails.itemid, pos_saleorderdetails.quantity, pos_saleorderdetails.costprice, pos_saleorderdetails.tradeprice, pos_saleorderdetails.discount, pos_saleorderdetails.tax, pos_saleorderdetails.bonus, pos_saleorderdetails.profit, pos_saleorderdetails.total, pos_saleorderdetails.ipaddress, pos_saleorderdetails.createdby, pos_saleorderdetails.createdon, pos_saleorderdetails.lasteditedby, pos_saleorderdetails.lasteditedon";
		$join=" left join pos_saleorders on pos_saleorderdetails.saleorderid=pos_saleorders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$saleorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$saleorderdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->saleorderid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->bonus); ?></td>
			<td><?php echo formatNumber($row->profit); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="8337";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsaleorderdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8338";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='saleorderdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
