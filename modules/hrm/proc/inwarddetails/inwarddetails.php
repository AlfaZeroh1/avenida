<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inwarddetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Inwarddetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8360";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$inwarddetails=new Inwarddetails();
if(!empty($delid)){
	$inwarddetails->id=$delid;
	$inwarddetails->delete($inwarddetails);
	redirect("inwarddetails.php");
}
//Authorization.
$auth->roleid="8359";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addinwarddetails_proc.php',600,430);" value="Add Inwarddetails " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Inward </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Total </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8361";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8362";//View
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
		$fields="proc_inwarddetails.id, proc_inwards.name as inwardid, inv_items.name as itemid, proc_inwarddetails.quantity, proc_inwarddetails.costprice, proc_inwarddetails.total, proc_inwarddetails.memo, proc_inwarddetails.ipaddress, proc_inwarddetails.createdby, proc_inwarddetails.createdon, proc_inwarddetails.lasteditedby, proc_inwarddetails.lasteditedon";
		$join=" left join proc_inwards on proc_inwarddetails.inwardid=proc_inwards.id  left join inv_items on proc_inwarddetails.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$inwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inwarddetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->inwardid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8361";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinwarddetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8362";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='inwarddetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
