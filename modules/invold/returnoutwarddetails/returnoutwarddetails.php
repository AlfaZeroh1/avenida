<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnoutwarddetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Returnoutwarddetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8388";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returnoutwarddetails=new Returnoutwarddetails();
if(!empty($delid)){
	$returnoutwarddetails->id=$delid;
	$returnoutwarddetails->delete($returnoutwarddetails);
	redirect("returnoutwarddetails.php");
}
//Authorization.
$auth->roleid="8387";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addreturnoutwarddetails_proc.php',600,430);" value="Add Returnoutwarddetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Return Outward </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Applicable Tax </th>
			<th>Discount </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="8389";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8390";//View
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
		$fields="inv_returnoutwarddetails.id, inv_returnoutwards.name as returnoutwardid, inv_items.name as itemid, inv_returnoutwarddetails.quantity, inv_returnoutwarddetails.costprice, inv_returnoutwarddetails.tax, inv_returnoutwarddetails.discount, inv_returnoutwarddetails.total, inv_returnoutwarddetails.ipaddress, inv_returnoutwarddetails.createdby, inv_returnoutwarddetails.createdon, inv_returnoutwarddetails.lasteditedby, inv_returnoutwarddetails.lasteditedon";
		$join=" left join inv_returnoutwards on inv_returnoutwarddetails.returnoutwardid=inv_returnoutwards.id  left join inv_items on inv_returnoutwarddetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returnoutwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returnoutwarddetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->returnoutwardid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="8389";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreturnoutwarddetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8390";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returnoutwarddetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
