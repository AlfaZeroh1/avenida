<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimationmanuals_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimationmanuals";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8512";//View
$auth->levelid=$_SESSION['level'];

$type = $_GET['type'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$estimationmanuals=new Estimationmanuals();
if(!empty($delid)){
	$estimationmanuals->id=$delid;
	$estimationmanuals->delete($estimationmanuals);
	redirect("estimationmanuals.php");
}
//Authorization.
$auth->roleid="8511";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addestimationmanuals_proc.php',600,430);">Add Estimationmanuals</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Estimation Desc </th>
			<th>Unit Of Measure </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="8513";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8514";//View
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
		$fields="con_estimationmanuals.id, con_estimationmanuals.type, con_estimationmanuals.name, tender_unitofmeasures.name as unitofmeasureid, con_estimationmanuals.remarks, con_estimationmanuals.ipaddress, con_estimationmanuals.createdby, con_estimationmanuals.createdon, con_estimationmanuals.lasteditedby, con_estimationmanuals.lasteditedon";
		$join=" left join tender_unitofmeasures on con_estimationmanuals.unitofmeasureid=tender_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_estimationmanuals.type='$type'";
		$estimationmanuals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$estimationmanuals->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->unitofmeasureid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../estimationmanualitems/estimationmanualitems.php?estimationmanualid=<?php echo $row->id; ?>">Items</td>
<?php
//Authorization.
$auth->roleid="8513";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addestimationmanuals_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8514";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='estimationmanuals.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
