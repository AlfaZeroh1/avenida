<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reportprogress_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Reportprogress";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8850";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$reportprogress=new Reportprogress();
if(!empty($delid)){
	$reportprogress->id=$delid;
	$reportprogress->delete($reportprogress);
	redirect("reportprogress.php");
}
//Authorization.
$auth->roleid="8849";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addreportprogress_proc.php',600,430);" value="Add Reportprogress " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Report </th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8851";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8852";//Add
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
		$fields="assets_reportprogress.id, assets_reports.name as reportid, assets_reportprogress.status, assets_reportprogress.remarks, assets_reportprogress.ipaddress, assets_reportprogress.createdby, assets_reportprogress.createdon, assets_reportprogress.lasteditedby, assets_reportprogress.lasteditedon";
		$join=" left join assets_reports on assets_reportprogress.reportid=assets_reports.id ";
		$having="";
		$groupby="";
		$orderby="";
		$reportprogress->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$reportprogress->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->reportid; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8851";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreportprogress_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8852";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='reportprogress.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
