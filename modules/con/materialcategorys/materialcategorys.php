<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Materialcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Materialcategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7792";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$materialcategorys=new Materialcategorys();
if(!empty($delid)){
	$materialcategorys->id=$delid;
	$materialcategorys->delete($materialcategorys);
	redirect("materialcategorys.php");
}
//Authorization.
$auth->roleid="7791";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addmaterialcategorys_proc.php',600,430);">Materialcategorys</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-stripped table-codensed" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Material's Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7793";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7794";//View
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
		$fields="con_materialcategorys.id, con_materialcategorys.name, con_materialcategorys.remarks, con_materialcategorys.ipaddress, con_materialcategorys.createdby, con_materialcategorys.createdon, con_materialcategorys.lasteditedby, con_materialcategorys.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$materialcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$materialcategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7793";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmaterialcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7794";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='materialcategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
