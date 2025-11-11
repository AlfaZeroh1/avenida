<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklistcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Checklistcategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7756";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$checklistcategorys=new Checklistcategorys();
if(!empty($delid)){
	$checklistcategorys->id=$delid;
	$checklistcategorys->delete($checklistcategorys);
	redirect("checklistcategorys.php");
}
//Authorization.
$auth->roleid="7755";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addchecklistcategorys_proc.php',600,430);" value="Add Checklistcategorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7757";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7758";//View
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
		$fields="tender_checklistcategorys.id, tender_checklistcategorys.name, tender_checklistcategorys.remarks, tender_checklistcategorys.ipaddress, tender_checklistcategorys.createdby, tender_checklistcategorys.createdon, tender_checklistcategorys.lasteditedby, tender_checklistcategorys.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$checklistcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$checklistcategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7757";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addchecklistcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7758";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='checklistcategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
