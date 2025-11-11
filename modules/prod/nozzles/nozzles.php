<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nozzles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Nozzles";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8712";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$nozzles=new Nozzles();
if(!empty($delid)){
	$nozzles->id=$delid;
	$nozzles->delete($nozzles);
	redirect("nozzles.php");
}
//Authorization.
$auth->roleid="8711";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addnozzles_proc.php',600,430);" value="Add Nozzles " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Nozzle Type </th>
			<th>REmarks </th>
<?php
//Authorization.
$auth->roleid="8713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8714";//View
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
		$fields="prod_nozzles.id, prod_nozzles.name, prod_nozzles.remarks, prod_nozzles.ipaddress, prod_nozzles.createdby, prod_nozzles.createdon, prod_nozzles.lasteditedby, prod_nozzles.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$nozzles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$nozzles->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addnozzles_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8714";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='nozzles.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
