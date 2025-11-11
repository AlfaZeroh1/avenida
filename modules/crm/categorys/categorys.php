<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Categorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4787";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categorys=new Categorys();
if(!empty($delid)){
	$categorys->id=$delid;
	$categorys->delete($categorys);
	redirect("categorys.php");
}
//Authorization.
$auth->roleid="4786";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcategorys_proc.php',600,430);" value="Add Categorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4788";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4789";//Add
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
		$fields="crm_categorys.id, crm_categorys.name, crm_categorys.remarks, crm_categorys.createdby, crm_categorys.createdon, crm_categorys.lasteditedby, crm_categorys.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$categorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4788";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4789";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='categorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
