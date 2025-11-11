<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Branchteams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Branchteams";

$ob = (object)$_GET;

//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11960";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$branchteams=new Branchteams();
if(!empty($delid)){
	$branchteams->id=$delid;
	$branchteams->delete($branchteams);
	redirect("branchteams.php");
}
//Authorization.
$auth->roleid="11959";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addbranchteams_proc.php?brancheid=<?php echo $ob->brancheid; ?>',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display"  >
	<thead>
		<tr>
			<th>#</th>
			<th>Location </th>
			<th>Role</th>
			<th>Number </th>
<?php
//Authorization.
$auth->roleid="11961";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11962";//Add
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
		$fields="pos_branchteams.id, sys_branches.name as brancheid, pos_teamroles.name as teamroleid, pos_branchteams.number, pos_branchteams.createdby, pos_branchteams.createdon, pos_branchteams.lasteditedby, pos_branchteams.lasteditedon, pos_branchteams.ipaddress";
		$join=" left join sys_branches on pos_branchteams.brancheid=sys_branches.id  left join pos_teamroles on pos_branchteams.teamroleid=pos_teamroles.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($ob->brancheid)){
		  $where=" where pos_branchteams.brancheid='$ob->brancheid' ";
		}
		$branchteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$branchteams->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->teamroleid; ?></td>
			<td><?php echo $row->number; ?></td>
<?php
//Authorization.
$auth->roleid="11961";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbranchteams_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11962";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='branchteams.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
