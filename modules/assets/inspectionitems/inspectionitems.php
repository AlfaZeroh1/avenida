<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inspectionitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Inspectionitems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8480";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categoryid=$_GET['categoryid'];
$inspectionitems=new Inspectionitems();
if(!empty($delid)){
	$inspectionitems->id=$delid;
	$inspectionitems->delete($inspectionitems);
	redirect("inspectionitems.php");
}
//Authorization.
$auth->roleid="8479";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addinspectionitems_proc.php?categoryid=<?php echo $categoryid; ?>',600,430);" value="Add Inspectionitems " type="button"/></div>
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
$auth->roleid="8481";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8482";//Add
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
		$fields="assets_inspectionitems.id, assets_inspectionitems.name, assets_categorys.name as categoryid, assets_inspectionitems.remarks, assets_inspectionitems.ipaddress, assets_inspectionitems.createdby, assets_inspectionitems.createdon, assets_inspectionitems.lasteditedby, assets_inspectionitems.lasteditedon";
		$join=" left join assets_categorys on assets_inspectionitems.categoryid=assets_categorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where assets_inspectionitems.categoryid='$categoryid' ";
		$inspectionitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inspectionitems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->name); ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8481";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinspectionitems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8482";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='inspectionitems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
