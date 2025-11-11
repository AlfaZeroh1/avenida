<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nssfs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Nssfs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4839";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$nssfs=new Nssfs();
if(!empty($delid)){
	$nssfs->id=$delid;
	$nssfs->delete($nssfs);
	redirect("nssfs.php");
}
//Authorization.
$auth->roleid="4838";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addnssfs_proc.php',600,430);">Add Nssfs</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Double </th>
			<th>High </th>
			<th>% </th>
<?php
//Authorization.
$auth->roleid="4840";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4841";//Add
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
		$fields="hrm_nssfs.id, hrm_nssfs.low, hrm_nssfs.high, hrm_nssfs.amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$nssfs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$nssfs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo formatNumber($row->low); ?></td>
			<td><?php echo formatNumber($row->high); ?></td>
			<td><?php echo $row->amount; ?>%</td>
<?php
//Authorization.
$auth->roleid="4840";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addnssfs_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4841";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='nssfs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
