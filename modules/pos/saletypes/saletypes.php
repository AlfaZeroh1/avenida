<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saletypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Saletypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9065";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$saletypes=new Saletypes();
if(!empty($delid)){
	$saletypes->id=$delid;
	$saletypes->delete($saletypes);
	redirect("saletypes.php");
}
//Authorization.
$auth->roleid="9064";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsaletypes_proc.php',600,430);" value="Add Saletypes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Saletype Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9066";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9067";//View
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
		$fields="pos_saletypes.id, pos_saletypes.name, pos_saletypes.remarks, pos_saletypes.ipaddress, pos_saletypes.createdby, pos_saletypes.createdon, pos_saletypes.lasteditedby, pos_saletypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$saletypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$saletypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9066";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsaletypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9067";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='saletypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
