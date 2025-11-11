<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientvitalsigns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientvitalsigns";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4360";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientid = $_GET['patientid'];
$appointmentid=$_GET['appointmentid'];

$patientvitalsigns=new Patientvitalsigns();
if(!empty($delid)){
	$patientvitalsigns->id=$delid;
	$patientvitalsigns->delete($patientvitalsigns);
	redirect("patientvitalsigns.php");
}
//Authorization.
$auth->roleid="4359";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientvitalsigns_proc.php?patientid=<?php echo $patientid; ?>&appointmentid=<?php echo $appointmentid; ?>',600,430);" value="Add Patientvitalsigns " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Vital Sign </th>
			<th>Results </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4361";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4362";//View
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
		$fields="hos_patientvitalsigns.id, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patientvitalsigns.patientappointmentid, hos_vitalsigns.name as vitalsignid, hos_patientvitalsigns.results, hos_patientvitalsigns.remarks";
		$join=" left join hos_patients on hos_patientvitalsigns.patientid=hos_patients.id  left join hos_vitalsigns on hos_patientvitalsigns.vitalsignid=hos_vitalsigns.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patientvitalsigns.patientappointmentid = '$appointmentid' ";
		$patientvitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientvitalsigns->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->vitalsignid; ?></td>
			<td><?php echo $row->results; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4361";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientvitalsigns_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4362";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientvitalsigns.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
