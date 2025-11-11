<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Insurances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Insurances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4500";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$insurances=new Insurances();
if(!empty($delid)){
	$insurances->id=$delid;
	$insurances->delete($insurances);
	redirect("insurances.php");
}
//Authorization.
$auth->roleid="4499";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addinsurances_proc.php',600,430);" value="Add Insurances " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Company Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4501";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4502";//Add
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
		$fields="hos_insurances.id, hos_insurances.name, hos_insurances.remarks, hos_insurances.createdby, hos_insurances.createdon, hos_insurances.lasteditedby, hos_insurances.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$insurances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4501";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinsurances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4502";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='insurances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
