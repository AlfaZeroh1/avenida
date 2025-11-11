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
$auth->roleid="9044";//View
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
$auth->roleid="9043";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<a class="btn btn-info" href='addprojects_proc.php'>New Projects</a>
<?php }?>
<div style="clear:both;"></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer </th>
			<th>Customer Project </th>
			<th>Project Description </th>
			<th>Start Date </th>
			<th>Expected Completion Date </th>
			<th>Actual Completion Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9045";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9046";//View
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
		$fields="pm_projects.id, crm_customers.name as customerid, pm_projects.name, pm_projects.description, pm_projects.startdate, pm_projects.expectedcompletion, pm_projects.actualcompletion, pm_projects.remarks, pm_projects.ipaddress, pm_projects.createdby, pm_projects.createdon, pm_projects.lasteditedby, pm_projects.lasteditedon";
		$join=" left join crm_customers on pm_projects.customerid=crm_customers.id ";
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
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo formatDate($row->expectedcompletion); ?></td>
			<td><?php echo formatDate($row->actualcompletion); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9045";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addprojects_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9046";//View
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
