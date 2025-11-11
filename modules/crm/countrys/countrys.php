<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Countrys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Countrys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9002";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$countrys=new Countrys();
if(!empty($delid)){
	$countrys->id=$delid;
	$countrys->delete($countrys);
	redirect("countrys.php");
}
//Authorization.
$auth->roleid="9001";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcountrys_proc.php',600,430);" value="Add Countrys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Country </th>
			<th>Continent </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9003";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9004";//Add
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
		$fields="crm_countrys.id, crm_countrys.name, crm_continents.name as continentid, crm_countrys.remarks, crm_countrys.ipaddress, crm_countrys.createdby, crm_countrys.createdon, crm_countrys.lasteditedby, crm_countrys.lasteditedon";
		$join=" left join crm_continents on crm_continents.id=crm_countrys.continentid";
		$having="";
		$groupby="";
		$orderby="";
		$countrys->retrieve($fields,$join,$where,$having,$groupby,$orderby);// echo $countrys->sql;
		$res=$countrys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->continentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9003";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcountrys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9004";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='countrys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
