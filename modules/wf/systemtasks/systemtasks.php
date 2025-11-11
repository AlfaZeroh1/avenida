<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Systemtasks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Systemtasks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7459";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../hd.php";

$delid=$_GET['delid'];
$systemtasks=new Systemtasks();
if(!empty($delid)){
	$systemtasks->id=$delid;
	$systemtasks->delete($systemtasks);
	redirect("systemtasks.php");
}
//Authorization.
$auth->roleid="7458";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsystemtasks_proc.php',600,430);" value="Add Systemtasks " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>System Task Title </th>
			<th>Action </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7460";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7461";//View
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
		$fields="wf_systemtasks.id, wf_systemtasks.name, wf_systemtasks.action, wf_systemtasks.remarks, wf_systemtasks.ipaddress, wf_systemtasks.createdby, wf_systemtasks.createdon, wf_systemtasks.lasteditedby, wf_systemtasks.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$systemtasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$systemtasks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->action; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7460";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsystemtasks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7461";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='systemtasks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
