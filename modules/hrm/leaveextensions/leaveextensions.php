<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leaveextensions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Leaveextensions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10593";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leaveextensions=new Leaveextensions();
if(!empty($delid)){
	$leaveextensions->id=$delid;
	$leaveextensions->delete($leaveextensions);
	redirect("leaveextensions.php");
}
//Authorization.
$auth->roleid="10592";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addleaveextensions_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee Application </th>
			<th>Days </th>
			<th>Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10594";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10595";//Add
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
		$fields="hrm_leaveextensions.id, hrm_employeeleaveapplications.name as employeeleaveapplicationid, hrm_leaveextensions.days, hrm_leaveextensions.type, hrm_leaveextensions.remarks, hrm_leaveextensions.ipaddress, hrm_leaveextensions.createdby, hrm_leaveextensions.createdon, hrm_leaveextensions.lasteditedby, hrm_leaveextensions.lasteditedon";
		$join=" left join hrm_employeeleaveapplications on hrm_leaveextensions.employeeleaveapplicationid=hrm_employeeleaveapplications.id ";
		$having="";
		$groupby="";
		$orderby="";
		$leaveextensions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leaveextensions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeleaveapplicationid; ?></td>
			<td><?php echo $row->days; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10594";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addleaveextensions_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10595";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='leaveextensions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
