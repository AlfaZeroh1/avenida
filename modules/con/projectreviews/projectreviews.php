<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectreviews_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectreviews";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7575";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectreviews=new Projectreviews();
if(!empty($delid)){
	$projectreviews->id=$delid;
	$projectreviews->delete($projectreviews);
	redirect("projectreviews.php");
}
//Authorization.
$auth->roleid="7574";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addprojectreviews_proc.php',800,430);">Add Projectreviews</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project </th>
			<th>Employee That Reviviewed </th>
			<th>Findings </th>
			<th>Recommendations </th>
			<th>Review Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7576";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7577";//View
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
		$fields="con_projectreviews.id, con_projects.name as projectid, hrm_employees.name as employeeid, con_projectreviews.findings, con_projectreviews.recommendations, con_projectreviews.reviewedon, con_projectreviews.remarks, con_projectreviews.ipaddress, con_projectreviews.createdby, con_projectreviews.createdon, con_projectreviews.lasteditedby, con_projectreviews.lasteditedon";
		$join=" left join con_projects on con_projectreviews.projectid=con_projects.id  left join hrm_employees on con_projectreviews.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectreviews->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectreviews->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->findings; ?></td>
			<td><?php echo $row->recommendations; ?></td>
			<td><?php echo formatDate($row->reviewedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7576";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectreviews_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7577";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectreviews.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
