<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Statuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Statuss";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7599";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$statuss=new Statuss();
if(!empty($delid)){
	$statuss->id=$delid;
	$statuss->delete($statuss);
	redirect("statuss.php");
}
//Authorization.
$auth->roleid="7598";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addstatuss_proc.php',600,430);">Add Statuss </a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7600";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7601";//View
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
		$fields="con_statuss.id, con_statuss.name, con_statuss.remarks, con_statuss.ipaddress, con_statuss.createdby, con_statuss.createdon, con_statuss.lasteditedby, con_statuss.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$statuss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7600";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addstatuss_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7601";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='statuss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
