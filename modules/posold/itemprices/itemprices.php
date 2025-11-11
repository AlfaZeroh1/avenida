<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemprices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Itemprices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2157";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$itemprices=new Itemprices();
if(!empty($delid)){
	$itemprices->id=$delid;
	$itemprices->delete($itemprices);
	redirect("itemprices.php");
}
//Authorization.
$auth->roleid="2156";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('additemprices_proc.php',600,430);" value="Add Itemprices " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Price Name </th>
			<th>Item </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="2158";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2159";//View
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
		$fields="pos_itemprices.id, pos_prices.name as priceid, pos_items.name as itemid, pos_itemprices.amount, pos_itemprices.remarks, pos_itemprices.createdby, pos_itemprices.createdon, pos_itemprices.lasteditedby, pos_itemprices.lasteditedon, pos_itemprices.ipaddress";
		$join=" left join pos_prices on pos_itemprices.priceid=pos_prices.id  left join pos_items on pos_itemprices.itemid=pos_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$itemprices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemprices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->priceid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="2158";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additemprices_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2159";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='itemprices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
