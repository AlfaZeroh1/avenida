<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levelleavedays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Levelleavedays";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9299";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$levelleavedays=new Levelleavedays();
if(!empty($delid)){
	$levelleavedays->id=$delid;
	$levelleavedays->delete($levelleavedays);
	redirect("levelleavedays.php");
}
//Authorization.
$auth->roleid="9298";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addlevelleavedays_proc.php',600,430);" value="Add Levelleavedays " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Leave </th>
			<th>Level </th>
			<th>No OF Days</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9300";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9301";//Add
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
		$fields="hrm_levelleavedays.id, hrm_leaves.name as leaveid, hrm_levels.name as levelid, hrm_levelleavedays.leavedays, hrm_levelleavedays.remarks, hrm_levelleavedays.ipaddress, hrm_levelleavedays.createdby, hrm_levelleavedays.createdon, hrm_levelleavedays.lasteditedby, hrm_levelleavedays.lasteditedon";
		$join=" left join hrm_leaves on hrm_levelleavedays.leaveid=hrm_leaves.id  left join hrm_levels on hrm_levelleavedays.levelid=hrm_levels.id ";
		$having="";
		$groupby="";
		$orderby="";
		$levelleavedays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$levelleavedays->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->leaveid; ?></td>
			<td><?php echo $row->levelid; ?></td>
			<td><?php echo formatNumber($row->leavedays); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9300";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlevelleavedays_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9301";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='levelleavedays.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
