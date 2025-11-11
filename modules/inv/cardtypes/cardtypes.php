<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Cardtypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Cardtypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4742";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$cardtypes=new Cardtypes();
if(!empty($delid)){
	$cardtypes->id=$delid;
	$cardtypes->delete($cardtypes);
	redirect("cardtypes.php");
}
//Authorization.
$auth->roleid="4741";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcardtypes_proc.php',600,430);" value="Add Cardtypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Card Type </th>
			<th>Discount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4743";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4744";//View
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
		$fields="inv_cardtypes.id, inv_cardtypes.name, inv_cardtypes.discount, inv_cardtypes.remarks, inv_cardtypes.createdby, inv_cardtypes.createdon, inv_cardtypes.lasteditedby, inv_cardtypes.lasteditedon, inv_cardtypes.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$cardtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$cardtypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4743";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcardtypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4744";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='cardtypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
