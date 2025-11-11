<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Otherservices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Otherservices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1324";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$otherservices=new Otherservices();
if(!empty($delid)){
	$otherservices->id=$delid;
	$otherservices->delete($otherservices);
	redirect("otherservices.php");
}
//Authorization.
$auth->roleid="1323";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addotherservices_proc.php',600,430);" value="Add Otherservices " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Other Service </th>
			<th>Department </th>
			<th>Normal Charge </th>
			<th>Nssf Charge </th>
<?php
//Authorization.
$auth->roleid="1325";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1326";//View
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
		$fields="hos_otherservices.id, hos_otherservices.name, hos_departments.name as departmentid, hos_otherservices.charge,hos_otherservices.nssfcharge,  hos_otherservices.createdby, hos_otherservices.createdon, hos_otherservices.lasteditedby, hos_otherservices.lasteditedon";
		$join=" left join hos_departments on hos_otherservices.departmentid=hos_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$otherservices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo formatNumber($row->charge); ?></td>
			<td><?php echo formatNumber($row->nssfcharge); ?></td>
<?php
//Authorization.
$auth->roleid="1325";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addotherservices_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1326";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='otherservices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
