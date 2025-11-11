<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Confirmedorderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Confirmedorderdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8700";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$confirmedorderdetails=new Confirmedorderdetails();
if(!empty($delid)){
	$confirmedorderdetails->id=$delid;
	$confirmedorderdetails->delete($confirmedorderdetails);
	redirect("confirmedorderdetails.php");
}
//Authorization.
$auth->roleid="8699";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addconfirmedorderdetails_proc.php',600,430);" value="Add Confirmedorderdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product </th>
			<th>Quantity </th>
			<th>Memo </th>
			<th>Confirmed Order </th>
<?php
//Authorization.
$auth->roleid="8701";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8702";//View
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
		$fields="pos_confirmedorderdetails.id, pos_items.name as itemid, pos_confirmedorderdetails.quantity, pos_confirmedorderdetails.memo, pos_confirmedorderdetails.ipaddress, pos_confirmedorderdetails.createdby, pos_confirmedorderdetails.createdon, pos_confirmedorderdetails.lasteditedby, pos_confirmedorderdetails.lasteditedon, pos_confirmedorders.name as confirmedorderid";
		$join=" left join pos_items on pos_confirmedorderdetails.itemid=pos_items.id  left join pos_confirmedorders on pos_confirmedorderdetails.confirmedorderid=pos_confirmedorders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$confirmedorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$confirmedorderdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->confirmedorderid; ?></td>
<?php
//Authorization.
$auth->roleid="8701";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addconfirmedorderdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8702";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='confirmedorderdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
