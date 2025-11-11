<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Nhifs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Nhifs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4835";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$nhifs=new Nhifs();
if(!empty($delid)){
	$nhifs->id=$delid;
	$nhifs->delete($nhifs);
	redirect("nhifs.php");
}
//Authorization.
$auth->roleid="4834";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addnhifs_proc.php',600,430);">Add Nhifs</a>
<?php }?>
<hr>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Double </th>
			<th>High </th>
			<th>Amount </th>
<?php
//Authorization.
$auth->roleid="4836";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4837";//Add
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
		$fields="hrm_nhifs.id, hrm_nhifs.low, hrm_nhifs.high, hrm_nhifs.amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$nhifs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$nhifs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo formatNumber($row->low); ?></td>
			<td><?php echo formatNumber($row->high); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
<?php
//Authorization.
$auth->roleid="4836";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addnhifs_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4837";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='nhifs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
