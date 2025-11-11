<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Payes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4843";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$payes=new Payes();
if(!empty($delid)){
	$payes->id=$delid;
	$payes->delete($payes);
	redirect("payes.php");
}
//Authorization.
$auth->roleid="4842";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addpayes_proc.php',600,430);">Add Payes</a>
<?php }?>
<hr>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Double </th>
			<th>High </th>
			<th>Percent Tax </th>
<?php
//Authorization.
$auth->roleid="4844";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4845";//Add
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
		$fields="hrm_payes.id, hrm_payes.low, hrm_payes.high, hrm_payes.percent";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$payes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo formatNumber($row->low); ?></td>
			<td><?php echo formatNumber($row->high); ?></td>
			<td><?php echo formatNumber($row->percent); ?></td>
<?php
//Authorization.
$auth->roleid="4844";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpayes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4845";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
