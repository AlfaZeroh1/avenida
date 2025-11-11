<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Materialsubcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Materialsubcategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7796";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$materialsubcategorys=new Materialsubcategorys();
if(!empty($delid)){
	$materialsubcategorys->id=$delid;
	$materialsubcategorys->delete($materialsubcategorys);
	redirect("materialsubcategorys.php");
}
//Authorization.
$auth->roleid="7795";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addmaterialsubcategorys_proc.php',600,430);">Materialsubcategorys</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-sripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Material's Sub-Category </th>
			<th>Material Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7797";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7798";//View
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
		$fields="con_materialsubcategorys.id, con_materialsubcategorys.name, con_materialcategorys.name as categoryid, con_materialsubcategorys.remarks, con_materialsubcategorys.ipaddress, con_materialsubcategorys.createdby, con_materialsubcategorys.createdon, con_materialsubcategorys.lasteditedby, con_materialsubcategorys.lasteditedon";
		$join=" left join con_materialcategorys on con_materialsubcategorys.categoryid=con_materialcategorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$materialsubcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$materialsubcategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7797";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmaterialsubcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7798";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='materialsubcategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
