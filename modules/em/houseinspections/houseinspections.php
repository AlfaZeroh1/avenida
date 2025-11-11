<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houseinspections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Houseinspections";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8104";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$houseinspections=new Houseinspections();
if(!empty($delid)){
	$houseinspections->id=$delid;
	$houseinspections->delete($houseinspections);
	redirect("houseinspections.php");
}
//Authorization.
$auth->roleid="8103";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addhouseinspections_proc.php',600,430);" value="Add Houseinspections " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Unit </th>
			<th>House Status </th>
			<th>Findings </th>
			<th>Recommendations </th>
			<th>Remarks </th>
			<th>Conducted By </th>
			<th>Conducted By </th>
<?php
//Authorization.
$auth->roleid="8105";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8106";//View
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
		$fields="em_houseinspections.id, em_houses.name as houseid, em_housestatuss.name as housestatusid, em_houseinspections.findings, em_houseinspections.recommendations, em_houseinspections.remarks, hrm_employees.name as employeeid, em_houseinspections.doneon, em_houseinspections.ipaddress, em_houseinspections.createdby, em_houseinspections.createdon, em_houseinspections.lasteditedby, em_houseinspections.lasteditedon";
		$join=" left join em_houses on em_houseinspections.houseid=em_houses.id  left join em_housestatuss on em_houseinspections.housestatusid=em_housestatuss.id  left join hrm_employees on em_houseinspections.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$houseinspections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$houseinspections->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->housestatusid; ?></td>
			<td><?php echo $row->findings; ?></td>
			<td><?php echo $row->recommendations; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->doneon); ?></td>
<?php
//Authorization.
$auth->roleid="8105";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhouseinspections_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8106";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='houseinspections.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
