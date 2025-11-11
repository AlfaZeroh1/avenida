<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Unitofmeasures_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Unitofmeasures";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="736";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$unitofmeasures=new Unitofmeasures();
if(!empty($delid)){
	$unitofmeasures->id=$delid;
	$unitofmeasures->delete($unitofmeasures);
	redirect("unitofmeasures.php");
}
//Authorization.
$auth->roleid="735";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addunitofmeasures_proc.php',600,430);" value="Add Unitofmeasures " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Unit Of Measure </th>
			<th>Name </th>
<?php
//Authorization.
$auth->roleid="737";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="738";//View
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
		$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$unitofmeasures->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="737";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addunitofmeasures_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="738";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='unitofmeasures.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
