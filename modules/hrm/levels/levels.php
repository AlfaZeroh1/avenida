<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Levels";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7475";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$levels=new Levels();
if(!empty($delid)){
	$levels->id=$delid;
	$levels->delete($levels);
	redirect("levels.php");
}
//Authorization.
$auth->roleid="7474";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addlevels_proc.php',600,430);">Add Levels</a>
<?php }?>
<hr>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Level </th>
			<th>Max In Organisation </th>
			<th>Max In Each Dept </th>
			<th>Comes After </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="7476";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7477";//View
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
		$fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_level.name follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
		$join=" left join hrm_levels hrm_level on hrm_levels.follows=hrm_level.id ";
		$having="";
		$groupby="";
		$orderby="";
		$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$levels->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->overallno; ?></td>
			<td><?php echo $row->deptno; ?></td>
			<td><?php echo $row->follows; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../../hrm/employeeoffs/employeeoffs.php?levelid=<?php echo $row->id; ?>">Off Days</a></td>
<?php
//Authorization.
$auth->roleid="7476";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlevels_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7477";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='levels.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

<hr>
</div> <!-- containerEnd -->
<?php
include"../../../foot.php";
?>
