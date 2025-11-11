<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teams";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8640";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teams=new Teams();
if(!empty($delid)){
	$teams->id=$delid;
	$teams->delete($teams);
	redirect("teams.php");
}
//Authorization.
$auth->roleid="8639";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addteams_proc.php',600,430);" value="Add Teams " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Team </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="8641";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8642";//View
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
		$fields="post_teams.id, post_teams.name, post_teams.remarks, post_teams.ipaddress, post_teams.createdby, post_teams.createdon, post_teams.lasteditedby, post_teams.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teams->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href='../teammembers/teammembers.php?id=<?php echo $row->id; ?>'>Members</a></td>
<?php
//Authorization.
$auth->roleid="8641";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addteams_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8642";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='teams.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
