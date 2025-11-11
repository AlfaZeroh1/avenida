<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reports_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Reports";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8854";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$reports=new Reports();
if(!empty($delid)){
	$reports->id=$delid;
	$reports->delete($reports);
	redirect("reports.php");
}
//Authorization.
$auth->roleid="8853";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addreports_proc.php',600,430);" value="Add Reports " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset </th>
			<th>Employee </th>
			<th>Date Reported </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8855";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8856";//Add
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
		$fields="assets_reports.id, assets_assets.name as assetid, hrm_employees.name as employeeid, assets_reports.reportedon, assets_reports.description, assets_reports.remarks, assets_reports.ipaddress, assets_reports.createdby, assets_reports.createdon, assets_reports.lasteditedby, assets_reports.lasteditedon";
		$join=" left join assets_assets on assets_reports.assetid=assets_assets.id  left join hrm_employees on assets_reports.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$reports->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$reports->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assetid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->reportedon); ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8855";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreports_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8856";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='reports.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
