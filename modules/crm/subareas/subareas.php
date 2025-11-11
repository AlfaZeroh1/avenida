<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subareas_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Subareas";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4803";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$subareas=new Subareas();
if(!empty($delid)){
	$subareas->id=$delid;
	$subareas->delete($subareas);
	redirect("subareas.php");
}
//Authorization.
$auth->roleid="4802";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addsubareas_proc.php',600,430);" value="Add Subareas " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Sub Area </th>
			<th>Area </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4804";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4805";//Add
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
		$fields="crm_subareas.id, crm_subareas.name, crm_areas.name as areaid, crm_subareas.remarks, crm_subareas.createdby, crm_subareas.createdon, crm_subareas.lasteditedby, crm_subareas.lasteditedon";
		$join=" left join crm_areas on crm_subareas.areaid=crm_areas.id ";
		$having="";
		$groupby="";
		$orderby="";
		$subareas->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$subareas->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->areaid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4804";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsubareas_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4805";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='subareas.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
