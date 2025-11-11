<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Issuancedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Issuancedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8376";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$issuancedetails=new Issuancedetails();
if(!empty($delid)){
	$issuancedetails->id=$delid;
	$issuancedetails->delete($issuancedetails);
	redirect("issuancedetails.php");
}
//Authorization.
$auth->roleid="8375";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addissuancedetails_proc.php',600,430);" value="Add Issuancedetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Issuance </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8377";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8378";//View
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
		$fields="inv_issuancedetails.id, inv_issuancedetails.issuanceid, inv_items.name as itemid, inv_issuancedetails.quantity, inv_issuancedetails.remarks, inv_issuancedetails.ipaddress, inv_issuancedetails.createdby, inv_issuancedetails.createdon, inv_issuancedetails.lasteditedby, inv_issuancedetails.lasteditedon";
		$join=" left join inv_items on inv_issuancedetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$issuancedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$issuancedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->issuanceid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8377";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addissuancedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8378";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='issuancedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
