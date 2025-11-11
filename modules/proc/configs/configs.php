<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Configs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Configs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8056";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$configs=new Configs();
if(!empty($delid)){
	$configs->id=$delid;
	$configs->delete($configs);
	redirect("configs.php");
}
//Authorization.
$auth->roleid="8055";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addconfigs_proc.php',600,430);" value="Add Configs " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Configuration Term </th>
			<th>Configuration Value </th>
<?php
//Authorization.
$auth->roleid="8057";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8058";//View
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
		$fields="proc_configs.id, proc_configs.name, proc_configs.value, proc_configs.ipaddress, proc_configs.createdby, proc_configs.createdon, proc_configs.lasteditedby, proc_configs.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$configs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->value; ?></td>
<?php
//Authorization.
$auth->roleid="8057";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addconfigs_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8058";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='configs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
