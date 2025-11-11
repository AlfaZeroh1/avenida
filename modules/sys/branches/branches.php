<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Branches_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Branches";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9486";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$branches=new Branches();
if(!empty($delid)){
	$branches->id=$delid;
	$branches->delete($branches);
	redirect("branches.php");
}
//Authorization.
$auth->roleid="9485";//View
$auth->levelid=$_SESSION['level'];


$query="select pos_teams.id, sys_branches.id brancheid, sys_branches.name branchename, pos_teamroles.type teamroletype from pos_teams left join pos_teamdetails on pos_teamdetails.teamid=pos_teams.id left join sys_branches on sys_branches.id=pos_teams.brancheid left join pos_teamroles on pos_teamroles.id=pos_teamdetails.teamroleid where (pos_teams.status=0 or pos_teams.status is null or pos_teams.status='') and pos_teamdetails.employeeid='".$_SESSION['employeeid']."'";
$rw = mysql_fetch_object(mysql_query($query));

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addbranches_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Branch</th>
			<th>Remarks </th>
			<th>Printer</th>
			<th>Type </th>
			<th>Active Shift</th>
			<th>Started</th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9487";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9488";//View
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
		$fields="*, case when type='Center' then 'Selling Point' else type end type";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$branches->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		//check if there is an existing shift
		$query="select pos_shifts.name shiftid, pos_teams.startedon, pos_teams.id from pos_teams left join pos_shifts on pos_teams.shiftid=pos_shifts.id where pos_teams.brancheid='$row->id' and (pos_teams.status=0 or pos_teams.status is null or pos_teams.status='') order by id desc";
		$rs = mysql_query($query);
		$num = mysql_affected_rows();
		$rw = mysql_fetch_object($rs);
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->printer; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><a href="../../pos/teamdetails/teamdetailss.php?teamid=<?php echo $rw->id; ?>"><?php echo $rw->shiftid; ?></a></td>
			<td><?php echo $rw->startedon; ?></td>
			<td>
			<?php if($row->type=="Selling Point"){?>
			  <a href="../../pos/teams/teamss.php?brancheid=<?php echo $row->id; ?>">Shifts</a>
			<?php } ?>
			</td>
<?php
//Authorization.
$auth->roleid="9487";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbranches_proc.php?id=<?php echo $row->id; ?>',600,430);">Edit</a></td>
<?php
}
//Authorization.
$auth->roleid="9488";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td></td>
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
