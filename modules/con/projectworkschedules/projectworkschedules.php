<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectworkschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectworkschedules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8168";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectworkschedules=new Projectworkschedules();
if(!empty($delid)){
	$projectworkschedules->id=$delid;
	$projectworkschedules->delete($projectworkschedules);
	redirect("projectworkschedules.php");
}
//Authorization.
$auth->roleid="8167";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectworkschedules_proc.php',600,430);" value="Add Projectworkschedules " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>BoQ Item </th>
			<th>Person Responsible </th>
			<th>Project Week </th>
			<th>Calendar Week </th>
			<th>Year </th>
			<th>Priority </th>
			<th>Track Time </th>
			<th>Required Duration </th>
			<th>Req Duration Type </th>
			<th>Deadline </th>
			<th>Start Date </th>
			<th>Start Time </th>
			<th>End Date </th>
			<th>End Time </th>
			<th>Duration </th>
			<th>Duration Type </th>
			<th>Remind On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8169";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8170";//View
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
		$fields="con_projectworkschedules.id, con_projectboqs.name as projectboqid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, con_projectworkschedules.projectweek, con_projectworkschedules.week, con_projectworkschedules.year, con_projectworkschedules.priority, con_projectworkschedules.tracktime, con_projectworkschedules.reqduration, con_projectworkschedules.reqdurationtype, con_projectworkschedules.deadline, con_projectworkschedules.startdate, con_projectworkschedules.starttime, con_projectworkschedules.enddate, con_projectworkschedules.endtime, con_projectworkschedules.duration, con_projectworkschedules.durationtype, con_projectworkschedules.remind, con_projectworkschedules.remarks, con_projectworkschedules.ipaddress, con_projectworkschedules.createdby, con_projectworkschedules.createdon, con_projectworkschedules.lasteditedby, con_projectworkschedules.lasteditedon";
		$join=" left join con_projectboqs on con_projectworkschedules.projectboqid=con_projectboqs.id  left join hrm_employees on con_projectworkschedules.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectworkschedules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectboqid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->projectweek; ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->priority; ?></td>
			<td><?php echo $row->tracktime; ?></td>
			<td><?php echo $row->reqduration; ?></td>
			<td><?php echo $row->reqdurationtype; ?></td>
			<td><?php echo formatDate($row->deadline); ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo $row->starttime; ?></td>
			<td><?php echo formatDate($row->enddate); ?></td>
			<td><?php echo $row->endtime; ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo $row->durationtype; ?></td>
			<td><?php echo formatDate($row->remind); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8169";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectworkschedules_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8170";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectworkschedules.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
