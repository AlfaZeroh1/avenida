<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projects";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2177";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projects=new Projects();
if(!empty($delid)){
	$projects->id=$delid;
	$projects->delete($projects);
	redirect("projects.php");
}
//Authorization.
$auth->roleid="2176";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addprojects_proc.php',600,430);" value="Add Projects " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project Name </th>
			<th>Location </th>
			<th>Description </th>
<?php
//Authorization.
$auth->roleid="2178";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2179";//View
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
		$fields="pos_projects.id, pos_projects.name, pos_locations.name as locationid, pos_projects.description, pos_projects.createdby, pos_projects.createdon, pos_projects.lasteditedby, pos_projects.lasteditedon, pos_projects.ipaddress";
		$join=" left join pos_locations on pos_projects.locationid=pos_locations.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projects->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->locationid; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="2178";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojects_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2179";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projects.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
