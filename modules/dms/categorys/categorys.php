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
$auth->roleid="7551";//View
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
$auth->roleid="7550";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcategorys_proc.php',600,430);" value="Add Categorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>DMS Category </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7552";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7553";//View
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
		$fields="dms_categorys.id, dms_categorys.name, dms_categorys.remarks, dms_categorys.ipaddress, dms_categorys.createdby, dms_categorys.createdon, dms_categorys.lasteditedby, dms_categorys.lasteditedon";
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
$auth->roleid="7552";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7553";//View
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
