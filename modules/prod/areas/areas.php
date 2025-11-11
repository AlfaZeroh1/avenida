<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Areas_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Areas";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8552";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$areas=new Areas();
if(!empty($delid)){
	$areas->id=$delid;
	$areas->delete($areas);
	redirect("areas.php");
}
//Authorization.
$auth->roleid="8551";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addareas_proc.php',600,430);" value="Add Areas " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Block </th>
			<th>Area </th>
			<th>Size </th>
			<th>No Of Plants </th>
			<th>Status </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="8553";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8554";//View
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
		$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.noofplants, prod_blocks.name as blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
		$join=" left join prod_blocks on prod_areas.blockid=prod_blocks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$areas->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->blockid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->size; ?></td>
			<td><?php echo $row->noofplants; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../areavarietys/areavarietys.php?areaid=<?php echo $row->id; ?>">Varieties</a></td>
<?php
//Authorization.
$auth->roleid="8553";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addareas_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8554";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='areas.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
