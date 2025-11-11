<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subregions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Subregions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7776";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$subregions=new Subregions();
if(!empty($delid)){
	$subregions->id=$delid;
	$subregions->delete($subregions);
	redirect("subregions.php");
}
//Authorization.
$auth->roleid="7775";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsubregions_proc.php',600,430);" value="Add Subregions " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Sub Region </th>
			<th>Region </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7777";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7778";//View
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
		$fields="sys_subregions.id, sys_subregions.name, sys_regions.name as regionid, sys_subregions.remarks, sys_subregions.ipaddress, sys_subregions.createdby, sys_subregions.createdon, sys_subregions.lasteditedby, sys_subregions.lasteditedon";
		$join=" left join sys_regions on sys_subregions.regionid=sys_regions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$subregions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$subregions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->regionid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7777";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsubregions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7778";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='subregions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
