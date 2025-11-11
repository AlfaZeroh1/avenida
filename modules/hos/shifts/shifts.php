<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Shifts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Shifts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11335";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$shifts=new Shifts();
if(!empty($delid)){
	$shifts->id=$delid;
	$shifts->delete($shifts);
	redirect("shifts.php");
}
//Authorization.
$auth->roleid="11334";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addshifts_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Type </th>
			<th>Start Date </th>
			<th>End Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="11336";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11337";//Add
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
		$fields="hos_shifts.id, hos_shifts.type, hos_shifts.starttime, hos_shifts.enddate, hos_shifts.remarks, hos_shifts.ipaddress, hos_shifts.createdby, hos_shifts.createdon, hos_shifts.lasteditedby, hos_shifts.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$shifts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo formatDate($row->starttime); ?></td>
			<td><?php echo formatDate($row->enddate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="11336";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addshifts_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11337";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='shifts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
