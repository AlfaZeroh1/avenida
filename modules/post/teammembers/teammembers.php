<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teammembers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teammembers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8632";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

$id=$_GET['id'];

if(!empty($id)){
  $obj->id=$id;
  
  $query="select max(teamedon) teamedon from post_teammembers";
  $query.=" where id='$obj->id' ";
  $rs=mysql_query($query);
  $tm = mysql_fetch_object($rs);
  $obj->teamedon=$tm->teamedon;
}

if(empty($obj->teamedon)){
  $obj->teamedon=date("Y-m-d");
}



$delid=$_GET['delid'];
$teammembers=new Teammembers();
if(!empty($delid)){
	$teammembers->id=$delid;
	$teammembers->delete($teammembers);
	redirect("teammembers.php");
}
//Authorization.
$auth->roleid="8631";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addteammembers_proc.php?teamid=<?php echo $obj->id; ?>',600,430);" value="Add Teammembers " type="button"/></div>
<?php }?>
<form action="teammembers.php" method="POST">
<table align="width">
<tr>
  <td><input type="text" readonly name="teamedon" size="12" class="date_input" value="<?php echo $obj->teamedon; ?>"/>
      <input type="hidden" name="id" value="<?php echo $obj->id; ?>"/>
      <input type="submit" class="btn" name="action" value="Filter"/>
</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Team </th>
			<th>Member </th>
			<th>Role </th>
			<th>Constituted On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8633";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8634";//View
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
		$fields="post_teammembers.id, post_teams.name as teamid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, post_teamroles.name as teamroleid, post_teammembers.teamedon, post_teammembers.remarks, post_teammembers.ipaddress, post_teammembers.createdby, post_teammembers.createdon, post_teammembers.lasteditedby, post_teammembers.lasteditedon";
		$join=" left join post_teams on post_teammembers.teamid=post_teams.id  left join hrm_employees on post_teammembers.employeeid=hrm_employees.id  left join post_teamroles on post_teammembers.teamroleid=post_teamroles.id ";
		$having=" ";
		$groupby="";
		$orderby="";
		$where=" where post_teammembers.teamedon='$obj->teamedon' ";
		if(!empty($obj->id)){
		  $where.=" and post_teams.id='$obj->id' ";
		}
		$teammembers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teammembers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->teamid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->teamroleid; ?></td>
			<td><?php echo formatDate($row->teamedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8633";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addteammembers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8634";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='teammembers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
