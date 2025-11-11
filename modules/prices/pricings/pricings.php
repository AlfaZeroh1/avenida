<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Pricings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Pricings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8296";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$pricings=new Pricings();
if(!empty($delid)){
	$pricings->id=$delid;
	$pricings->delete($pricings);
	redirect("pricings.php");
}
//Authorization.
$auth->roleid="8295";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpricings_proc.php',600,430);" value="Add Pricings " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>Item </th>
			<th>Unit Price </th>
			<th>Available Quantity </th>
			<th>Market </th>
			<th>Location </th>
<?php
//Authorization.
$auth->roleid="8297";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8298";//View
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
		$fields="prices_pricings.id, prices_pricings.category, prices_pricings.item, prices_pricings.price, prices_pricings.quantity, prices_pricings.market, prices_pricings.location, prices_pricings.ipaddress, prices_pricings.createdby, prices_pricings.createdon, prices_pricings.lasteditedby, prices_pricings.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$pricings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$pricings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->category; ?></td>
			<td><?php echo $row->item; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->market; ?></td>
			<td><?php echo $row->location; ?></td>
<?php
//Authorization.
$auth->roleid="8297";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpricings_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8298";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='pricings.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
