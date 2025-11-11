<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Dashboards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Dashboards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11767";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$dashboards=new Dashboards();
if(!empty($delid)){
	$dashboards->id=$delid;
	$dashboards->delete($dashboards);
	redirect("dashboards.php");
}
//Authorization.
$auth->roleid="11766";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('adddashboards_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" >
	<thead>
		<tr>
			<th>#</th>
			<th>Text </th>
			<th>Type </th>
			<th>Query </th>
			<th>CSS Class </th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="11768";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11769";//View
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
		$fields="sys_dashboards.id, sys_dashboards.name, sys_dashboards.type, sys_dashboards.query, sys_dashboards.cssclass, sys_dashboards.status, sys_dashboards.remarks, sys_dashboards.ipaddress, sys_dashboards.createdby, sys_dashboards.createdon, sys_dashboards.lasteditedby, sys_dashboards.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$dashboards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$dashboards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->query; ?></td>
			<td><?php echo $row->cssclass; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="11768";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddashboards_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11769";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='dashboards.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
