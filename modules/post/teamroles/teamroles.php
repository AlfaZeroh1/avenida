<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teamroles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teamroles";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8636";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teamroles=new Teamroles();
if(!empty($delid)){
	$teamroles->id=$delid;
	$teamroles->delete($teamroles);
	redirect("teamroles.php");
}
//Authorization.
$auth->roleid="8635";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addteamroles_proc.php',600,430);" value="Add Teamroles " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Team Role </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8637";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8638";//View
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
		$fields="post_teamroles.id, post_teamroles.name, post_teamroles.remarks, post_teamroles.ipaddress, post_teamroles.createdby, post_teamroles.createdon, post_teamroles.lasteditedby, post_teamroles.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teamroles->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8637";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addteamroles_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8638";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='teamroles.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
