<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectteams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectteams";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9048";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectteams=new Projectteams();
if(!empty($delid)){
	$projectteams->id=$delid;
	$projectteams->delete($projectteams);
	redirect("projectteams.php");
}
//Authorization.
$auth->roleid="9047";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectteams_proc.php',600,430);" value="Add Projectteams " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project </th>
			<th>Employee </th>
			<th>Team Position </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9049";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9050";//Add
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
		$fields="pm_projectteams.id, pm_projects.name as projectid, hrm_employees.name as employeeid, pm_teampositions.name as teampositionid, pm_projectteams.remarks, pm_projectteams.ipaddress, pm_projectteams.createdby, pm_projectteams.createdon, pm_projectteams.lasteditedby, pm_projectteams.lasteditedon";
		$join=" left join pm_projects on pm_projectteams.projectid=pm_projects.id  left join hrm_employees on pm_projectteams.employeeid=hrm_employees.id  left join pm_teampositions on pm_projectteams.teampositionid=pm_teampositions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectteams->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->teampositionid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9049";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectteams_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9050";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectteams.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
