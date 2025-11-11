<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leavesection_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Leaves";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4242";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leavesection=new Leavesection();
if(!empty($delid)){
	$leavesection->id=$delid;
	$leavesection->delete($leavesection);
	redirect("leavesection.php");
}
//Authorization.
$auth->roleid="4241";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addleavesection_proc.php',600,430);" value="Add Leave Section" type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Section Id</th>
			<th>Section Name</th>
<?php
//Authorization.
$auth->roleid="4243";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4244";//View
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
		$fields="hrm_leavesections.sectionid, hrm_leavesections.sectionname";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$leavesection->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leavesection->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->sectionid; ?></td>
			<td><?php echo $row->sectionname; ?></td>
<?php
//Authorization.
$auth->roleid="4243";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addleavesection_proc.php?id=<?php echo $row->sectionid; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4244";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='leavesection.php?delid=<?php echo $row->sectionid; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
