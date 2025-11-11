<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnnotedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Returnnotedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8384";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returnnotedetails=new Returnnotedetails();
if(!empty($delid)){
	$returnnotedetails->id=$delid;
	$returnnotedetails->delete($returnnotedetails);
	redirect("returnnotedetails.php");
}
//Authorization.
$auth->roleid="8383";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addreturnnotedetails_proc.php',600,430);" value="Add Returnnotedetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Return Note </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Applicable Tax </th>
			<th>Discount </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="8385";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8386";//View
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
		$fields="inv_returnnotedetails.id, inv_returnnotes.name as returnnoteid, inv_items.name as itemid, inv_returnnotedetails.quantity, inv_returnnotedetails.costprice, inv_returnnotedetails.tax, inv_returnnotedetails.discount, inv_returnnotedetails.total, inv_returnnotedetails.ipaddress, inv_returnnotedetails.createdby, inv_returnnotedetails.createdon, inv_returnnotedetails.lasteditedby, inv_returnnotedetails.lasteditedon";
		$join=" left join inv_returnnotes on inv_returnnotedetails.returnnoteid=inv_returnnotes.id  left join inv_items on inv_returnnotedetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returnnotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returnnotedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->returnnoteid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="8385";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreturnnotedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8386";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returnnotedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
