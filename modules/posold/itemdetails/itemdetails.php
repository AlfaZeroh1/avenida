<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Itemdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2153";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$itemdetails=new Itemdetails();
if(!empty($delid)){
	$itemdetails->id=$delid;
	$itemdetails->delete($itemdetails);
	redirect("itemdetails.php");
}
//Authorization.
$auth->roleid="2152";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('additemdetails_proc.php',600,430);" value="Add Itemdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item Name </th>
			<th>Scheme </th>
			<th>Parcel No </th>
			<th>Ground No </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="2154";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2155";//View
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
		$fields="pos_itemdetails.id, pos_items.name as itemid, pos_schemes.name as schemeid, pos_itemdetails.parcelno, pos_itemdetails.groundno, pos_itemdetails.status, pos_itemdetails.createdby, pos_itemdetails.createdon, pos_itemdetails.lasteditedby, pos_itemdetails.lasteditedon, pos_itemdetails.ipaddress";
		$join=" left join pos_items on pos_itemdetails.itemid=pos_items.id  left join pos_schemes on pos_itemdetails.schemeid=pos_schemes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$itemdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->schemeid; ?></td>
			<td><?php echo $row->parcelno; ?></td>
			<td><?php echo $row->groundno; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="2154";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additemdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2155";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='itemdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
