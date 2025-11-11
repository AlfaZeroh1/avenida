<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Consumables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Consumables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9404";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$consumables=new Consumables();
if(!empty($delid)){
	$consumables->id=$delid;
	$consumables->delete($consumables);
	redirect("consumables.php");
}
//Authorization.
$auth->roleid="9403";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addconsumables_proc.php',600,430);" value="Add Consumables " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Inspection Item </th>
			<th>Asset Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9405";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9406";//Add
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
		$fields="assets_consumables.id, assets_consumables.name, assets_categorys.name as categoryid, assets_consumables.remarks, assets_consumables.ipaddress, assets_consumables.createdby, assets_consumables.createdon, assets_consumables.lasteditedby, assets_consumables.lasteditedon";
		$join=" left join assets_categorys on assets_consumables.categoryid=assets_categorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$consumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$consumables->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9405";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addconsumables_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9406";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='consumables.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
