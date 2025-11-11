<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checkitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Checkitems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8572";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$checkitems=new Checkitems();
if(!empty($delid)){
	$checkitems->id=$delid;
	$checkitems->delete($checkitems);
	redirect("checkitems.php");
}
//Authorization.
$auth->roleid="8571";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcheckitems_proc.php',600,430);" value="Add Checkitems " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Check Item </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8573";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8574";//View
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
		$fields="prod_checkitems.id, prod_checkitems.name, prod_checkitems.remarks, prod_checkitems.ipaddress, prod_checkitems.createdby, prod_checkitems.createdon, prod_checkitems.lasteditedby, prod_checkitems.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$checkitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$checkitems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8573";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcheckitems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8574";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='checkitems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
