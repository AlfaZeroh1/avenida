<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Modules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Modules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="141";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$modules=new Modules();
if(!empty($delid)){
	$modules->id=$delid;
	$modules->delete($modules);
	redirect("modules.php");
}
//Authorization.
$auth->roleid="140";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addmodules_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Description </th>
			<th>URl </th>
			<th>Position </th>
			<th>Status </th>
			<th>Index Page </th>
<?php
//Authorization.
$auth->roleid="142";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="143";//View
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
		$fields="sys_modules.id, sys_modules.name, sys_modules.description, sys_modules.url, sys_modules.position, sys_modules.status, sys_modules.indx";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$modules->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->url; ?></td>
			<td><?php echo $row->position; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->indx; ?></td>
<?php
//Authorization.
$auth->roleid="142";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmodules_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="143";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='modules.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
