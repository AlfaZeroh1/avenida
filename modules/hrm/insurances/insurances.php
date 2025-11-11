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
$auth->roleid="4234";//View
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
$auth->roleid="4233";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">

<a class="btn btn-info" onclick="showPopWin('addinsurances_proc.php',600,430);">Add Insurances</a>
<?php }?>

<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Insurance Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4235";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4236";//View
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
		$fields="hrm_insurances.id, hrm_insurances.name, hrm_insurances.remarks, hrm_insurances.createdby, hrm_insurances.createdon, hrm_insurances.lasteditedby, hrm_insurances.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
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
$auth->roleid="4235";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinsurances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4236";//View
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
</div>
<?php
include"../../../foot.php";
?>
