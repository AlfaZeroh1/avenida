<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leavetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Leavetypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10601";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leavetypes=new Leavetypes();
if(!empty($delid)){
	$leavetypes->id=$delid;
	$leavetypes->delete($leavetypes);
	redirect("leavetypes.php");
}
//Authorization.
$auth->roleid="10600";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addleavetypes_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Days Entitled </th>
			<th>Type </th>
			<th>Maximum C/F </th>
			<th>Earning Rate </th>
			<th>Per</th>
			<th>Gender </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10602";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10603";//View
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
		$fields="hrm_leavetypes.id, hrm_leavetypes.name, hrm_leavetypes.noofdays, hrm_leavetypes.type, hrm_leavetypes.maxcf, hrm_leavetypes.earningrate, hrm_leavetypes.per, hrm_leavetypes.gender, hrm_leavetypes.remarks, hrm_leavetypes.ipaddress, hrm_leavetypes.createdby, hrm_leavetypes.createdon, hrm_leavetypes.lasteditedby, hrm_leavetypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$leavetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leavetypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->noofdays; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->maxcf; ?></td>
			<td><?php echo formatNumber($row->earningrate); ?></td>
			<td><?php echo $row->per; ?></td>
			<td><?php echo $row->gender; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10602";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addleavetypes_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10603";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='leavetypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
