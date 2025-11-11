<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returninwarddetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Returninwarddetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8652";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returninwarddetails=new Returninwarddetails();
if(!empty($delid)){
	$returninwarddetails->id=$delid;
	$returninwarddetails->delete($returninwarddetails);
	redirect("returninwarddetails.php");
}
//Authorization.
$auth->roleid="8651";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addreturninwarddetails_proc.php',600,430);" value="Add Returninwarddetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Returninward </th>
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
		$fields="pos_returninwarddetails.id, pos_returninwards.name as returninwardid, pos_items.name as itemid, pos_returninwarddetails.quantity, pos_returninwarddetails.price, pos_returninwarddetails.discount, pos_returninwarddetails.tax, pos_returninwarddetails.bonus, pos_returninwarddetails.profit, pos_returninwarddetails.total, pos_returninwarddetails.ipaddress, pos_returninwarddetails.createdby, pos_returninwarddetails.createdon, pos_returninwarddetails.lasteditedby, pos_returninwarddetails.lasteditedon";
		$join=" left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id  left join pos_items on pos_returninwarddetails.itemid=pos_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returninwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returninwarddetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->returninwardid; ?></td>
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
			<td><a href="javascript:;" onclick="showPopWin('addreturninwarddetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8654";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returninwarddetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
