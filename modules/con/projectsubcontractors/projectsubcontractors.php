<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectsubcontractors_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectsubcontractors";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8432";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectsubcontractors=new Projectsubcontractors();
if(!empty($delid)){
	$projectsubcontractors->id=$delid;
	$projectsubcontractors->delete($projectsubcontractors);
	redirect("projectsubcontractors.php");
}
//Authorization.
$auth->roleid="8431";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addprojectsubcontractors_proc.php',600,430);">Add Projectsubcontractors</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Sub Contractor </th>
			<th>Project </th>
			<th>Contract No </th><!--
			<th>Physical Address </th>--><!--
			<th>Scope Of Work </th>-->
			<th>Contract Sum </th>
			<th>Date Awarded </th><!--
			<th>Acceptance Letter Date </th>--><!--
			<th>Contract Signed On </th>--><!--
			<th>Date Of Order To Commence </th>-->
			<th>Commencement Date </th>
			<th>Expected Completion Date </th><!--
			<th>Actual Completion Date </th>--><!--
			<th>Defects Liability Period Type </th>
			<th>Defects Liability Period </th>--><!--
			<th>Remarks </th>-->
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8433";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8434";//Add
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
		$fields="con_projectsubcontractors.id, proc_suppliers.name as supplierid, con_projects.name as projectid, con_projectsubcontractors.contractno, con_projectsubcontractors.physicaladdress, con_projectsubcontractors.scope, con_projectsubcontractors.value, con_projectsubcontractors.dateawarded, con_projectsubcontractors.acceptanceletterdate, con_projectsubcontractors.contractsignedon, con_projectsubcontractors.orderdatetocommence, con_projectsubcontractors.startdate, con_projectsubcontractors.expectedenddate, con_projectsubcontractors.actualenddate, con_projectsubcontractors.liabilityperiodtype, con_projectsubcontractors.liabilityperiod, con_projectsubcontractors.remarks, con_projectsubcontractors.statusid, con_projectsubcontractors.ipaddress, con_projectsubcontractors.createdby, con_projectsubcontractors.createdon, con_projectsubcontractors.lasteditedby, con_projectsubcontractors.lasteditedon";
		$join=" left join proc_suppliers on con_projectsubcontractors.supplierid=proc_suppliers.id  left join con_projects on con_projectsubcontractors.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectsubcontractors->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectsubcontractors->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->contractno; ?></td><!--
			<td><?php echo $row->physicaladdress; ?></td>--><!--
			<td><?php echo $row->scope; ?></td>-->
			<td><?php echo formatNumber($row->value); ?></td>
			<td><?php echo formatDate($row->dateawarded); ?></td><!--
			<td><?php echo formatDate($row->acceptanceletterdate); ?></td>--><!--
			<td><?php echo formatDate($row->contractsignedon); ?></td>--><!--
			<td><?php echo formatDate($row->orderdatetocommence); ?></td>-->
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo formatDate($row->expectedenddate); ?></td><!--
			<td><?php echo formatDate($row->actualenddate); ?></td>--><!--
			<td><?php echo $row->liabilityperiodtype; ?></td>
			<td><?php echo $row->liabilityperiod; ?></td>--><!--
			<td><?php echo $row->remarks; ?></td>-->
			<td><?php echo $row->statusid; ?></td>
<?php
//Authorization.
$auth->roleid="8433";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectsubcontractors_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8434";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectsubcontractors.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
