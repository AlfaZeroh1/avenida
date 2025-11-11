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
$auth->roleid="7788";//Add
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
$auth->roleid="7787";//View
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
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7789";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7790";//Add
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
		$fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
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
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7789";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addunitofmeasures_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7790";//View
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
