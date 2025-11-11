<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transferdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Transferdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9490";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$transferdetails=new Transferdetails();
if(!empty($delid)){
	$transferdetails->id=$delid;
	$transferdetails->delete($transferdetails);
	redirect("transferdetails.php");
}
//Authorization.
$auth->roleid="9489";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtransferdetails_proc.php',600,430);" value="Add Transferdetails " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Transfer </th>
			<th>Product </th>
			<th>Serial </th>
			<th>Quantity </th>
			<th>Cost </th>
			<th>Total </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="9491";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9492";//View
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
		$fields="inv_transferdetails.id, inv_transfers.name as transferid, inv_items.name as itemid, inv_transferdetails.code, inv_transferdetails.quantity, inv_transferdetails.costprice, inv_transferdetails.total, inv_transferdetails.memo, inv_transferdetails.ipaddress, inv_transferdetails.createdby, inv_transferdetails.createdon, inv_transferdetails.lasteditedby, inv_transferdetails.lasteditedon";
		$join=" left join inv_transfers on inv_transferdetails.transferid=inv_transfers.id  left join inv_items on inv_transferdetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$transferdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$transferdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->transferid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="9491";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtransferdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9492";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='transferdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
