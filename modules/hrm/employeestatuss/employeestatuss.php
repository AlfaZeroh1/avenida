<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeestatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeestatuss";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1166";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeestatuss=new Employeestatuss();
if(!empty($delid)){
	$employeestatuss->id=$delid;
	$employeestatuss->delete($employeestatuss);
	redirect("employeestatuss.php");
}
//Authorization.
$auth->roleid="1165";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeestatuss_proc.php',500,150);">ADD EMPLOYEE STATUS</a>
<?php }?>
<hr>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
<?php
//Authorization.
$auth->roleid="1167";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1168";//View
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
		$fields="hrm_employeestatuss.id, hrm_employeestatuss.name";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$employeestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeestatuss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="1167";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeestatuss_proc.php?id=<?php echo $row->id; ?>',500,150);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="1168";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeestatuss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
