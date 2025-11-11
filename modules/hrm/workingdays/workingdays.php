<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Workingdays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Workingdays";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1198";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$workingdays=new Workingdays();
if(!empty($delid)){
	$workingdays->id=$delid;
	$workingdays->delete($workingdays);
	redirect("workingdays.php");
}
//Authorization.
$auth->roleid="1197";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addworkingdays_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1199";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1200";//View
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
		$fields="hrm_workingdays.id, hrm_workingdays.name, hrm_workingdays.remarks, hrm_workingdays.ipaddress, hrm_workingdays.createdby, hrm_workingdays.createdon, hrm_workingdays.lasteditedby, hrm_workingdays.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$workingdays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$workingdays->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="1199";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addworkingdays_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="1200";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='workingdays.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
