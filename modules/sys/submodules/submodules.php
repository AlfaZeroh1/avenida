<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Submodules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Submodules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9583";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$submodules=new Submodules();
if(!empty($delid)){
	$submodules->id=$delid;
	$submodules->delete($submodules);
	redirect("submodules.php");
}
//Authorization.
$auth->roleid="9582";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addsubmodules_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Table Name </th>
			<th>Description </th>
			<th>Module </th>
			<th>Remarks </th>
			<th>Index Page </th>
			<th>URl </th>
			<th>Priority </th>
			<th>Status </th>
			<th>Type</th>
<?php
//Authorization.
$auth->roleid="9584";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9585";//View
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
		$fields="sys_submodules.id, sys_submodules.name, sys_submodules.description, sys_modules.name as moduleid, sys_submodules.remarks, sys_submodules.indx, sys_submodules.url, sys_submodules.priority, sys_submodules.status, sys_submodules.type";
		$join=" left join sys_modules on sys_submodules.moduleid=sys_modules.id ";
		$having="";
		$groupby="";
		$orderby="";
		$submodules->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		
		$res=$submodules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->moduleid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->indx; ?></td>
			<td><?php echo $row->url; ?></td>
			<td><?php echo $row->priority; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->type; ?></td>
<?php
//Authorization.
$auth->roleid="9584";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsubmodules_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="9585";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='submodules.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
