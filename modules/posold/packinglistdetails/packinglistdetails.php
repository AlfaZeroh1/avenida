<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Packinglistdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Packinglistdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8668";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$packinglistdetails=new Packinglistdetails();
if(!empty($delid)){
	$packinglistdetails->id=$delid;
	$packinglistdetails->delete($packinglistdetails);
	redirect("packinglistdetails.php");
}
//Authorization.
$auth->roleid="8667";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addpackinglistdetails_proc.php',600,430);" value="Add Packinglistdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Packing List </th>
			<th>Product </th>
			<th>Quantity </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8669";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8670";//View
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
		$fields="pos_packinglistdetails.id, pos_packinglists.name as packinglistid, pos_items.name as itemid, pos_packinglistdetails.quantity, pos_packinglistdetails.memo, pos_packinglistdetails.ipaddress, pos_packinglistdetails.createdby, pos_packinglistdetails.createdon, pos_packinglistdetails.lasteditedby, pos_packinglistdetails.lasteditedon";
		$join=" left join pos_packinglists on pos_packinglistdetails.packinglistid=pos_packinglists.id  left join pos_items on pos_packinglistdetails.itemid=pos_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$packinglistdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$packinglistdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->packinglistid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8669";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpackinglistdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8670";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='packinglistdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
