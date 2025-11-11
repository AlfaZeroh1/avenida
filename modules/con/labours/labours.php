<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Labours_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Labours";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8528";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$labours=new Labours();
if(!empty($delid)){
	$labours->id=$delid;
	$labours->delete($labours);
	redirect("labours.php");
}
//Authorization.
$auth->roleid="8527";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addlabours_proc.php',600,430);">Add Labours</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Labour Name </th>
			<th>Rate </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8529";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8530";//Add
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
		$fields="con_labours.id, con_labours.name, con_labours.rate, con_labours.remarks, con_labours.ipaddress, con_labours.createdby, con_labours.createdon, con_labours.lasteditedby, con_labours.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$labours->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$labours->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8529";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlabours_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8530";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='labours.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
