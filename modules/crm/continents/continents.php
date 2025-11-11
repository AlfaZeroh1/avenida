<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Continents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Continents";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8998";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$continents=new Continents();
if(!empty($delid)){
	$continents->id=$delid;
	$continents->delete($continents);
	redirect("continents.php");
}
//Authorization.
$auth->roleid="8997";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcontinents_proc.php',600,430);" value="Add Continents " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Continent </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8999";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9000";//Add
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
		$fields="crm_continents.id, crm_continents.name, crm_continents.remarks, crm_continents.ipaddress, crm_continents.createdby, crm_continents.createdon, crm_continents.lasteditedby, crm_continents.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$continents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$continents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8999";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcontinents_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9000";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='continents.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
