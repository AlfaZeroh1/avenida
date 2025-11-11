<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Routes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Routes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7455";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$routes=new Routes();
if(!empty($delid)){
	$routes->id=$delid;
	$routes->delete($routes);
	redirect("routes.php");
}
//Authorization.
$auth->roleid="7454";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addroutes_proc.php',600,430);" value="Add Routes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Work Flow Title </th>
			<th>Module Associated </th>
			<th> Role </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7456";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7457";//View
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
		$fields="wf_routes.id, wf_routes.name, sys_modules.description as moduleid, auth_roles.name roleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
		$join=" left join sys_modules on wf_routes.moduleid=sys_modules.id left join auth_roles on auth_roles.id=wf_routes.roleid ";
		$having="";
		$groupby="";
		$orderby="";
		$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$routes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="route.php?id=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo $row->moduleid; ?></td>
			<td><?php echo $row->roleid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7456";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addroutes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7457";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='../routedetails/routedetails.php?id=<?php echo $row->id; ?>'>Details</a></td>
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
