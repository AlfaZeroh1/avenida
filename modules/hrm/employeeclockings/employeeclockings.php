<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeclockings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeclockings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4827";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeclockings=new Employeeclockings();
if(!empty($delid)){
	$employeeclockings->id=$delid;
	$employeeclockings->delete($employeeclockings);
	redirect("employeeclockings.php");
}
//Authorization.
$auth->roleid="4826";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeeclockings_proc.php',600,430);" value="Add Employeeclockings " type="button"/></div>



<?php }?>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Start Time </th>
			<th>End Time </th>
			<th>Today Is? </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4828";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4829";//View
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
		$fields="hrm_employeeclockings.id, hrm_employees.name as employeeid, hrm_employeeclockings.starttime, hrm_employeeclockings.endtime, hrm_employeeclockings.today, hrm_employeeclockings.remarks, hrm_employeeclockings.createdby, hrm_employeeclockings.createdon, hrm_employeeclockings.lasteditedby, hrm_employeeclockings.lasteditedon";
		$join=" left join hrm_employees on hrm_employeeclockings.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeeclockings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeclockings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->starttime; ?></td>
			<td><?php echo $row->endtime; ?></td>
			<td><?php echo formatDate($row->today); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4828";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeclockings_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4829";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeeclockings.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
