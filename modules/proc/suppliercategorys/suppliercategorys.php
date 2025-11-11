<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Suppliercategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Suppliercategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8076";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$suppliercategorys=new Suppliercategorys();
if(!empty($delid)){
	$suppliercategorys->id=$delid;
	$suppliercategorys->delete($suppliercategorys);
	redirect("suppliercategorys.php");
}
//Authorization.
$auth->roleid="8075";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsuppliercategorys_proc.php',600,430);" value="Add Suppliercategorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8077";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8078";//View
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
		$fields="proc_suppliercategorys.id, proc_suppliercategorys.name, proc_suppliercategorys.remarks, proc_suppliercategorys.createdby, proc_suppliercategorys.createdon, proc_suppliercategorys.lasteditedby, proc_suppliercategorys.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$suppliercategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$suppliercategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8077";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsuppliercategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8078";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='suppliercategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
