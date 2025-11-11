<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Ipaddress_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Ipaddress";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9290";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$ipaddress=new Ipaddress();
if(!empty($delid)){
	$ipaddress->id=$delid;
	$ipaddress->delete($ipaddress);
	redirect("ipaddress.php");
}
//Authorization.
$auth->roleid="9289";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addipaddress_proc.php',600,430);" value="Add Ipaddress " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Task</th>
			<th>IP Address</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9291";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9292";//Add
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
		$fields="sys_ipaddress.id, sys_ipaddress.task, sys_ipaddress.ipaddress, sys_ipaddress.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$ipaddress->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$ipaddress->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->task; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9291";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addipaddress_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9292";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='ipaddress.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
