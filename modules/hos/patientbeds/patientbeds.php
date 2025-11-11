<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientbeds_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientbeds";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4508";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientbeds=new Patientbeds();
if(!empty($delid)){
	$patientbeds->id=$delid;
	$patientbeds->delete($patientbeds);
	redirect("patientbeds.php");
}
//Authorization.
$auth->roleid="4507";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientbeds_proc.php',600,430);" value="Add Patientbeds " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Bed </th>
			<th>Patient </th>
			<th> </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4509";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4510";//Add
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
		$fields="hos_patientbeds.id, hos_patientbeds.bedid, hos_patientbeds.patientid, hos_patientbeds.treatmentid, hos_patientbeds.allocatedon, hos_patientbeds.lefton, hos_patientbeds.createdby, hos_patientbeds.createdon, hos_patientbeds.lasteditedby, hos_patientbeds.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$patientbeds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientbeds->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->bedid; ?></td>
			<td><?php echo $row->patientid; ?></td>
			<td><?php echo $row->treatmentid; ?></td>
			<td><?php echo formatDate($row->allocatedon); ?></td>
			<td><?php echo formatDate($row->lefton); ?></td>
<?php
//Authorization.
$auth->roleid="4509";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientbeds_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4510";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientbeds.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
