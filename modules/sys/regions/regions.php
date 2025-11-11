<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Regions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Regions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7772";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$regions=new Regions();
if(!empty($delid)){
	$regions->id=$delid;
	$regions->delete($regions);
	redirect("regions.php");
}
//Authorization.
$auth->roleid="7771";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addregions_proc.php',600,430);" value="Add Regions " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Region </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7773";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7774";//View
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
		$fields="sys_regions.id, sys_regions.name, sys_regions.remarks, sys_regions.ipaddress, sys_regions.createdby, sys_regions.createdon, sys_regions.lasteditedby, sys_regions.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$regions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7773";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addregions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7774";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='regions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
